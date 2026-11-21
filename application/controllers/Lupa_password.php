<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_password extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username SSO', 'required|trim', array(
			'required' => 'Username SSO wajib diisi.'
		));
		$this->form_validation->set_rules('nik', 'NIK Pegawai', 'required|trim', array(
			'required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.'
		));

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Lupa Password | HRIS Klinik Hidayatullah';
			$this->load->view('lupa_password', $data);
			return;
		}

		$username  = trim((string)$this->input->post('username', TRUE));
		$nik       = trim((string)$this->input->post('nik', TRUE));
		$userIp    = $this->input->ip_address();
		$secretKey = (string)$this->config->item('recaptcha_secret_key');
		$recaptchaResponse = trim((string)$this->input->post('g-recaptcha-response'));

		if ($secretKey === '') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Konfigurasi reCAPTCHA Belum Diatur!</strong> Hubungi administrator server.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('lupa_password');
			return;
		}

		if (empty($recaptchaResponse)) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Peringatan!</strong> Silakan centang kotak verifikasi reCAPTCHA terlebih dahulu.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('lupa_password');
			return;
		}

		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . rawurlencode($secretKey) . "&response=" . rawurlencode($recaptchaResponse) . "&remoteip=" . rawurlencode($userIp);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 8);
		$caBundle = 'C:/xampp/apache/bin/curl-ca-bundle.crt';
		if (file_exists($caBundle)) {
			curl_setopt($ch, CURLOPT_CAINFO, $caBundle);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		}
		$output = curl_exec($ch);
		curl_close($ch);

		$status = json_decode((string)$output, true);
		if (!$status || empty($status['success'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Verifikasi Gagal!</strong> Verifikasi reCAPTCHA tidak valid. Silakan coba kembali.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('lupa_password');
			return;
		}

		$pegawai = $this->db->get_where('data_pegawai', array(
			'username' => $username,
			'nik'      => $nik
		))->row();

		if ($pegawai) {
			$this->session->set_userdata(array(
				'reset_id_pegawai'   => $pegawai->id_pegawai,
				'reset_username'     => $pegawai->username,
				'reset_nama_pegawai' => $pegawai->nama_pegawai,
				'reset_jabatan'      => $pegawai->jabatan,
				'reset_photo'        => $pegawai->photo
			));
			redirect('lupa_password/reset');
			return;
		}

		$this->ModelAudit->catat('autentikasi', 'reset_identitas_gagal', $nik, 'Verifikasi lupa password gagal untuk username "' . $username . '".', null, null, array('id' => null, 'nama' => $username, 'hak_akses' => 'guest'));

		$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Verifikasi Identitas Gagal!</strong> Kombinasi Username dan NIK tidak ditemukan dalam database kepegawaian.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>');
		redirect('lupa_password');
	}

	public function reset()
	{
		if (!$this->session->userdata('reset_id_pegawai')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Akses Ditolak!</strong> Silakan verifikasi identitas kepegawaian Anda terlebih dahulu.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('lupa_password');
			return;
		}

		$data['title']        = 'Atur Ulang Password | HRIS Klinik Hidayatullah';
		$data['nama_pegawai'] = $this->session->userdata('reset_nama_pegawai');
		$data['username']     = $this->session->userdata('reset_username');
		$data['jabatan']      = $this->session->userdata('reset_jabatan');
		$data['photo']        = $this->session->userdata('reset_photo');

		$this->load->view('reset_password', $data);
	}

	public function simpan_password()
	{
		if (!$this->session->userdata('reset_id_pegawai')) {
			redirect('lupa_password');
			return;
		}

		$min_len = (int)($this->config->item('min_password_length') ?: 8);
		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[' . $min_len . ']', array(
			'required'   => 'Password Baru wajib diisi.',
			'min_length' => 'Password Baru minimal harus ' . $min_len . ' karakter.'
		));
		$this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]', array(
			'required' => 'Konfirmasi Password wajib diisi.',
			'matches'  => 'Konfirmasi Password tidak cocok dengan Password Baru.'
		));

		if ($this->form_validation->run() == FALSE) {
			$this->reset();
			return;
		}

		$id_pegawai   = $this->session->userdata('reset_id_pegawai');
		$nama_pegawai = $this->session->userdata('reset_nama_pegawai');
		$password_baru = (string)$this->input->post('password_baru');

		$password_hash = password_hash($password_baru, PASSWORD_BCRYPT);
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('data_pegawai', array('password' => $password_hash));

		$this->ModelAudit->catat('autentikasi', 'reset_password_berhasil', $id_pegawai, 'Kata sandi akun ' . $nama_pegawai . ' diatur ulang lewat pemulihan mandiri.', null, null, array(
			'id'        => $id_pegawai,
			'nama'      => $nama_pegawai,
			'hak_akses' => 'recovery'
		));

		$this->session->unset_userdata(array(
			'reset_id_pegawai',
			'reset_username',
			'reset_nama_pegawai',
			'reset_jabatan',
			'reset_photo'
		));
		$this->session->sess_regenerate(TRUE);

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Pengaturan Ulang Berhasil!</strong> Password akun <b>' . htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8') . '</b> telah berhasil diperbarui. Silakan login dengan password baru Anda.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>');

		redirect('login');
	}

	public function batal()
	{
		$this->session->unset_userdata(array(
			'reset_id_pegawai',
			'reset_username',
			'reset_nama_pegawai',
			'reset_jabatan',
			'reset_photo'
		));
		redirect('login');
	}
}
