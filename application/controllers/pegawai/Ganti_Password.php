<?php

class Ganti_Password extends CI_Controller {

	public function index() 
	{
		$data['title'] = "Form Ganti Password";

		$this->load->view('template_pegawai/header',$data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/ganti_password', $data);
		$this->load->view('template_pegawai/footer');
	}

	public function ganti_password_aksi()
	{
		$passLama = $this->input->post('passLama');
		$passBaru = $this->input->post('passBaru');
		$ulangPass = $this->input->post('ulangPass');

		$this->form_validation->set_rules('passLama','password lama','required');
		$this->form_validation->set_rules('passBaru','password baru','required|matches[ulangPass]');
		$this->form_validation->set_rules('ulangPass','ulangi password baru','required');

		if($this->form_validation->run() != FALSE) {
			// Cek password lama di database
			$id_pegawai = $this->session->userdata('id_pegawai');
			$pegawai = $this->db->get_where('data_pegawai', array('id_pegawai' => $id_pegawai))->row();

			if($pegawai) {
				if(password_verify($passLama, $pegawai->password)) {
					// Password lama cocok, proses ganti password dengan BCRYPT
					$data = array('password' => password_hash($passBaru, PASSWORD_BCRYPT));
					$id = array('id_pegawai' => $id_pegawai);
					$this->ModelPenggajian->update_data('data_pegawai', $data, $id);
					
					$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Berhasil!</strong> Password Anda telah diperbarui. Silakan login kembali.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>');
					redirect('login');
				} else {
					// Password lama salah
					$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Gagal!</strong> Password Lama yang Anda masukkan salah.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div>');
					redirect('pegawai/ganti_password');
				}
			}
		}else{
			$data['title'] = "Form Ganti Password";

			$this->load->view('template_pegawai/header',$data);
			$this->load->view('template_pegawai/sidebar');
			$this->load->view('pegawai/ganti_password', $data);
			$this->load->view('template_pegawai/footer');
		}
	}
}

?>