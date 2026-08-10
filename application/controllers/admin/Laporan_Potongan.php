<?php
class Laporan_Potongan extends CI_Controller {

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
		$data['title'] = "Laporan Potongan Gaji";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/potongan_gaji/laporan_potongan_form');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_potongan() {
		$data['title'] = "Cetak Laporan Potongan Gaji";
	
		$bulan = $this->input->post('bulan', TRUE);
		$tahun = $this->input->post('tahun', TRUE);
	
		if (!empty($bulan) && !empty($tahun)) {
			$bulantahun = $bulan . $tahun;
		} else {
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan . $tahun;
		}
	
        // Ambil data potongan alpha master
        $data['potongan_master'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();

		// Ambil data kehadiran
		$data['potongan_gaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_jabatan.gaji_pokok, data_kehadiran.alpha 
            FROM data_pegawai 
            INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik 
            INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
            WHERE data_kehadiran.bulan = ? 
            ORDER BY data_pegawai.nama_pegawai ASC", array($bulantahun))->result();
            
        // Hitung total potongan dinamis per pegawai
        $data['komponen_per_pegawai'] = array();
		foreach ($data['potongan_gaji'] as $g) {
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			$data['komponen_per_pegawai'][$g->nik] = $potongan_dinamis;
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
	
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/potongan_gaji/cetak_laporan_potongan', $data);
	}
}
?>
