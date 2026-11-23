<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Gaji extends CI_Controller {

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
		$nik = $this->session->userdata('nik');
		$tahun_filter = trim((string)$this->input->get('tahun', TRUE));
		if ($tahun_filter !== '' && !ctype_digit($tahun_filter)) {
			$tahun_filter = '';
		}

		$history = $this->ModelPenggajian->hitung_payroll_pegawai_history($nik, $tahun_filter !== '' ? $tahun_filter : null);

		$data['title']              = "Data Gaji";
		$data['potongan']           = $history['potongan'];
		$data['gaji']               = $history['gaji'];
		$data['komponen_per_bulan'] = $history['komponen_per_bulan'];
		$data['diffs_per_bulan']    = $history['diffs_per_bulan'];
		$data['latest_diff']        = $history['latest_diff'];
		$data['available_years']    = $history['available_years'];
		$data['tahun_filter']       = $tahun_filter;

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/data_gaji', $data);
		$this->load->view('template_pegawai/footer');
	}

	private function _load_single_slip($id)
	{
		$nik = $this->session->userdata('nik');
		$row = $this->db->get_where('data_kehadiran', array('id_kehadiran' => (int)$id, 'nik' => $nik))->row();
		if (!$row) {
			return null;
		}
		$bulan = substr($row->bulan, 0, 2);
		$tahun = substr($row->bulan, 2, 4);
		$payroll = $this->ModelPenggajian->hitung_payroll_bulan($bulan, $tahun, false, $nik);
		if (empty($payroll['rows'])) {
			return null;
		}
		return array(
			'title'                => 'Cetak Slip Gaji',
			'potongan'             => $payroll['potongan'],
			'print_slip'           => $payroll['rows'],
			'komponen_per_pegawai' => $payroll['komponen_per_pegawai'],
			'bulan'                => $bulan,
			'tahun'                => $tahun
		);
	}

	public function cetak_slip($id)
	{
		$data = $this->_load_single_slip($id);
		if (!$data) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data slip gaji tidak ditemukan atau Anda tidak memiliki akses.</div>');
			redirect('pegawai/data_gaji');
			return;
		}
		$this->load->view('pegawai/cetak_slip_gaji', $data);
	}

	public function download_pdf($id)
	{
		$data = $this->_load_single_slip($id);
		if (!$data) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data slip gaji tidak ditemukan atau Anda tidak memiliki akses.</div>');
			redirect('pegawai/data_gaji');
			return;
		}
		$this->load->library('pdf_exporter');
		$html = $this->load->view('pdf/slip_gaji', $data, true);
		$this->pdf_exporter->stream($html, 'Slip_Gaji_' . $data['print_slip'][0]->nik . '_' . $data['bulan'] . '_' . $data['tahun'], 'A4', 'portrait', true);
	}
}
