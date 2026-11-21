<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$data['title'] = "Dashboard Analytics";
		$hari_ini = date('Y-m-d');

		// 1. Metrik SDM & Absensi Hari Ini
		$data['total_pegawai'] = (int)$this->db->count_all('data_pegawai');

		$q_hadir = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal=? AND status='tepat_waktu'", array($hari_ini))->row();
		$data['hadir_hari_ini'] = $q_hadir ? (int)$q_hadir->total : 0;

		$q_terlambat = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal=? AND status='terlambat'", array($hari_ini))->row();
		$data['terlambat_hari_ini'] = $q_terlambat ? (int)$q_terlambat->total : 0;

		$q_sakit_izin = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal=? AND status IN ('sakit', 'izin')", array($hari_ini))->row();
		$data['sakit_izin_hari_ini'] = $q_sakit_izin ? (int)$q_sakit_izin->total : 0;

		// 2. Distribusi Jabatan
		$distribusi_jabatan = $this->db->query("SELECT jabatan, COUNT(*) as jumlah FROM data_pegawai GROUP BY jabatan ORDER BY jumlah DESC")->result();
		$label_jabatan = array();
		$data_jabatan = array();
		foreach ($distribusi_jabatan as $dj) {
			$label_jabatan[] = $dj->jabatan;
			$data_jabatan[] = (int)$dj->jumlah;
		}
		$data['label_jabatan'] = json_encode($label_jabatan);
		$data['data_jabatan']  = json_encode($data_jabatan);

		// 3. Tren 6 Bulan TERAKHIR (Kehadiran & Pengeluaran Payroll dari sumber tunggal)
		$tren = $this->ModelPenggajian->hitung_tren_6_bulan();
		$data['label_bulan']      = json_encode($tren['labels']);
		$data['trend_hadir']      = json_encode($tren['hadir']);
		$data['trend_sakit']      = json_encode($tren['sakit']);
		$data['trend_alpha']      = json_encode($tren['alpha']);
		$data['payroll_labels']   = json_encode($tren['labels']);
		$data['payroll_bersih']   = json_encode($tren['payroll_bersih']);
		$data['payroll_lembur']   = json_encode($tren['payroll_lembur']);
		$data['payroll_potongan'] = json_encode($tren['payroll_potongan']);

		// Ringkasan Estimasi Gaji Bulan Berjalan
		$payroll_bln = $this->ModelPenggajian->hitung_payroll_bulan(date('m'), date('Y'), false);
		$data['payroll_bulan_ini'] = $payroll_bln['kpi']['total_thp'];

		// 4. Hari Libur Nasional Terdekat
		$data['hari_libur'] = $this->db->query("SELECT * FROM hari_libur WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 5")->result();

		// 5. Antrean Persetujuan HRD
		$q_cuti     = $this->db->query("SELECT COUNT(*) AS total FROM data_cuti WHERE status_cuti IN ('Menunggu', 'Pending')")->row();
		$q_lembur   = $this->db->query("SELECT COUNT(*) AS total FROM data_lembur WHERE status IN ('Menunggu', 'Pending')")->row();
		$q_pinjaman = $this->db->query("SELECT COUNT(*) AS total FROM data_pinjaman WHERE status IN ('Menunggu', 'Pending')")->row();

		$data['pending_cuti']     = $q_cuti ? (int)$q_cuti->total : 0;
		$data['pending_lembur']   = $q_lembur ? (int)$q_lembur->total : 0;
		$data['pending_pinjaman'] = $q_pinjaman ? (int)$q_pinjaman->total : 0;
		$data['total_pending']    = $data['pending_cuti'] + $data['pending_lembur'] + $data['pending_pinjaman'];

		// 6. Log Aktivitas Terbaru
		$data['recent_logs'] = $this->ModelAudit->get_logs(array(), 5, 0);

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('template_admin/footer', $data);
	}
}
