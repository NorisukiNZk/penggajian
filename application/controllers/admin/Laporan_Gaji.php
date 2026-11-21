<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_gaji');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_gaji()
	{
		$bulan = $this->input->get_post('bulan', TRUE);
		$tahun = $this->input->get_post('tahun', TRUE);
		if (empty($bulan) || empty($tahun)) {
			$bulan = date('m');
			$tahun = date('Y');
		}

		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, true);

		$data['title']                = "Cetak Laporan Gaji Pegawai";
		$data['bulan']                = $payroll['bulan'];
		$data['tahun']                = $payroll['tahun'];
		$data['potongan']             = $payroll['potongan'];
		$data['cetak_gaji']           = $payroll['rows'];
		$data['komponen_per_pegawai'] = $payroll['komponen_per_pegawai'];

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}
