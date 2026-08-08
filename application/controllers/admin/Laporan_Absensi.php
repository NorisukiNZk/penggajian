<?php

class Laporan_Absensi extends CI_Controller {

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

	public function index() {	
		$data['title'] = "Laporan Absensi Pegawai";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi/laporan_absensi');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_absensi() {
		$data['title'] = "Cetak Laporan Absensi Pegawai";
	
		// Mengambil bulan dan tahun dari POST dengan filter XSS
		$bulan = $this->input->post('bulan', TRUE);
		$tahun = $this->input->post('tahun', TRUE);
	
		// Validasi input
		if (!empty($bulan) && !empty($tahun)) {
			$bulantahun = $bulan . $tahun;
		} else {
			// Jika tidak ada input, gunakan bulan dan tahun saat ini
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan . $tahun;
		}
	
		// Mengambil data kehadiran berdasarkan bulan dan tahun
		$data['lap_kehadiran'] = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan=? ORDER BY nama_pegawai ASC", array($bulantahun))->result();
	
		// Menyimpan bulan dan tahun ke dalam data untuk ditampilkan di view
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
	
		// Memuat view
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/absensi/cetak_absensi', $data);
	}
}

?>