<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

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

	/**
	 * Halaman utama absensi - tampilkan status hari ini + tombol absen
	 */
	public function index()
	{
		$data['title'] = "Absensi Harian";
		$nik = $this->session->userdata('nik');

		$data['absensi_hari_ini'] = $this->ModelAbsensiHarian->get_absensi_hari_ini($nik);
		$data['setting'] = $this->ModelAbsensiHarian->get_setting();
		$data['ringkasan'] = $this->ModelAbsensiHarian->get_ringkasan_bulan_ini($nik);

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/absensi', $data);
		$this->load->view('template_pegawai/footer');
	}

	/**
	 * Proses absen masuk
	 */
	public function absen_masuk()
	{
		$nik = $this->session->userdata('nik');

		// Cek apakah sudah absen hari ini
		$sudah_absen = $this->ModelAbsensiHarian->get_absensi_hari_ini($nik);
		if ($sudah_absen) {
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Anda sudah melakukan absen masuk hari ini!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('pegawai/absensi');
			return;
		}

		$this->ModelAbsensiHarian->absen_masuk($nik);

		$absensi = $this->ModelAbsensiHarian->get_absensi_hari_ini($nik);
		$status_text = ($absensi->status == 'tepat_waktu') ? 'Tepat Waktu ✅' : 'Terlambat ⚠️';

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Absen masuk berhasil!</strong> Jam: ' . $absensi->jam_masuk . ' | Status: ' . $status_text . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('pegawai/absensi');
	}

	/**
	 * Proses absen pulang
	 */
	public function absen_pulang()
	{
		$nik = $this->session->userdata('nik');

		// Cek apakah sudah absen masuk
		$absensi = $this->ModelAbsensiHarian->get_absensi_hari_ini($nik);
		if (!$absensi) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda belum absen masuk hari ini!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('pegawai/absensi');
			return;
		}

		// Cek apakah sudah absen pulang
		if ($absensi->jam_pulang) {
			$this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Anda sudah melakukan absen pulang hari ini!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('pegawai/absensi');
			return;
		}

		$this->ModelAbsensiHarian->absen_pulang($nik);

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Absen pulang berhasil!</strong> Jam: ' . date('H:i:s') . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('pegawai/absensi');
	}

	/**
	 * Riwayat absensi bulanan
	 */
	public function riwayat()
	{
		$data['title'] = "Riwayat Absensi";
		$nik = $this->session->userdata('nik');

		$bulan = $this->input->get('bulan', TRUE) != '' ? $this->input->get('bulan', TRUE) : date('m');
		$tahun = $this->input->get('tahun', TRUE) != '' ? $this->input->get('tahun', TRUE) : date('Y');

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['absensi'] = $this->ModelAbsensiHarian->get_absensi_bulan($nik, $bulan, $tahun);
		$data['ringkasan'] = $this->ModelAbsensiHarian->get_ringkasan_bulan_ini($nik);

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/riwayat_absensi', $data);
		$this->load->view('template_pegawai/footer');
	}
}
?>
