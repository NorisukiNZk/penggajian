<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$data['title'] = 'Ringkasan Eksekutif';
		$hari_ini  = date('Y-m-d');
		$bulan_ini = date('m');
		$tahun_ini = date('Y');

		// 1. Metrik SDM & Kehadiran Hari Ini (Data Aktual)
		$data['total_pegawai'] = (int)$this->db->count_all('data_pegawai');

		$q_hadir = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal = ? AND status IN ('tepat_waktu', 'terlambat')", array($hari_ini))->row();
		$data['hadir_hari_ini'] = $q_hadir ? (int)$q_hadir->total : 0;

		$q_tepat = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal = ? AND status = 'tepat_waktu'", array($hari_ini))->row();
		$data['tepat_waktu_hari_ini'] = $q_tepat ? (int)$q_tepat->total : 0;

		$q_terlambat = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal = ? AND status = 'terlambat'", array($hari_ini))->row();
		$data['terlambat_hari_ini'] = $q_terlambat ? (int)$q_terlambat->total : 0;

		$q_sakit_izin = $this->db->query("SELECT COUNT(*) AS total FROM absensi_harian WHERE tanggal = ? AND status IN ('sakit', 'izin')", array($hari_ini))->row();
		$data['sakit_izin_hari_ini'] = $q_sakit_izin ? (int)$q_sakit_izin->total : 0;

		$data['persen_hadir'] = $data['total_pegawai'] > 0
			? round(($data['hadir_hari_ini'] / $data['total_pegawai']) * 100, 1)
			: 0;

		// 2. Estimasi Komitmen Gaji Dasar Bulanan & Kasbon Aktif
		$q_payroll = $this->db->query("
			SELECT COALESCE(SUM(j.gaji_pokok + j.tj_transport + j.uang_makan), 0) AS total_dasar
			FROM data_pegawai p
			INNER JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
		")->row();
		$data['estimasi_payroll'] = $q_payroll ? (float)$q_payroll->total_dasar : 0;

		$q_kasbon = $this->db->query("SELECT COUNT(*) AS jumlah, COALESCE(SUM(jumlah_pinjaman), 0) AS total_dana FROM data_pinjaman WHERE status = 'Disetujui'")->row();
		$data['kasbon_aktif_jumlah'] = $q_kasbon ? (int)$q_kasbon->jumlah : 0;
		$data['kasbon_aktif_dana']   = $q_kasbon ? (float)$q_kasbon->total_dana : 0;

		$q_lembur_bln = $this->db->query("
			SELECT COUNT(*) AS jumlah, COALESCE(SUM(durasi_jam), 0) AS total_jam
			FROM data_lembur
			WHERE DATE_FORMAT(tanggal_lembur, '%Y-%m') = ? AND status = 'Disetujui'
		", array($tahun_ini . '-' . $bulan_ini))->row();
		$data['lembur_bulan_jam'] = $q_lembur_bln ? (int)$q_lembur_bln->total_jam : 0;

		// 3. Antrean Persetujuan Pimpinan (Cuti, Lembur, Pinjaman)
		$data['pending_cuti_list'] = $this->db->query("
			SELECT c.id_cuti, c.jenis_cuti, c.tanggal_mulai, c.tanggal_akhir, c.status_approval, p.nama_pegawai, p.jabatan
			FROM data_cuti c
			INNER JOIN data_pegawai p ON c.nik = p.nik
			WHERE c.status_cuti IN ('Menunggu', 'Pending')
			ORDER BY (CASE WHEN c.status_approval = 'Diteruskan ke Direktur' THEN 0 ELSE 1 END), c.id_cuti DESC
			LIMIT 5
		")->result();

		$data['pending_lembur_list'] = $this->db->query("
			SELECT l.id_lembur, l.tanggal_lembur, l.durasi_jam, l.keterangan, p.nama_pegawai, p.jabatan
			FROM data_lembur l
			INNER JOIN data_pegawai p ON l.nik = p.nik
			WHERE l.status IN ('Pending', 'Menunggu')
			ORDER BY l.tanggal_lembur DESC
			LIMIT 5
		")->result();

		$data['pending_pinjaman_list'] = $this->db->query("
			SELECT p.id_pinjaman, p.jumlah_pinjaman, p.tenor_bulan, p.tgl_pengajuan, g.nama_pegawai, g.jabatan
			FROM data_pinjaman p
			INNER JOIN data_pegawai g ON p.nik = g.nik
			WHERE p.status IN ('Pending', 'Menunggu')
			ORDER BY p.id_pinjaman DESC
			LIMIT 5
		")->result();

		$q_c = $this->db->query("SELECT COUNT(*) AS total FROM data_cuti WHERE status_cuti IN ('Menunggu', 'Pending')")->row();
		$q_l = $this->db->query("SELECT COUNT(*) AS total FROM data_lembur WHERE status IN ('Pending', 'Menunggu')")->row();
		$q_p = $this->db->query("SELECT COUNT(*) AS total FROM data_pinjaman WHERE status IN ('Pending', 'Menunggu')")->row();

		$data['count_pending_cuti']     = $q_c ? (int)$q_c->total : 0;
		$data['count_pending_lembur']   = $q_l ? (int)$q_l->total : 0;
		$data['count_pending_pinjaman'] = $q_p ? (int)$q_p->total : 0;
		$data['total_pending']          = $data['count_pending_cuti'] + $data['count_pending_lembur'] + $data['count_pending_pinjaman'];

		// 4. Tren Kehadiran & Pengeluaran Payroll 6 Bulan Terakhir (Terpusat)
		$tren = $this->ModelPenggajian->hitung_tren_6_bulan();
		$data['label_bulan']      = json_encode($tren['labels']);
		$data['trend_hadir']      = json_encode($tren['hadir']);
		$data['trend_sakit']      = json_encode($tren['sakit']);
		$data['trend_alpha']      = json_encode($tren['alpha']);
		$data['payroll_labels']   = json_encode($tren['labels']);
		$data['payroll_bersih']   = json_encode($tren['payroll_bersih']);
		$data['payroll_lembur']   = json_encode($tren['payroll_lembur']);
		$data['payroll_potongan'] = json_encode($tren['payroll_potongan']);
		$data['payroll_diff']     = $this->ModelPenggajian->hitung_diff_payroll_terakhir();

		// 5. Komposisi Staf per Jabatan & Jadwal Libur Terdekat
		$data['komposisi_jabatan'] = $this->db->query("
			SELECT jabatan, COUNT(*) AS jumlah
			FROM data_pegawai
			GROUP BY jabatan
			ORDER BY jumlah DESC
		")->result();

		$data['hari_libur'] = $this->db->query("SELECT * FROM hari_libur WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 5")->result();

		$this->load->view('template_pimpinan/header', $data);
		$this->load->view('template_pimpinan/navbar', $data);
		$this->load->view('pimpinan/dashboard', $data);
		$this->load->view('template_pimpinan/footer', $data);
	}
}
