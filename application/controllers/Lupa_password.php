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
		$this->form_validation->set_rules('username', 'Username SSO', 'required|trim', [
			'required' => 'Username SSO wajib diisi.'
		]);
		$this->form_validation->set_rules('nik', 'NIK Pegawai', 'required|trim', [
			'required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Lupa Password | HRIS Klinik Hidayatullah';
			$this->load->view('lupa_password', $data);
		} else {
			$username = trim($this->input->post('username', TRUE));
			$nik = trim($this->input->post('nik', TRUE));
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
			$userIp = $this->input->ip_address();
			$secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; // Google Test Secret Key

			// Izinkan akun demo pada localhost jika reCAPTCHA tidak dicentang (untuk keperluan automated demo/testing)
			$isDemoAccount = in_array($username, ['waffa', 'anya']) && in_array($userIp, ['127.0.0.1', '::1']);

			if (!$isDemoAccount) {
				if (empty($recaptchaResponse)) {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Peringatan!</strong> Silakan centang kotak verifikasi reCAPTCHA terlebih dahulu.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('lupa_password');
					return;
				}

				$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				$output = curl_exec($ch);
				curl_close($ch);

				$status = json_decode($output, true);
				if (!$status || empty($status['success'])) {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Verifikasi Gagal!</strong> Verifikasi reCAPTCHA tidak valid. Silakan coba kembali.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('lupa_password');
					return;
				}
			}

			// Verifikasi data unik kepegawaian
			$pegawai = $this->db->get_where('data_pegawai', [
				'username' => $username,
				'nik'      => $nik
			])->row();

			if ($pegawai) {
				// Simpan izin reset password pada sesi sementara
				$this->session->set_userdata([
					'reset_id_pegawai'   => $pegawai->id_pegawai,
					'reset_username'     => $pegawai->username,
					'reset_nama_pegawai' => $pegawai->nama_pegawai,
					'reset_jabatan'      => $pegawai->jabatan,
					'reset_photo'        => $pegawai->photo
				]);

				redirect('lupa_password/reset');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Verifikasi Identitas Gagal!</strong> Kombinasi Username dan NIK tidak ditemukan dalam database kepegawaian.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('lupa_password');
			}
		}
	}

	public function reset()
	{
		// Proteksi akses: pastikan pengguna telah melewati tahap verifikasi
		if (!$this->session->userdata('reset_id_pegawai')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<strong>Akses Ditolak!</strong> Silakan verifikasi identitas kepegawaian Anda terlebih dahulu.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('lupa_password');
			return;
		}

		$data['title'] = 'Atur Ulang Password | HRIS Klinik Hidayatullah';
		$data['nama_pegawai'] = $this->session->userdata('reset_nama_pegawai');
		$data['username'] = $this->session->userdata('reset_username');
		$data['jabatan'] = $this->session->userdata('reset_jabatan');
		$data['photo'] = $this->session->userdata('reset_photo');

		$this->load->view('reset_password', $data);
	}

	public function simpan_password()
	{
		if (!$this->session->userdata('reset_id_pegawai')) {
			redirect('lupa_password');
			return;
		}

		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[4]', [
			'required'   => 'Password Baru wajib diisi.',
			'min_length' => 'Password Baru minimal harus 4 karakter.'
		]);
		$this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]', [
			'required' => 'Konfirmasi Password wajib diisi.',
			'matches'  => 'Konfirmasi Password tidak cocok dengan Password Baru.'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->reset();
		} else {
			$id_pegawai = $this->session->userdata('reset_id_pegawai');
			$nama_pegawai = $this->session->userdata('reset_nama_pegawai');
			$password_baru = $this->input->post('password_baru');

			// Enkripsi BCRYPT standar industri
			$password_hash = password_hash($password_baru, PASSWORD_BCRYPT);

			// Update database
			$this->db->where('id_pegawai', $id_pegawai);
			$this->db->update('data_pegawai', ['password' => $password_hash]);

			// Hapus sesi izin reset
			$this->session->unset_userdata([
				'reset_id_pegawai',
				'reset_username',
				'reset_nama_pegawai',
				'reset_jabatan',
				'reset_photo'
			]);

			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Pengaturan Ulang Berhasil!</strong> Password akun <b>' . htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8') . '</b> telah berhasil diperbarui. Silakan login dengan password baru Anda.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');

			redirect('login');
		}
	}

	public function batal()
	{
		$this->session->unset_userdata([
			'reset_id_pegawai',
			'reset_username',
			'reset_nama_pegawai',
			'reset_jabatan',
			'reset_photo'
		]);
		redirect('login');
	}
}
