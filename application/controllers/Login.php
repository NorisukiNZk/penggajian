<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->_rules();

		if($this->form_validation->run()==FALSE) {
			$this->load->view('login');
		}else{
			// --- 1. Verifikasi reCAPTCHA Terlebih Dahulu ---
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
			$userIp = $this->input->ip_address();
			$secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; // Google Test Secret Key
			$username = $this->input->post('username');

			// Izinkan akun demo pada localhost jika reCAPTCHA tidak dicentang (untuk keperluan automated demo/testing)
			$isDemoAccount = in_array($username, ['waffa', 'anya']) && in_array($userIp, ['127.0.0.1', '::1']);

			if(!$isDemoAccount) {
				if(empty($recaptchaResponse)) {
					$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Verifikasi reCAPTCHA Diperlukan!</strong> Mohon centang kotak verifikasi reCAPTCHA terlebih dahulu.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('login');
					exit;
				}

				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptchaResponse."&remoteip=".$userIp;
				
				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $url); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$output = curl_exec($ch); 
				curl_close($ch);      
				
				$status = json_decode($output, true);
				
				if(!$status || empty($status['success'])) {
					$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Verifikasi Captcha Gagal!</strong> Mohon centang ulang kotak verifikasi reCAPTCHA Anda.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('login');
					exit;
				}
			}
			// --- reCAPTCHA Verification End ---

			// --- 2. Jika reCAPTCHA Lolos, Baru Verifikasi Username & Password ---
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek = $this->ModelPenggajian->cek_login();

			// Mengecek apakah user ditemukan DAN password inputan cocok dengan hash BCRYPT di database
			if($cek == FALSE || !password_verify($password, $cek->password))
			{	
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-circle-xmark mr-1"></i> <strong>Username atau Password Salah!</strong> Mohon periksa kembali username dan password Anda.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
				exit;
			}else{
				$this->session->set_userdata('hak_akses',$cek->hak_akses);
				$this->session->set_userdata('nama_pegawai',$cek->nama_pegawai);
				$this->session->set_userdata('photo',$cek->photo);
				$this->session->set_userdata('id_pegawai',$cek->id_pegawai);
				$this->session->set_userdata('nik',$cek->nik);
                
                // Dynamic Time Greeting for SweetAlert Toast
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $jam = date('H');
                if ($jam >= 5 && $jam < 11) $sapaan = "Selamat Pagi ☀️";
                else if ($jam >= 11 && $jam < 15) $sapaan = "Selamat Siang 🌤️";
                else if ($jam >= 15 && $jam < 18) $sapaan = "Selamat Sore ⛅";
                else $sapaan = "Selamat Malam 🌙";

                $this->session->set_flashdata('welcome_msg', $sapaan . ', ' . $cek->nama_pegawai . '!');

				switch ($cek->hak_akses) {
					case 1 : redirect('admin/dashboard');
						break;
					case 2 : redirect('pegawai/dashboard');
						break;
					default:
						break;
				}
			}
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','password','required');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(''); // Redirect ke root URL (mengikuti default_controller) atau langsung ke login
	}
}
