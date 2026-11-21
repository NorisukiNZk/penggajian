<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_Tahunan extends CI_Controller {

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
		$data['title'] = "Laporan Rekap Gaji Tahunan";

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_tahunan_form');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_tahunan()
	{
		$tahun = $this->input->get_post('tahun', TRUE);
		if (empty($tahun)) {
			$tahun = date('Y');
		}

		$data['title'] = "Cetak Laporan Gaji Tahunan";
		$data['tahun'] = $tahun;
		$data['rekap'] = $this->ModelPenggajian->hitung_payroll_tahunan($tahun);

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_laporan_tahunan', $data);
	}
}
