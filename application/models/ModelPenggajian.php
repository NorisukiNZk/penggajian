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
			}
			// Jika belum absen pulang sama sekali, durasinya dihitung 0
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

		$payroll_date = date_create("$tahun-$bulan-01");

		foreach ($pinjaman as $p) {
			$tgl_disetujui = date_create($p->tgl_disetujui);
			// Kita anggap cicilan 1 dimulai pada bulan setelah disetujui, atau pada bulan yang sama jika disetujui awal bulan.
			// Untuk simpelnya, kita asumsikan cicilan dimulai pada bulan saat disetujui.
			$start_date = date_create(date_format($tgl_disetujui, 'Y-m-01'));
			
			// Hitung selisih bulan
			$diff = date_diff($start_date, $payroll_date);
			$months_passed = ($diff->y * 12) + $diff->m;

			// Jika payroll_date lebih kecil dari start_date, invert akan bernilai 1 (berarti belum mulai)
			if ($diff->invert == 0 && $months_passed >= 0 && $months_passed < $p->tenor_bulan) {
				$cicilan_ke = $months_passed + 1;
				$nominal_cicilan = ceil($p->jumlah_pinjaman / $p->tenor_bulan);
				
				$total_potongan += $nominal_cicilan;
				$detail_cicilan[] = array(
					'keterangan' => 'Potongan Pinjaman (Cicilan '.$cicilan_ke.'/'.$p->tenor_bulan.')',
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
}
?>