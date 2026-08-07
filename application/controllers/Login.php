<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->_rules();

		if($this->form_validation->run()==FALSE) {
			$this->load->view('login');
		}else{
			// --- reCAPTCHA Verification Start ---
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
			$userIp = $this->input->ip_address();
			$secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"; // Google Test Secret Key

			if(empty($recaptchaResponse)) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Peringatan!</strong> Silakan centang kotak verifikasi "I\'m not a robot" terlebih dahulu.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
			}

			$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptchaResponse."&remoteip=".$userIp;
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch); 
			curl_close($ch);      
			
			$status = json_decode($output, true);
			
			if(!$status['success']) {
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Verifikasi Captcha Gagal!</strong> Terdeteksi sebagai aktivitas tidak sah (Bot).
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
			}
			// --- reCAPTCHA Verification End ---

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek = $this->ModelPenggajian->cek_login();

			// Mengecek apakah user ditemukan DAN password inputan cocok dengan hash BCRYPT di database
			if($cek == FALSE || !password_verify($password, $cek->password))
			{	
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Username atau Password Salah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
			}else{
				$this->session->set_userdata('hak_akses',$cek->hak_akses);
				$this->session->set_userdata('nama_pegawai',$cek->nama_pegawai);
				$this->session->set_userdata('photo',$cek->photo);
				$this->session->set_userdata('id_pegawai',$cek->id_pegawai);
				$this->session->set_userdata('nik',$cek->nik);
                
                // Dynamic Time Greeting for SweetAlert Toast
                date_default_timezone_set('Asia/Jakarta');
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
