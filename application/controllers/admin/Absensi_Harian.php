<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_Harian extends CI_Controller {

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

	/**
	 * Monitoring absensi hari ini
	 */
	public function index()
	{
		$data['title'] = "Monitoring Absensi Hari Ini";
		$data['absensi'] = $this->ModelAbsensiHarian->get_semua_absensi_hari_ini();
		$data['setting'] = $this->ModelAbsensiHarian->get_setting();
		$data['tanggal'] = date('d F Y');

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi_harian/monitoring', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Rekap absensi bulanan
	 */
	public function rekap()
	{
		$data['title'] = "Rekap Absensi Bulanan";

		$bulan = $this->input->get('bulan', TRUE) != '' ? $this->input->get('bulan', TRUE) : date('m');
		$tahun = $this->input->get('tahun', TRUE) != '' ? $this->input->get('tahun', TRUE) : date('Y');

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['rekap'] = $this->ModelAbsensiHarian->get_rekap_bulanan($bulan, $tahun);
		$data['setting'] = $this->ModelAbsensiHarian->get_setting();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi_harian/rekap', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Halaman setting aturan jam kerja
	 */
	public function setting()
	{
		$data['title'] = "Setting Aturan Absensi";
		$data['setting'] = $this->ModelAbsensiHarian->get_setting();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi_harian/setting', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Proses update setting
	 */
	public function update_setting()
	{
		$data = array(
			'jam_masuk'                 => $this->input->post('jam_masuk'),
			'toleransi_menit'           => $this->input->post('toleransi_menit'),
			'jam_pulang'                => $this->input->post('jam_pulang'),
			'batas_terlambat_berat'     => $this->input->post('batas_terlambat_berat'),
			'maks_terlambat_jadi_alpha' => $this->input->post('maks_terlambat_jadi_alpha')
		);

		$this->ModelAbsensiHarian->update_setting($data);

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Setting absensi berhasil diupdate!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/absensi_harian/setting');
	}

	/**
	 * Sinkronisasi data absensi harian ke tabel data_kehadiran
	 */
	public function sinkron_gaji()
	{
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if (empty($bulan) || empty($tahun)) {
			$bulan = date('m');
			$tahun = date('Y');
		}

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Sinkronisasi berhasil!</strong> Data absensi bulan ' . $bulan . '/' . $tahun . ' telah disinkronkan ke Data Kehadiran untuk perhitungan gaji.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/absensi_harian/rekap?bulan=' . $bulan . '&tahun=' . $tahun);
	}

	/**
	 * Detail absensi harian 1 pegawai
	 */
	public function detail($nik)
	{
		$data['title'] = "Detail Absensi Pegawai";

		$bulan = $this->input->get('bulan', TRUE) != '' ? $this->input->get('bulan', TRUE) : date('m');
		$tahun = $this->input->get('tahun', TRUE) != '' ? $this->input->get('tahun', TRUE) : date('Y');

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['nik'] = $nik;
		$data['detail'] = $this->ModelAbsensiHarian->get_detail_pegawai($nik, $bulan, $tahun);

		// Ambil data pegawai
		$data['pegawai'] = $this->db->get_where('data_pegawai', array('nik' => $nik))->row();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/absensi_harian/detail', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Update status absensi oleh admin (misal: set sakit/izin/alpha)
	 */
	public function update_status()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$keterangan = $this->input->post('keterangan');
		$nik = $this->input->post('nik');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$this->ModelAbsensiHarian->update_status($id, $status, $keterangan);

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Status absensi berhasil diubah!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/absensi_harian/detail/' . $nik . '?bulan=' . $bulan . '&tahun=' . $tahun);
	}

	/**
	 * Tambah record absensi manual oleh admin (untuk hari yang terlewat)
	 */
	public function tambah_manual()
	{
		$nik = $this->input->post('nik');
		$tanggal = $this->input->post('tanggal');
		$status = $this->input->post('status');
		$keterangan = $this->input->post('keterangan');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		// Cek apakah sudah ada di tanggal tersebut
		$existing = $this->db->get_where('absensi_harian', array(
			'nik' => $nik,
			'tanggal' => $tanggal
		))->row();

		if (!$existing) {
			$data = array(
				'nik'        => $nik,
				'tanggal'    => $tanggal,
				'status'     => $status,
				'keterangan' => $keterangan ? $keterangan : 'Input manual oleh admin'
			);
			$this->db->insert('absensi_harian', $data);

			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data absensi berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		} else {
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Data absensi untuk tanggal tersebut sudah ada!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		}

		redirect('admin/absensi_harian/detail/' . $nik . '?bulan=' . $bulan . '&tahun=' . $tahun);
	}
}
?>
