<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slip_Gaji extends CI_Controller {

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
		$data['title'] = "Slip Gaji Pegawai";
		$data['pegawai'] = $this->ModelPenggajian->get_data('data_pegawai')->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/slip_gaji', $data);
		$this->load->view('template_admin/footer');
	}

	private function _prepare_slip_data()
	{
		$nama  = $this->input->get_post('nama_pegawai', TRUE);
		$nik   = $this->input->get_post('nik', TRUE);
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');

		$target_nik = $nik;
		if (empty($target_nik) && !empty($nama)) {
			$row = $this->db->get_where('data_pegawai', array('nama_pegawai' => $nama))->row();
			if ($row) {
				$target_nik = $row->nik;
			}
		}

		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, true, $target_nik ?: '__NONE__');

		return array(
			'title'                => 'Slip Gaji Resmi Pegawai',
			'potongan'             => $payroll['potongan'],
			'print_slip'           => $payroll['rows'],
			'komponen_per_pegawai' => $payroll['komponen_per_pegawai'],
			'bulan'                => $payroll['bulan'],
			'tahun'                => $payroll['tahun']
		);
	}

	public function cetak_slip_gaji()
	{
		$data = $this->_prepare_slip_data();
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_slip_gaji', $data);
	}

	public function download_pdf()
	{
		$data = $this->_prepare_slip_data();
		if (empty($data['print_slip'])) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Slip Tidak Ditemukan!</strong> Data absensi/gaji pegawai pada periode tersebut belum tersedia.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			redirect('admin/slip_gaji');
			return;
		}
		$this->load->library('pdf_exporter');
		$html = $this->load->view('pdf/slip_gaji', $data, true);
		$nik  = $data['print_slip'][0]->nik;
		$this->pdf_exporter->stream($html, 'Slip_Gaji_' . $nik . '_' . $data['bulan'] . '_' . $data['tahun'], 'A4', 'portrait', true);
	}
}
