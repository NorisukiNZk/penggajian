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
		$username = set_value('username');

		// Hanya mencari berdasarkan username, password diverifikasi di Controller menggunakan password_verify
		$result = $this->db->where('username',$username)
							->limit(1)
							->get('data_pegawai');
		if($result->num_rows()>0){
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
}

?>