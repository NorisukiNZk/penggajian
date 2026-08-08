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
}

?>