<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ganti_Password extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '3') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Akses Ditolak!</strong> Silakan masuk menggunakan akun Pimpinan.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('login');
		}
	}

	public function index() {
		$data['title'] = 'Keamanan & Kata Sandi';

		$this->load->view('template_pimpinan/header', $data);
		$this->load->view('template_pimpinan/navbar', $data);
		$this->load->view('pimpinan/ganti_password', $data);
		$this->load->view('template_pimpinan/footer', $data);
	}

	public function ganti_password_aksi() {
		$passLama  = $this->input->post('passLama');
		$passBaru  = $this->input->post('passBaru');
		$ulangPass = $this->input->post('ulangPass');

		$min_len = (int)($this->config->item('min_password_length') ?: 8);
		$this->form_validation->set_rules('passLama', 'password lama', 'required');
		$this->form_validation->set_rules('passBaru', 'password baru', 'required|min_length[' . $min_len . ']|matches[ulangPass]', array(
			'min_length' => 'Kata sandi baru minimal harus ' . $min_len . ' karakter.'
		));
		$this->form_validation->set_rules('ulangPass', 'konfirmasi password baru', 'required');

		if ($this->form_validation->run() !== FALSE) {
			$id_pegawai = $this->session->userdata('id_pegawai');
			$pegawai    = $this->db->get_where('data_pegawai', array('id_pegawai' => $id_pegawai))->row();

			if ($pegawai && password_verify($passLama, $pegawai->password)) {
				$this->ModelPenggajian->update_data(
					'data_pegawai',
					array('password' => password_hash($passBaru, PASSWORD_BCRYPT)),
					array('id_pegawai' => $id_pegawai)
				);
				$this->ModelAudit->catat('autentikasi', 'ganti_password', $pegawai->nik, $pegawai->nama_pegawai . ' memperbarui kata sandi akun Pimpinan.');
				$this->session->sess_regenerate(TRUE);

				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Kata Sandi Diperbarui!</strong> Silakan masuk kembali menggunakan kata sandi baru Anda.
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>');
				redirect('login');
				return;
			}

			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Kata sandi lama tidak sesuai.
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>');
			redirect('pimpinan/ganti_password');
			return;
		}

		$this->index();
	}
}
