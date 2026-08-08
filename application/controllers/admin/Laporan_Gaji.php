<?php

class Laporan_Gaji extends CI_Controller {

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
		$data['title'] = "Laporan Gaji Pegawai";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_gaji');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_gaji() {
		$data['title'] = "Cetak Laporan Gaji Pegawai";
	
		// Mengambil bulan dan tahun dari POST
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
	
		// Validasi input
		if (!empty($bulan) && !empty($tahun)) {
			$bulantahun = $bulan . $tahun;
		} else {
			// Jika tidak ada input, gunakan bulan dan tahun saat ini
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan . $tahun;
		}
	
		// Mengambil data potongan gaji
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
	
		// Mengambil data gaji berdasarkan bulan dan tahun
		$data['cetak_gaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai,
			data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok,
			data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha 
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ?
			GROUP BY data_pegawai.nik
			ORDER BY data_pegawai.nama_pegawai ASC", array($bulantahun))->result();

		// Komponen dinamis per pegawai
		$data['komponen_per_pegawai'] = array();
		foreach ($data['cetak_gaji'] as $g) {
			$tunjangan = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan' => $tunjangan,
				'potongan'  => $potongan_dinamis
			);
		}
	
		// Menyimpan bulan dan tahun ke dalam data untuk ditampilkan di view
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
	
		// Memuat view
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}

?>