<?php

class Data_Pegawai extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if($this->session->userdata('hak_akses') != '1'){
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('login');
		}
	}
	
	public function index()
	{
		$data['title'] = "Data Pegawai";
		$data['pegawai'] = $this->ModelPenggajian->get_data('data_pegawai')->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/data_pegawai', $data);
		$this->load->view('template_admin/footer');
	}

	public function tambah_data() 
	{
		$data['title'] = "Tambah Data Pegawai";
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();
		
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/tambah_dataPegawai', $data);
		$this->load->view('template_admin/footer');
	}

	public function tambah_data_aksi() {
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->tambah_data();
		} else {
			$nik			= $this->input->post('nik');
			$nama_pegawai	= $this->input->post('nama_pegawai');
			$username		= $this->input->post('username');
			$password		= password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			$jenis_kelamin	= $this->input->post('jenis_kelamin');
			$jabatan		= $this->input->post('jabatan');
			$tanggal_masuk	= $this->input->post('tanggal_masuk');
			$status			= $this->input->post('status');
			$hak_akses		= $this->input->post('hak_akses');
			$photo			= $_FILES['photo']['name'];
			if($photo==''){}else{
				$config['upload_path'] 		= './photo';
				$config['allowed_types'] 	= 'jpg|jpeg|png|tiff';
				$config['max_size']			= 	2048;
				$config['file_name']		= 	'pegawai-'.date('ymd').'-'.substr(md5(rand()),0,10);
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload('photo')){
					echo "Photo Gagal Diupload !";
				}else{
					$photo=$this->upload->data('file_name');
				}
			}

			$data = array(
				'nik' 			=> $nik,
				'nama_pegawai' 	=> $nama_pegawai,
				'username' 		=> $username,
				'password' 		=> $password,
				'jenis_kelamin' => $jenis_kelamin,
				'jabatan' 		=> $jabatan,
				'tanggal_masuk' => $tanggal_masuk,
				'status' 		=> $status,
				'hak_akses' 	=> $hak_akses,
				'photo' 		=> $photo,
			);

			$this->ModelPenggajian->insert_data($data, 'data_pegawai');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/data_pegawai');
		}

	}

	public function update_data($id) 
	{
		$where = array('id_pegawai' => $id);
		$data['title'] = "Update Data Pegawai";
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();
		$data['pegawai'] = $this->db->get_where('data_pegawai', $where)->result();
		
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/update_dataPegawai', $data);
		$this->load->view('template_admin/footer');
	}

	

	public function update_data_aksi() {
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->update_data();
		} else {
			$id				= $this->input->post('id_pegawai');
			$nik			= $this->input->post('nik');
			$nama_pegawai	= $this->input->post('nama_pegawai');
			$username		= $this->input->post('username');
			$password_input	= $this->input->post('password');
			$jenis_kelamin	= $this->input->post('jenis_kelamin');
			$jabatan		= $this->input->post('jabatan');
			$tanggal_masuk	= $this->input->post('tanggal_masuk');
			$status			= $this->input->post('status');
			$hak_akses		= $this->input->post('hak_akses');
			$photo			= $_FILES['photo']['name'];
			if($photo){
				$config['upload_path'] 		= './photo';
				$config['allowed_types'] 	= 'jpg|jpeg|png|tiff';
				$config['max_size']			= 	2048;
				$config['file_name']		= 	'pegawai-'.date('ymd').'-'.substr(md5(rand()),0,10);
				$this->load->library('upload',$config);
				if($this->upload->do_upload('photo')){
					$photo=$this->upload->data('file_name');
					$this->db->set('photo',$photo);
				}else{
					echo $this->upload->display_errors();
				}
			}

			$data = array(
				'nik' 			=> $nik,
				'nama_pegawai' 	=> $nama_pegawai,
				'username' 		=> $username,
				'jenis_kelamin' => $jenis_kelamin,
				'jabatan' 		=> $jabatan,
				'tanggal_masuk' => $tanggal_masuk,
				'status' 		=> $status,
				'hak_akses' 	=> $hak_akses,
			);
			
			// Hanya update password jika diisi
			if (!empty($password_input)) {
				$data['password'] = password_hash($password_input, PASSWORD_BCRYPT);
			}

			$where = array(
				'id_pegawai' => $id

			);

			$this->ModelPenggajian->update_data('data_pegawai', $data, $where);
			
			// Jika admin mengubah datanya sendiri, update session secara real-time
			if ($this->session->userdata('id_pegawai') == $id) {
				$this->session->set_userdata('hak_akses', $hak_akses);
				$this->session->set_userdata('nama_pegawai', $nama_pegawai);
				$this->session->set_userdata('nik', $nik);
				if (!empty($photo)) {
					$this->session->set_userdata('photo', $photo);
				}
			}

			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data berhasil diupdate!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/data_pegawai');
		}
	}

	public function _rules() {
		$id_pegawai = $this->input->post('id_pegawai');
		if (empty($id_pegawai)) {
			// Jika tambah data
			$this->form_validation->set_rules('nik','NIK','required|is_unique[data_pegawai.nik]', array('is_unique' => '%s sudah terdaftar!'));
		} else {
			// Jika update data
			$this->form_validation->set_rules('nik','NIK','required|callback_check_nik_update');
		}

		$this->form_validation->set_rules('nama_pegawai','Nama Pegawai','required');
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
		$this->form_validation->set_rules('tanggal_masuk','Tanggal Masuk','required|callback_check_tanggal_masuk');
		$this->form_validation->set_rules('jabatan','Jabatan','required');
		$this->form_validation->set_rules('status','Status','required');
	}

	public function check_nik_update($nik) {
		$id_pegawai = $this->input->post('id_pegawai');
		$query = $this->db->query("SELECT * FROM data_pegawai WHERE nik = ? AND id_pegawai != ?", array($nik, $id_pegawai));
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('check_nik_update', '{field} sudah terdaftar!');
			return FALSE;
		}
		return TRUE;
	}

	public function check_tanggal_masuk($date) {
		if (strtotime($date) > time()) {
			$this->form_validation->set_message('check_tanggal_masuk', '{field} tidak boleh melebihi hari ini.');
			return FALSE;
		}
		return TRUE;
	}

	public function delete_data($id) {
		$pegawai = $this->db->get_where('data_pegawai', array('id_pegawai' => $id))->row();
		if (!$pegawai) {
			redirect('admin/data_pegawai');
			return;
		}

		// Proteksi: cegah admin menghapus akunnya sendiri yang sedang aktif
		if ($this->session->userdata('id_pegawai') == $id) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/data_pegawai');
			return;
		}

		$nik = $pegawai->nik;

		// Hapus cascading seluruh data terkait dalam transaksi atomik
		$this->db->trans_start();

		// 1. Bersihkan file berkas cuti
		$cuti_list = $this->db->get_where('data_cuti', array('nik' => $nik))->result();
		foreach ($cuti_list as $c) {
			if (!empty($c->file_lampiran) && file_exists('./uploads/cuti/' . $c->file_lampiran)) {
				@unlink('./uploads/cuti/' . $c->file_lampiran);
			}
		}
		$this->db->where('nik', $nik)->delete('data_cuti');

		// 2. Bersihkan file berkas pinjaman
		$pinjaman_list = $this->db->get_where('data_pinjaman', array('nik' => $nik))->result();
		foreach ($pinjaman_list as $p) {
			if (!empty($p->file_ktp) && file_exists('./uploads/pinjaman/' . $p->file_ktp)) {
				@unlink('./uploads/pinjaman/' . $p->file_ktp);
			}
			if (!empty($p->file_jaminan) && file_exists('./uploads/pinjaman/' . $p->file_jaminan)) {
				@unlink('./uploads/pinjaman/' . $p->file_jaminan);
			}
		}
		$this->db->where('nik', $nik)->delete('data_pinjaman');

		// 3. Bersihkan data lembur
		$this->db->where('nik', $nik)->delete('data_lembur');

		// 4. Bersihkan absensi harian & kehadiran
		$this->db->where('nik', $nik)->delete('absensi_harian');
		$this->db->where('nik', $nik)->delete('data_kehadiran');

		// 5. Bersihkan komponen gaji override
		$this->db->where('nik', $nik)->delete('komponen_gaji_pegawai');

		// 6. Hapus foto pegawai jika bukan avatar default
		if (!empty($pegawai->photo) && !in_array($pegawai->photo, ['pegawai-default.png', 'default.png', 'default.jpg'])) {
			if (file_exists('./photo/' . $pegawai->photo)) {
				@unlink('./photo/' . $pegawai->photo);
			}
		}

		// 7. Hapus data pegawai utama
		$this->db->where('id_pegawai', $id)->delete('data_pegawai');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Terjadi kendala teknis saat menghapus data pegawai dan riwayat terkait.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		} else {
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Sukses!</strong> Data pegawai beserta seluruh riwayat terkait berhasil dihapus secara bersih.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		}

		redirect('admin/data_pegawai');
	}

	public function cetak()
	{
		$data['title'] = "Laporan Data Pegawai";
		$data['pegawai'] = $this->ModelPenggajian->get_data('data_pegawai')->result();

		// Load view untuk cetak resmi dengan Kop, Watermark & QR Code
		$this->load->view('admin/pegawai/cetak_laporan_pegawai', $data);
	}

}
?>