<?php
class Laporan_Lembur extends CI_Controller {

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
		$data['title'] = "Laporan Lembur Pegawai";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/lembur/laporan_lembur_form');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_lembur() {
		$data['title'] = "Cetak Laporan Lembur Pegawai";
	
		$bulan = $this->input->post('bulan', TRUE);
		$tahun = $this->input->post('tahun', TRUE);
	
		if (!empty($bulan) && !empty($tahun)) {
			$bulantahun = $tahun . '-' . $bulan;
		} else {
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $tahun . '-' . $bulan;
		}
	
		$data['lembur'] = $this->db->query("SELECT data_lembur.*, data_pegawai.nama_pegawai, data_pegawai.nik 
            FROM data_lembur 
            INNER JOIN data_pegawai ON data_lembur.nik = data_pegawai.nik 
            WHERE DATE_FORMAT(data_lembur.tanggal_lembur, '%Y-%m') = '$bulantahun' AND data_lembur.status = 'Disetujui' 
            ORDER BY data_lembur.tanggal_lembur ASC")->result();
            
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
	
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/lembur/cetak_laporan_lembur', $data);
	}
}
?>
