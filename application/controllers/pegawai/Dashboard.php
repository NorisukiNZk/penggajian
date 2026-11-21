<?php

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if($this->session->userdata('hak_akses') != '2'){
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
		$data['title'] = "Dashboard";
		$id=$this->session->userdata('id_pegawai');
		$nik=$this->session->userdata('nik');
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai=?", array($id))->result();

		// Data absensi hari ini
		$data['absensi_hari_ini'] = $this->ModelAbsensiHarian->get_absensi_hari_ini($nik);

		// Ringkasan kehadiran bulan ini
		$data['ringkasan'] = $this->ModelAbsensiHarian->get_ringkasan_bulan_ini($nik);

		// Setting absensi
		$data['setting'] = $this->ModelAbsensiHarian->get_setting();

		// Data Hari Libur Nasional (Terdekat)
		$data['hari_libur'] = $this->db->query("SELECT * FROM hari_libur WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 5")->result();

		$this->load->view('template_pegawai/header',$data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/dashboard', $data);
		$this->load->view('template_pegawai/footer');
	}

	public function update_foto()
	{
		$id_pegawai = $this->session->userdata('id_pegawai');
		$pegawai    = $this->db->get_where('data_pegawai', array('id_pegawai' => $id_pegawai))->row();

		if (!$pegawai || empty($_FILES['photo']['name'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Perhatian!</strong> Pilih file foto terlebih dahulu (JPG atau PNG, maks. 2 MB).
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>');
			redirect('pegawai/dashboard');
			return;
		}

		$config['upload_path']   = './photo';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;
		$config['file_name']     = 'pegawai-' . date('ymd') . '-' . substr(md5(uniqid('', true)), 0, 10);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('photo')) {
			$err = strip_tags($this->upload->display_errors('', ''));
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal Mengunggah Foto!</strong> ' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				</div>');
			redirect('pegawai/dashboard');
			return;
		}

		$new_photo = $this->upload->data('file_name');
		$old_photo = $pegawai->photo;

		$this->db->where('id_pegawai', $id_pegawai)->update('data_pegawai', array('photo' => $new_photo));
		$this->session->set_userdata('photo', $new_photo);

		$protected = array('kpmh.jpg', 'default.png', 'default.jpg', 'pegawai-default.png');
		if (!empty($old_photo) && !in_array($old_photo, $protected) && file_exists('./photo/' . $old_photo)) {
			@unlink('./photo/' . $old_photo);
		}

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Foto Profil Diperbarui!</strong> Foto baru Anda telah tersimpan dan aktif di portal.
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>');
		redirect('pegawai/dashboard');
	}
}

?>