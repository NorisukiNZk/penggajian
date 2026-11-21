<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Penggajian extends CI_Controller {

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

	private function _resolve_periode()
	{
		$bulan = $this->input->get_post('bulan', TRUE);
		$tahun = $this->input->get_post('tahun', TRUE);
		if (empty($bulan) || empty($tahun)) {
			$bulan = date('m');
			$tahun = date('Y');
		}
		return array(str_pad((string)$bulan, 2, '0', STR_PAD_LEFT), (string)$tahun);
	}

	public function index()
	{
		list($bulan, $tahun) = $this->_resolve_periode();
		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, true);

		$data['title']                = "Data Gaji Pegawai";
		$data['bulan']                = $payroll['bulan'];
		$data['tahun']                = $payroll['tahun'];
		$data['bulantahun']           = $payroll['bulantahun'];
		$data['potongan']             = $payroll['potongan'];
		$data['gaji']                 = $payroll['rows'];
		$data['komponen_per_pegawai'] = $payroll['komponen_per_pegawai'];
		$data['kpi']                  = $payroll['kpi'];

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/data_gaji', $data);
		$this->load->view('template_admin/footer');
	}

	public function cetak_gaji()
	{
		list($bulan, $tahun) = $this->_resolve_periode();
		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, true);

		$data['title']                = "Cetak Data Gaji Pegawai";
		$data['bulan']                = $payroll['bulan'];
		$data['tahun']                = $payroll['tahun'];
		$data['potongan']             = $payroll['potongan'];
		$data['cetak_gaji']           = $payroll['rows'];
		$data['komponen_per_pegawai'] = $payroll['komponen_per_pegawai'];

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}

	public function download_pdf()
	{
		list($bulan, $tahun) = $this->_resolve_periode();
		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, true);

		$data['title']                = "Laporan Rekapitulasi Gaji Pegawai";
		$data['bulan']                = $payroll['bulan'];
		$data['tahun']                = $payroll['tahun'];
		$data['potongan']             = $payroll['potongan'];
		$data['cetak_gaji']           = $payroll['rows'];
		$data['komponen_per_pegawai'] = $payroll['komponen_per_pegawai'];

		$this->load->library('pdf_exporter');
		$html = $this->load->view('pdf/daftar_gaji', $data, true);
		$this->pdf_exporter->stream($html, 'Rekap_Gaji_' . $payroll['bulan'] . '_' . $payroll['tahun'], 'A4', 'landscape', true);
	}
}
