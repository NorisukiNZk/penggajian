<?php
class Laporan_Pegawai extends CI_Controller {

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
		$data['title'] = "Laporan Pegawai";
        $data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/pegawai/laporan_pegawai_form', $data);
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_pegawai() {
		$data['title'] = "Cetak Laporan Pegawai";
	
		$jabatan = $this->input->post('jabatan', TRUE);
	
		if (!empty($jabatan) && $jabatan != 'semua') {
            $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE jabatan=? ORDER BY nama_pegawai ASC", array($jabatan))->result();
            $data['filter_jabatan'] = $jabatan;
		} else {
            $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai ORDER BY nama_pegawai ASC")->result();
            $data['filter_jabatan'] = "Semua Jabatan";
		}
	
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/pegawai/cetak_laporan_pegawai', $data);
	}
}
?>
