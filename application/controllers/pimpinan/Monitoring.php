<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '3') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Akses Ditolak!</strong> Silakan masuk menggunakan akun Pimpinan.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('login');
		}
	}

	public function index() {
		$tab = strtolower((string)$this->input->get('tab', TRUE));
		if (!in_array($tab, array('hari_ini', 'rekap', 'pegawai'))) {
			$tab = 'hari_ini';
		}

		$bulan = $this->input->get('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get('tahun', TRUE) ?: date('Y');

		$data['title']      = 'Monitoring SDM & Kehadiran';
		$data['active_tab'] = $tab;
		$data['bulan']      = $bulan;
		$data['tahun']      = $tahun;

		$data['absensi_hari_ini'] = $this->ModelAbsensiHarian->get_semua_absensi_hari_ini();
		$data['rekap_bulanan']    = $this->ModelAbsensiHarian->get_rekap_bulanan($bulan, $tahun);
		$data['pegawai_list']     = $this->db->query("
			SELECT p.*, j.gaji_pokok, j.tj_transport, j.uang_makan
			FROM data_pegawai p
			LEFT JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
			ORDER BY p.nama_pegawai ASC
		")->result();

		$this->load->view('template_pimpinan/header', $data);
		$this->load->view('template_pimpinan/navbar', $data);
		$this->load->view('pimpinan/monitoring', $data);
		$this->load->view('template_pimpinan/footer', $data);
	}
}
