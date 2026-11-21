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

		// 4. Tren Kehadiran 6 Bulan Terakhir (Chart.js)
		$trend_query = $this->db->query("
			SELECT bulan, SUM(hadir) AS total_hadir, SUM(sakit) AS total_sakit, SUM(alpha) AS total_alpha
			FROM data_kehadiran
			GROUP BY bulan
			ORDER BY STR_TO_DATE(CONCAT('01', bulan), '%d%m%Y') DESC
			LIMIT 6
		")->result();
		$trend_query = array_reverse($trend_query);

		$nama_bulan  = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agt','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des');
		$label_bulan = array();
		$trend_hadir = array();
		$trend_sakit = array();
		$trend_alpha = array();

		foreach ($trend_query as $tq) {
			$b = substr($tq->bulan, 0, 2);
			$y = substr($tq->bulan, 2, 4);
			$label_bulan[] = (isset($nama_bulan[$b]) ? $nama_bulan[$b] : $b) . ' ' . $y;
			$trend_hadir[] = (int)$tq->total_hadir;
			$trend_sakit[] = (int)$tq->total_sakit;
			$trend_alpha[] = (int)$tq->total_alpha;
		}
		$data['label_bulan'] = json_encode($label_bulan);
		$data['trend_hadir'] = json_encode($trend_hadir);
		$data['trend_sakit'] = json_encode($trend_sakit);
		$data['trend_alpha'] = json_encode($trend_alpha);

		// 4B. Tren Pengeluaran Payroll 6 Bulan Terakhir (Data Aktual)
		$potongan_master = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$alpha_deduction = 0;
		foreach ($potongan_master as $pm) {
			if (strtolower($pm->potongan) === 'alpha') {
				$alpha_deduction = (float)$pm->jml_potongan;
			}
		}

		$payroll_labels   = array();
		$payroll_bersih   = array();
		$payroll_lembur   = array();
		$payroll_potongan = array();

		foreach ($trend_query as $tq) {
			$bln_code = $tq->bulan;
			$b = substr($bln_code, 0, 2);
			$y = substr($bln_code, 2, 4);
			$payroll_labels[] = (isset($nama_bulan[$b]) ? $nama_bulan[$b] : $b) . ' ' . $y;

			$rows_gaji = $this->db->query("
				SELECT p.nik, j.gaji_pokok, j.tj_transport, j.uang_makan, k.alpha
				FROM data_kehadiran k
				INNER JOIN data_pegawai p ON k.nik = p.nik
				INNER JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
				WHERE k.bulan = ?
				GROUP BY p.nik
			", array($bln_code))->result();

			$sum_bersih   = 0;
			$sum_lembur   = 0;
			$sum_potongan = 0;

			foreach ($rows_gaji as $rg) {
				$tj_din  = $this->ModelKomponen->hitung_total_tunjangan($rg->nik, $bln_code, $rg->gaji_pokok);
				$pot_din = $this->ModelKomponen->hitung_total_potongan($rg->nik, $bln_code, $rg->gaji_pokok);
				$lemb    = $this->ModelPenggajian->hitung_uang_lembur($rg->nik, $b, $y);
				$pinj    = $this->ModelPenggajian->hitung_potongan_pinjaman($rg->nik, $b, $y);

				$tunj_tot = (float)$rg->tj_transport + (float)$rg->uang_makan + (float)$tj_din['total'];
				$lemb_tot = (float)$lemb['uang_lembur'];
				$pot_tot  = ((float)$rg->alpha * $alpha_deduction) + (float)$pot_din['total'] + (float)$pinj['total'];
				$thp      = max(0, (float)$rg->gaji_pokok + $tunj_tot + $lemb_tot - $pot_tot);

				$sum_bersih   += $thp;
				$sum_lembur   += $lemb_tot;
				$sum_potongan += $pot_tot;
			}

			$payroll_bersih[]   = round($sum_bersih);
			$payroll_lembur[]   = round($sum_lembur);
			$payroll_potongan[] = round($sum_potongan);
		}

		$data['payroll_labels']   = json_encode($payroll_labels);
		$data['payroll_bersih']   = json_encode($payroll_bersih);
		$data['payroll_lembur']   = json_encode($payroll_lembur);
		$data['payroll_potongan'] = json_encode($payroll_potongan);

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
