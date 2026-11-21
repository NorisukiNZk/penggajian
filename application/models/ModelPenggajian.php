<?php

class ModelPenggajian extends CI_model{

	public function get_data($table) {
		return $this->db->get($table);
	}

	public function insert_data($data,$table){
		$this->db->insert($table, $data);
	}

	public function update_data($table, $data, $whare){
		$this->db->update($table, $data, $whare);
	}

	public function delete_data($whare,$table){
		$this->db->where($whare);
		$this->db->delete($table);
	}

	public function insert_batch($table = null, $data = array()) {
		$jumlah = count($data);
		if ($jumlah > 0) {
			$this->db->insert_batch($table, $data);
		}
	}

	public function get_data_pegawai_by_id($id) {
		return $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->row();
	}
	public function cek_login()
	{
		$username = $this->input->post('username', TRUE) ? trim($this->input->post('username', TRUE)) : trim(set_value('username'));

		$result = $this->db->where('username', $username)
							->limit(1)
							->get('data_pegawai');
		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return FALSE;
		}
	}

	public function hitung_uang_lembur($nik, $bulan, $tahun) {
		// Ambil tarif lembur per jam dari setting
		$setting = $this->db->get_where('setting_absensi', array('id' => 1))->row();
		$tarif_lembur = $setting ? $setting->tarif_lembur_per_jam : 20000;

		// Ambil semua pengajuan lembur yang DISETUJUI pada bulan tersebut
		$this->db->where('nik', $nik);
		$this->db->where('MONTH(tanggal_lembur)', $bulan);
		$this->db->where('YEAR(tanggal_lembur)', $tahun);
		$this->db->where('status', 'Disetujui');
		$data_lembur = $this->db->get('data_lembur')->result();

		$total_jam_aktual = 0;

		foreach ($data_lembur as $lembur) {
			// Cek data absensi harian (aktual) di hari tersebut
			$absen = $this->db->get_where('absensi_harian', array(
				'nik' => $nik,
				'tanggal' => $lembur->tanggal_lembur
			))->row();

			if ($absen && $absen->jam_pulang != '00:00:00' && !empty($absen->jam_pulang)) {
				$t_mulai   = strtotime($lembur->jam_mulai);
				$t_selesai = strtotime($lembur->jam_selesai);
				$t_pulang  = strtotime($absen->jam_pulang);

				// Tangani kasus shift lembur melewati tengah malam (misal 22:00 s/d 02:00)
				if ($t_selesai < $t_mulai) $t_selesai += 86400; 
				if ($t_pulang < $t_mulai && $t_pulang < strtotime('12:00:00')) $t_pulang += 86400; 

				// Validasi Silang (Ambil waktu selesai yang paling cepat: Sesuai Pengajuan atau Aktual Pulang?)
				$aktual_selesai = min($t_selesai, $t_pulang);

				if ($aktual_selesai > $t_mulai) {
					$interval = $aktual_selesai - $t_mulai;
					$jam_sah = round($interval / 3600); // Bulatkan ke jam terdekat
					$total_jam_aktual += $jam_sah;
				}
			} else {
				// Jika tidak ada data checkout harian (misal lembur hari libur/akhir pekan/tugas dinas luar),
				// gunakan durasi lembur yang telah diverifikasi dan disetujui secara resmi oleh Manajemen HRD
				$total_jam_aktual += (int) $lembur->durasi_jam;
			}
		}

		$uang_lembur = $total_jam_aktual * $tarif_lembur;

		return array(
			'total_jam' => $total_jam_aktual,
			'uang_lembur' => $uang_lembur,
			'tarif' => $tarif_lembur
		);
	}

	public function hitung_potongan_pinjaman($nik, $bulan, $tahun) {
		// Cari pinjaman yang disetujui untuk NIK ini
		$this->db->where('nik', $nik);
		$this->db->where('status', 'Disetujui');
		$pinjaman = $this->db->get('data_pinjaman')->result();

		$total_potongan = 0;
		$detail_cicilan = [];

		$pay_year  = (int) $tahun;
		$pay_month = (int) $bulan;

		foreach ($pinjaman as $p) {
			if (empty($p->tgl_disetujui) || $p->tgl_disetujui == '0000-00-00' || (int)$p->tenor_bulan <= 0) {
				continue;
			}

			$tgl_obj = date_create($p->tgl_disetujui);
			if (!$tgl_obj) {
				continue;
			}

			$start_year  = (int) date_format($tgl_obj, 'Y');
			$start_month = (int) date_format($tgl_obj, 'n');

			// Hitung selisih bulan kalender secara deterministik
			$months_passed = (($pay_year - $start_year) * 12) + ($pay_month - $start_month);
			$tenor = (int) $p->tenor_bulan;

			if ($months_passed >= 0 && $months_passed < $tenor) {
				$cicilan_ke = $months_passed + 1;
				$nominal_cicilan = ceil($p->jumlah_pinjaman / $tenor);
				
				$total_potongan += $nominal_cicilan;
				$detail_cicilan[] = array(
					'keterangan' => 'Potongan Pinjaman (Cicilan '.$cicilan_ke.'/'.$tenor.')',
					'nominal' => $nominal_cicilan
				);
			}
		}

		return array(
			'total' => $total_potongan,
			'detail' => $detail_cicilan
		);
	}

	/**
	 * Mengambil konfigurasi kuota cuti dari tabel setting_cuti
	 */
	public function get_setting_cuti() {
		$setting = $this->db->get_where('setting_cuti', array('id' => 1))->row();
		if (!$setting) {
			return (object) array(
				'id' => 1,
				'mode_kuota_cuti' => 'Kombinasi',
				'kuota_cuti_tahunan' => 12,
				'kuota_cuti_bulanan' => 5,
				'keterangan_kebijakan' => 'Kebijakan Standar: Jatah tahunan 12 hari dengan batas maksimal pengambilan 5 hari per bulan kerja.'
			);
		}
		return $setting;
	}

	/**
	 * Menghitung saldo cuti pegawai secara dinamis berdasarkan kebijakan aktif
	 */
	public function hitung_saldo_cuti($nik, $bulan = null, $tahun = null) {
		if ($bulan === null) $bulan = date('m');
		if ($tahun === null) $tahun = date('Y');

		$setting = $this->get_setting_cuti();
		$mode = $setting->mode_kuota_cuti;
		$kuota_tahunan = (int)$setting->kuota_cuti_tahunan;
		$kuota_bulanan = (int)$setting->kuota_cuti_bulanan;

		// 1. Hitung cuti terpakai tahun ini (Januari - Desember)
		$riwayat_tahun = $this->db->query("
			SELECT tanggal_mulai, tanggal_akhir 
			FROM data_cuti 
			WHERE nik = ? 
			  AND status_cuti = 'Disetujui' 
			  AND jenis_cuti = 'Tahunan'
			  AND YEAR(tanggal_mulai) = ?
		", array($nik, $tahun))->result();

		$cuti_terpakai_tahun = 0;
		foreach ($riwayat_tahun as $rc) {
			$start = new DateTime($rc->tanggal_mulai);
			$end = new DateTime($rc->tanggal_akhir);
			$end->modify('+1 day');
			$cuti_terpakai_tahun += $start->diff($end)->days;
		}

		// 2. Hitung cuti terpakai bulan ini
		$riwayat_bulan = $this->db->query("
			SELECT tanggal_mulai, tanggal_akhir 
			FROM data_cuti 
			WHERE nik = ? 
			  AND status_cuti = 'Disetujui' 
			  AND jenis_cuti = 'Tahunan'
			  AND MONTH(tanggal_mulai) = ?
			  AND YEAR(tanggal_mulai) = ?
		", array($nik, (int)$bulan, $tahun))->result();

		$cuti_terpakai_bulan = 0;
		foreach ($riwayat_bulan as $rc) {
			$start = new DateTime($rc->tanggal_mulai);
			$end = new DateTime($rc->tanggal_akhir);
			$end->modify('+1 day');
			$cuti_terpakai_bulan += $start->diff($end)->days;
		}

		// 3. Hitung sisa kuota berdasarkan mode yang aktif
		$sisa_tahunan = max(0, $kuota_tahunan - $cuti_terpakai_tahun);
		$sisa_bulanan = max(0, $kuota_bulanan - $cuti_terpakai_bulan);

		if ($mode == 'Bulanan') {
			$kuota_total_tampil = $kuota_bulanan;
			$terpakai_tampil    = $cuti_terpakai_bulan;
			$sisa_tampil        = $sisa_bulanan;
			$label_periode      = 'Bulan Ini (' . date('M Y', strtotime("$tahun-$bulan-01")) . ')';
		} elseif ($mode == 'Tahunan') {
			$kuota_total_tampil = $kuota_tahunan;
			$terpakai_tampil    = $cuti_terpakai_tahun;
			$sisa_tampil        = $sisa_tahunan;
			$label_periode      = 'Tahun ' . $tahun;
		} else { // Kombinasi
			$kuota_total_tampil = $kuota_tahunan;
			$terpakai_tampil    = $cuti_terpakai_tahun;
			$sisa_tampil        = min($sisa_tahunan, $sisa_bulanan);
			$label_periode      = 'Tahun ' . $tahun . ' (Maks. ' . $kuota_bulanan . ' hr/bln)';
		}

		return array(
			'setting'               => $setting,
			'mode'                  => $mode,
			'kuota_tahunan'         => $kuota_tahunan,
			'kuota_bulanan'         => $kuota_bulanan,
			'cuti_terpakai_tahun'   => $cuti_terpakai_tahun,
			'cuti_terpakai_bulan'   => $cuti_terpakai_bulan,
			'sisa_tahunan'          => $sisa_tahunan,
			'sisa_bulanan'          => $sisa_bulanan,
			'kuota_total_tampil'    => $kuota_total_tampil,
			'terpakai_tampil'       => $terpakai_tampil,
			'sisa_tampil'           => $sisa_tampil,
			'label_periode'         => $label_periode,
			'keterangan_kebijakan'  => $setting->keterangan_kebijakan
		);
	}

	private function _ensure_payroll_calculator()
	{
		if (!class_exists('Payroll_calculator', false)) {
			require_once APPPATH . 'libraries/Payroll_calculator.php';
		}
	}

	/**
	 * Layanan terpusat perhitungan payroll bulanan (dipakai Admin, Pimpinan, dan Cetak Daftar/Slip).
	 */
	public function hitung_payroll_bulan($bulan, $tahun, $sync_absensi = true, $filter_nik = null)
	{
		$this->_ensure_payroll_calculator();
		$bulan = str_pad((string)$bulan, 2, '0', STR_PAD_LEFT);
		$tahun = (string)$tahun;
		$bulantahun = $bulan . $tahun;

		if ($sync_absensi) {
			$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		}

		$potongan = $this->get_data('potongan_gaji')->result();
		$alpha_rate = Payroll_calculator::extractAlphaRate($potongan);

		$sql = "
			SELECT data_pegawai.nik, data_pegawai.nama_pegawai,
				   data_pegawai.jenis_kelamin, data_pegawai.photo, data_jabatan.nama_jabatan,
				   data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan,
				   data_kehadiran.alpha, data_kehadiran.bulan, data_kehadiran.id_kehadiran
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ?
		";
		$params = array($bulantahun);
		if ($filter_nik !== null && $filter_nik !== '') {
			$sql .= " AND data_pegawai.nik = ? ";
			$params[] = $filter_nik;
		}
		$sql .= " GROUP BY data_pegawai.nik ORDER BY data_pegawai.nama_pegawai ASC ";

		$rows = $this->db->query($sql, $params)->result();

		$gaji_pokok_map = array();
		foreach ($rows as $r) {
			$gaji_pokok_map[$r->nik] = (float)$r->gaji_pokok;
		}
		$komponen_batch = $this->ModelKomponen->get_batch_komponen_bulan($bulantahun, $gaji_pokok_map);

		$komponen_per_pegawai = array();
		$total_thp = 0;
		$total_pokok_tetap = 0;
		$total_variabel = 0;
		$total_potongan = 0;
		$total_jam_lembur = 0;

		foreach ($rows as $g) {
			$tj_din  = isset($komponen_batch[$g->nik]) ? $komponen_batch[$g->nik]['tunjangan'] : array('total' => 0, 'detail' => array());
			$pot_din = isset($komponen_batch[$g->nik]) ? $komponen_batch[$g->nik]['potongan'] : array('total' => 0, 'detail' => array());
			$lembur  = $this->hitung_uang_lembur($g->nik, $bulan, $tahun);
			$pinjaman = $this->hitung_potongan_pinjaman($g->nik, $bulan, $tahun);

			$komponen_per_pegawai[$g->nik] = array(
				'tunjangan'   => $tj_din,
				'potongan'    => $pot_din,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam'],
				'pinjaman'    => $pinjaman
			);

			$calc = Payroll_calculator::calculateSlip(array(
				'gaji_pokok'        => $g->gaji_pokok,
				'tj_transport'      => $g->tj_transport,
				'uang_makan'        => $g->uang_makan,
				'tunjangan_dinamis' => $tj_din['total'],
				'uang_lembur'       => $lembur['uang_lembur'],
				'alpha'             => $g->alpha,
				'alpha_rate'        => $alpha_rate,
				'potongan_dinamis'  => $pot_din['total'],
				'potongan_pinjaman' => $pinjaman['total']
			));

			$total_thp        += $calc['gaji_bersih_raw'];
			$total_pokok_tetap += $calc['gaji_dasar'];
			$total_variabel    += $calc['uang_lembur'] + $calc['tunjangan_dinamis'];
			$total_potongan    += $calc['total_potongan'];
			$total_jam_lembur  += (float)$lembur['total_jam'];
		}

		return array(
			'bulan'                => $bulan,
			'tahun'                => $tahun,
			'bulantahun'           => $bulantahun,
			'potongan'             => $potongan,
			'alpha_rate'           => $alpha_rate,
			'rows'                 => $rows,
			'komponen_per_pegawai' => $komponen_per_pegawai,
			'kpi' => array(
				'total_thp'          => $total_thp,
				'total_pokok_tetap'  => $total_pokok_tetap,
				'total_variabel'     => $total_variabel,
				'total_potongan'     => $total_potongan,
				'total_jam_lembur'   => $total_jam_lembur,
				'total_pegawai_gaji' => count($rows)
			)
		);
	}

	/**
	 * Riwayat gaji 1 pegawai terurut kronologis terbaru-ke-terlama (fix urutan string MMYYYY).
	 */
	public function hitung_payroll_pegawai_history($nik, $tahun_filter = null)
	{
		$this->_ensure_payroll_calculator();
		$this->ModelAbsensiHarian->sinkron_ke_kehadiran(date('m'), date('Y'));

		$potongan = $this->get_data('potongan_gaji')->result();
		$all_rows = $this->db->query("
			SELECT data_pegawai.nama_pegawai, data_pegawai.nik, data_jabatan.nama_jabatan,
				   data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan,
				   data_kehadiran.alpha, data_kehadiran.bulan, data_kehadiran.id_kehadiran
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.nik = ?
			ORDER BY STR_TO_DATE(CONCAT('01', data_kehadiran.bulan), '%d%m%Y') DESC, data_kehadiran.id_kehadiran DESC
		", array($nik))->result();

		$available_years = array();
		$filtered_rows = array();
		foreach ($all_rows as $r) {
			$yr = substr($r->bulan, 2, 4);
			if ($yr !== '' && !in_array($yr, $available_years, true)) {
				$available_years[] = $yr;
			}
			if ($tahun_filter === null || $tahun_filter === '' || $yr === (string)$tahun_filter) {
				$filtered_rows[] = $r;
			}
		}

		$komponen_per_bulan = array();
		foreach ($filtered_rows as $g) {
			$tj_din   = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $g->bulan, $g->gaji_pokok);
			$pot_din  = $this->ModelKomponen->hitung_total_potongan($g->nik, $g->bulan, $g->gaji_pokok);
			$b        = substr($g->bulan, 0, 2);
			$y        = substr($g->bulan, 2, 4);
			$pinjaman = $this->hitung_potongan_pinjaman($g->nik, $b, $y);
			$lembur   = $this->hitung_uang_lembur($g->nik, $b, $y);

			$komponen_per_bulan[$g->bulan] = array(
				'tunjangan'   => $tj_din,
				'potongan'    => $pot_din,
				'pinjaman'    => $pinjaman,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam']
			);
		}

		return array(
			'potongan'           => $potongan,
			'gaji'               => $filtered_rows,
			'komponen_per_bulan' => $komponen_per_bulan,
			'available_years'    => $available_years
		);
	}

	/**
	 * Rekap payroll tahunan seluruh pegawai tanpa duplikasi logika di controller.
	 */
	public function hitung_payroll_tahunan($tahun)
	{
		$this->_ensure_payroll_calculator();
		$tahun = (string)$tahun;
		$potongan_master = $this->get_data('potongan_gaji')->result();
		$alpha_rate = Payroll_calculator::extractAlphaRate($potongan_master);

		$pegawai = $this->db->query("
			SELECT p.nik, p.nama_pegawai, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
			FROM data_pegawai p
			INNER JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
			ORDER BY p.nama_pegawai ASC
		")->result();

		$kehadiran_rows = $this->db->query("
			SELECT nik, bulan, alpha
			FROM data_kehadiran
			WHERE RIGHT(bulan, 4) = ?
		", array($tahun))->result();

		$kehadiran_map = array();
		foreach ($kehadiran_rows as $kh) {
			$kehadiran_map[$kh->nik][$kh->bulan] = (int)$kh->alpha;
		}

		$rekap_tahunan = array();
		foreach ($pegawai as $p) {
			if (empty($kehadiran_map[$p->nik])) {
				continue;
			}
			$total_gaji_tunjangan = 0;
			$total_lembur = 0;
			$total_potongan = 0;
			$total_bersih = 0;

			foreach ($kehadiran_map[$p->nik] as $bulantahun => $alpha) {
				$bulan_loop = substr($bulantahun, 0, 2);
				$lembur     = $this->hitung_uang_lembur($p->nik, $bulan_loop, $tahun);
				$tj_din     = $this->ModelKomponen->hitung_total_tunjangan($p->nik, $bulantahun, $p->gaji_pokok);
				$pot_din    = $this->ModelKomponen->hitung_total_potongan($p->nik, $bulantahun, $p->gaji_pokok);
				$pinjaman   = $this->hitung_potongan_pinjaman($p->nik, $bulan_loop, $tahun);

				$calc = Payroll_calculator::calculateSlip(array(
					'gaji_pokok'        => $p->gaji_pokok,
					'tj_transport'      => $p->tj_transport,
					'uang_makan'        => $p->uang_makan,
					'tunjangan_dinamis' => $tj_din['total'],
					'uang_lembur'       => $lembur['uang_lembur'],
					'alpha'             => $alpha,
					'alpha_rate'        => $alpha_rate,
					'potongan_dinamis'  => $pot_din['total'],
					'potongan_pinjaman' => isset($pinjaman['total']) ? $pinjaman['total'] : 0
				));

				$total_gaji_tunjangan += $calc['gaji_dasar'] + $calc['tunjangan_dinamis'];
				$total_lembur         += $calc['uang_lembur'];
				$total_potongan       += $calc['total_potongan'];
				$total_bersih         += $calc['gaji_bersih_raw'];
			}

			if ($total_bersih > 0) {
				$rekap_tahunan[] = array(
					'nik'            => $p->nik,
					'nama_pegawai'   => $p->nama_pegawai,
					'jabatan'        => $p->nama_jabatan,
					'gaji_tunjangan' => $total_gaji_tunjangan,
					'uang_lembur'    => $total_lembur,
					'potongan'       => $total_potongan,
					'gaji_bersih'    => $total_bersih
				);
			}
		}

		return $rekap_tahunan;
	}

	/**
	 * Tren 6 bulan TERAKHIR (kronologis naik untuk Chart.js) meliputi kehadiran dan belanja payroll.
	 */
	public function hitung_tren_6_bulan()
	{
		$this->_ensure_payroll_calculator();
		$trend_query = $this->db->query("
			SELECT bulan, SUM(hadir) AS total_hadir, SUM(sakit) AS total_sakit, SUM(alpha) AS total_alpha
			FROM data_kehadiran
			GROUP BY bulan
			ORDER BY STR_TO_DATE(CONCAT('01', bulan), '%d%m%Y') DESC
			LIMIT 6
		")->result();
		$trend_query = array_reverse($trend_query);

		$labels = array();
		$hadir  = array();
		$sakit  = array();
		$alpha  = array();
		$payroll_bersih   = array();
		$payroll_lembur   = array();
		$payroll_potongan = array();

		foreach ($trend_query as $tq) {
			$b = substr($tq->bulan, 0, 2);
			$y = substr($tq->bulan, 2, 4);

			$labels[] = Payroll_calculator::formatPeriodLabel($tq->bulan, true);
			$hadir[]  = (int)$tq->total_hadir;
			$sakit[]  = (int)$tq->total_sakit;
			$alpha[]  = (int)$tq->total_alpha;

			$bulan_data = $this->hitung_payroll_bulan($b, $y, false);
			$sum_bersih = 0;
			foreach ($bulan_data['rows'] as $rg) {
				$komp = $bulan_data['komponen_per_pegawai'][$rg->nik];
				$calc = Payroll_calculator::calculateSlip(array(
					'gaji_pokok'        => $rg->gaji_pokok,
					'tj_transport'      => $rg->tj_transport,
					'uang_makan'        => $rg->uang_makan,
					'tunjangan_dinamis' => $komp['tunjangan']['total'],
					'uang_lembur'       => $komp['uang_lembur'],
					'alpha'             => $rg->alpha,
					'alpha_rate'        => $bulan_data['alpha_rate'],
					'potongan_dinamis'  => $komp['potongan']['total'],
					'potongan_pinjaman' => $komp['pinjaman']['total']
				));
				$sum_bersih += $calc['gaji_bersih'];
			}

			$payroll_bersih[]   = round($sum_bersih);
			$payroll_lembur[]   = round($bulan_data['kpi']['total_variabel']);
			$payroll_potongan[] = round($bulan_data['kpi']['total_potongan']);
		}

		return array(
			'labels'           => $labels,
			'hadir'            => $hadir,
			'sakit'            => $sakit,
			'alpha'            => $alpha,
			'payroll_bersih'   => $payroll_bersih,
			'payroll_lembur'   => $payroll_lembur,
			'payroll_potongan' => $payroll_potongan
		);
	}
}
?>