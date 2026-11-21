<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login');
			return;
		}

		$userIp   = $this->input->ip_address();
		$username = trim((string)$this->input->post('username', TRUE));
		$password = (string)$this->input->post('password');

		// 1. Cek Rate Limiting Percobaan Login Gagal
		$max_attempts = (int)($this->config->item('login_max_attempts') ?: 5);
		$lockout_sec  = (int)($this->config->item('login_lockout_seconds') ?: 300);
		$lock_rem     = $this->ModelAudit->get_lockout_remaining($userIp, $username, $max_attempts, $lockout_sec);

		if ($lock_rem > 0) {
			$menit = (int)ceil($lock_rem / 60);
			$this->ModelAudit->catat('autentikasi', 'login_diblokir', $username, 'Percobaan login ditahan oleh pembatas laju selama ' . $lock_rem . ' detik.', null, null, array('id' => null, 'nama' => $username, 'hak_akses' => 'guest'));
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Terlalu Banyak Percobaan Gagal!</strong> Demi keamanan akun, silakan tunggu sekitar ' . $menit . ' menit (' . $lock_rem . ' detik) sebelum mencoba masuk kembali.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
			return;
		}

		// 2. Verifikasi reCAPTCHA v2
		$secretKey = (string)$this->config->item('recaptcha_secret_key');
		$recaptchaResponse = trim((string)$this->input->post('g-recaptcha-response'));

		if ($secretKey === '') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Konfigurasi reCAPTCHA Belum Diatur!</strong> Hubungi administrator untuk menyetel RECAPTCHA_SECRET_KEY di server produksi.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
			return;
		}

		if (empty($recaptchaResponse)) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Verifikasi reCAPTCHA Diperlukan!</strong> Mohon centang kotak verifikasi reCAPTCHA terlebih dahulu sebelum masuk.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
			return;
		}

		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . rawurlencode($secretKey) . "&response=" . rawurlencode($recaptchaResponse) . "&remoteip=" . rawurlencode($userIp);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
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
				<strong>Verifikasi Captcha Gagal!</strong> Mohon centang ulang kotak verifikasi reCAPTCHA Anda.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
			return;
		}

		// 3. Verifikasi Username & Password BCRYPT
		$cek = $this->ModelPenggajian->cek_login();

		if ($cek == FALSE || !password_verify($password, $cek->password)) {
			$this->ModelAudit->record_login_attempt($userIp, $username, false);
			$this->ModelAudit->catat('autentikasi', 'login_gagal', $username, 'Percobaan login gagal untuk username "' . $username . '".', null, null, array('id' => null, 'nama' => $username, 'hak_akses' => 'guest'));

			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-circle-xmark mr-1"></i> <strong>Username atau Password Salah!</strong> Mohon periksa kembali username dan password Anda.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
			return;
		}

		// 4. Login Sukses: Regenerasi ID Sesi & Simpan Kredensial
		$this->ModelAudit->record_login_attempt($userIp, $username, true);
		$this->session->sess_regenerate(TRUE);
		$this->session->set_userdata('hak_akses', $cek->hak_akses);
		$this->session->set_userdata('nama_pegawai', $cek->nama_pegawai);
		$this->session->set_userdata('jabatan', $cek->jabatan);
		$this->session->set_userdata('photo', $cek->photo);
		$this->session->set_userdata('id_pegawai', $cek->id_pegawai);
		$this->session->set_userdata('nik', $cek->nik);
		$this->session->set_flashdata('login_welcome', $cek->nama_pegawai);

		$this->ModelAudit->catat('autentikasi', 'login_berhasil', $cek->nik, $cek->nama_pegawai . ' berhasil masuk (hak akses ' . $cek->hak_akses . ').', null, null, array(
			'id'        => $cek->id_pegawai,
			'nama'      => $cek->nama_pegawai,
			'hak_akses' => $cek->hak_akses
		));

		switch ($cek->hak_akses) {
			case 1:
				redirect('admin/dashboard');
				break;
			case 2:
				redirect('pegawai/dashboard');
				break;
			case 3:
				redirect('pimpinan/dashboard');
				break;
			default:
				redirect('login');
				break;
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
	}

	public function logout()
	{
		if ($this->session->userdata('id_pegawai')) {
			$this->ModelAudit->catat('autentikasi', 'logout', $this->session->userdata('nik'), $this->session->userdata('nama_pegawai') . ' keluar dari sistem.');
		}
		$this->session->sess_destroy();
		redirect('');
	}
}
