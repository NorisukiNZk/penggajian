<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

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
		$data['title']   = 'Pusat Laporan Eksekutif';
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();
		$data['pegawai'] = $this->db->query("SELECT nik, nama_pegawai, jabatan FROM data_pegawai ORDER BY nama_pegawai ASC")->result();

		$this->load->view('template_pimpinan/header', $data);
		$this->load->view('template_pimpinan/navbar', $data);
		$this->load->view('pimpinan/laporan', $data);
		$this->load->view('template_pimpinan/footer', $data);
	}

	public function cetak_gaji() {
		$data['title'] = 'Cetak Laporan Gaji Pegawai';
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();

		$data['cetak_gaji'] = $this->db->query("
			SELECT data_pegawai.nik, data_pegawai.nama_pegawai,
				   data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok,
				   data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ?
			GROUP BY data_pegawai.nik
			ORDER BY data_pegawai.nama_pegawai ASC
		", array($bulantahun))->result();

		$data['komponen_per_pegawai'] = array();
		foreach ($data['cetak_gaji'] as $g) {
			$tunjangan        = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			$lembur           = $this->ModelPenggajian->hitung_uang_lembur($g->nik, $bulan, $tahun);
			$pinjaman         = $this->ModelPenggajian->hitung_potongan_pinjaman($g->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam'],
				'pinjaman'    => $pinjaman
			);
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view('admin/gaji/cetak_gaji', $data);
	}

	public function cetak_tahunan() {
		$data['title'] = 'Cetak Laporan Gaji Tahunan';
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');

		$potongan_master = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$alpha_deduction = 0;
		foreach ($potongan_master as $pm) {
			if (strtolower($pm->potongan) === 'alpha') {
				$alpha_deduction = $pm->jml_potongan;
			}
		}

		$pegawai = $this->db->query("
			SELECT p.nik, p.nama_pegawai, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
			FROM data_pegawai p
			INNER JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
			ORDER BY p.nama_pegawai ASC
		")->result();

		$rekap_tahunan = array();
		foreach ($pegawai as $p) {
			$total_gaji      = 0;
			$total_tunjangan = 0;
			$total_potongan  = 0;
			$total_lembur    = 0;
			$total_bersih    = 0;

			for ($i = 1; $i <= 12; $i++) {
				$bulan_loop = str_pad($i, 2, '0', STR_PAD_LEFT);
				$bulantahun = $bulan_loop . $tahun;
				$kehadiran  = $this->db->query("SELECT alpha FROM data_kehadiran WHERE nik = ? AND bulan = ?", array($p->nik, $bulantahun))->row();

				if ($kehadiran) {
					$gaji_bln        = $p->gaji_pokok + $p->tj_transport + $p->uang_makan;
					$total_gaji     += $gaji_bln;
					$lembur          = $this->ModelPenggajian->hitung_uang_lembur($p->nik, $bulan_loop, $tahun);
					$total_lembur   += $lembur['uang_lembur'];
					$tj_dinamis      = $this->ModelKomponen->hitung_total_tunjangan($p->nik, $bulantahun, $p->gaji_pokok);
					$total_tunjangan += $tj_dinamis['total'];
					$pot_alpha       = $kehadiran->alpha * $alpha_deduction;
					$pot_dinamis     = $this->ModelKomponen->hitung_total_potongan($p->nik, $bulantahun, $p->gaji_pokok);
					$pinjaman        = $this->ModelPenggajian->hitung_potongan_pinjaman($p->nik, $bulan_loop, $tahun);
					$pot_pinjaman    = isset($pinjaman['total']) ? (int)$pinjaman['total'] : 0;

					$total_potongan += ($pot_alpha + $pot_dinamis['total'] + $pot_pinjaman);
					$total_bersih   += ($gaji_bln + $lembur['uang_lembur'] + $tj_dinamis['total'] - ($pot_alpha + $pot_dinamis['total'] + $pot_pinjaman));
				}
			}

			if ($total_bersih > 0) {
				$rekap_tahunan[] = array(
					'nik'            => $p->nik,
					'nama_pegawai'   => $p->nama_pegawai,
					'jabatan'        => $p->nama_jabatan,
					'gaji_tunjangan' => $total_gaji + $total_tunjangan,
					'uang_lembur'    => $total_lembur,
					'potongan'       => $total_potongan,
					'gaji_bersih'    => $total_bersih
				);
			}
		}

		$data['tahun'] = $tahun;
		$data['rekap'] = $rekap_tahunan;

		$this->load->view('admin/gaji/cetak_laporan_tahunan', $data);
	}

	public function cetak_absensi() {
		$data['title'] = 'Cetak Laporan Absensi Pegawai';
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		$data['lap_kehadiran'] = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan = ? ORDER BY nama_pegawai ASC", array($bulantahun))->result();
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view('admin/absensi/cetak_absensi', $data);
	}

	public function cetak_cuti() {
		$data['title'] = 'Cetak Laporan Cuti Pegawai';
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->db->select('data_cuti.*, data_pegawai.nama_pegawai, data_pegawai.jabatan');
		$this->db->from('data_cuti');
		$this->db->join('data_pegawai', 'data_cuti.nik = data_pegawai.nik');
		$this->db->where('MONTH(data_cuti.tanggal_mulai)', $bulan);
		$this->db->where('YEAR(data_cuti.tanggal_mulai)', $tahun);
		$this->db->where('data_cuti.status_cuti', 'Disetujui');
		$this->db->order_by('data_cuti.tanggal_mulai', 'ASC');
		$data['laporan_cuti'] = $this->db->get()->result();

		$this->load->view('admin/cuti/cetak_laporan_cuti', $data);
	}

	public function cetak_lembur() {
		$data['title'] = 'Cetak Laporan Lembur Pegawai';
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $tahun . '-' . $bulan;

		$setting = $this->db->get_where('setting_absensi', array('id' => 1))->row();
		$data['tarif_lembur'] = $setting ? (int)$setting->tarif_lembur_per_jam : 20000;

		$data['lembur'] = $this->db->query("
			SELECT data_lembur.*, data_pegawai.nama_pegawai, data_pegawai.nik
			FROM data_lembur
			INNER JOIN data_pegawai ON data_lembur.nik = data_pegawai.nik
			WHERE DATE_FORMAT(data_lembur.tanggal_lembur, '%Y-%m') = ? AND data_lembur.status = 'Disetujui'
			ORDER BY data_lembur.tanggal_lembur ASC
		", array($bulantahun))->result();

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view('admin/lembur/cetak_laporan_lembur', $data);
	}

	public function cetak_potongan() {
		$data['title'] = 'Cetak Laporan Potongan Gaji';
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		$data['potongan_master'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['potongan_gaji']   = $this->db->query("
			SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_jabatan.gaji_pokok, data_kehadiran.alpha
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ?
			ORDER BY data_pegawai.nama_pegawai ASC
		", array($bulantahun))->result();

		$data['komponen_per_pegawai'] = array();
		foreach ($data['potongan_gaji'] as $g) {
			$data['komponen_per_pegawai'][$g->nik] = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
		}

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view('admin/potongan_gaji/cetak_laporan_potongan', $data);
	}

	public function cetak_slip() {
		$data['title']    = 'Cetak Slip Gaji Pegawai';
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();

		$nik   = $this->input->get_post('nik', TRUE);
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);

		$data['print_slip'] = $this->db->query("
			SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_jabatan.nama_jabatan,
				   data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan,
				   data_kehadiran.alpha, data_kehadiran.bulan
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ? AND data_pegawai.nik = ?
		", array($bulantahun, $nik))->result();

		$data['komponen_per_pegawai'] = array();
		foreach ($data['print_slip'] as $ps) {
			$tunjangan        = $this->ModelKomponen->hitung_total_tunjangan($ps->nik, $bulantahun, $ps->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($ps->nik, $bulantahun, $ps->gaji_pokok);
			$lembur           = $this->ModelPenggajian->hitung_uang_lembur($ps->nik, $bulan, $tahun);
			$pinjaman         = $this->ModelPenggajian->hitung_potongan_pinjaman($ps->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$ps->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam'],
				'pinjaman'    => $pinjaman
			);
		}

		$this->load->view('admin/gaji/cetak_slip_gaji', $data);
	}

	public function cetak_pegawai() {
		$jabatan = $this->input->get_post('jabatan', TRUE);
		if (!empty($jabatan) && $jabatan !== 'semua') {
			$data['pegawai']        = $this->db->query("SELECT * FROM data_pegawai WHERE jabatan = ? ORDER BY nama_pegawai ASC", array($jabatan))->result();
			$data['filter_jabatan'] = $jabatan;
		} else {
			$data['pegawai']        = $this->db->query("SELECT * FROM data_pegawai ORDER BY nama_pegawai ASC")->result();
			$data['filter_jabatan'] = 'Semua Jabatan';
		}

		$this->load->view('admin/pegawai/cetak_laporan_pegawai', $data);
	}

	public function cetak_jabatan() {
		$data['title']   = 'Standar Jabatan & Remunerasi';
		$data['jabatan'] = $this->ModelPenggajian->get_data('data_jabatan')->result();

		$this->load->view('admin/jabatan/cetak_data_jabatan', $data);
	}

	// =====================================================================
	// EKSPOR CSV SIAP BUKA DI EXCEL (UTF-8 BOM + FORMULA INJECTION GUARD)
	// =====================================================================
	private function _csv_safe($value) {
		$str = (string)$value;
		if ($str !== '' && in_array($str[0], array('=', '+', '-', '@', "\t", "\r"))) {
			return "'" . $str;
		}
		return $str;
	}

	private function _output_csv($filename, $headers, $rows) {
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$out = fopen('php://output', 'w');
		fwrite($out, "\xEF\xBB\xBF");
		fputcsv($out, $headers);
		foreach ($rows as $row) {
			$safe = array();
			foreach ($row as $cell) {
				$safe[] = $this->_csv_safe($cell);
			}
			fputcsv($out, $safe);
		}
		fclose($out);
		exit;
	}

	public function export_gaji_csv() {
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		$potongan_master = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$alpha_deduction = 0;
		foreach ($potongan_master as $pm) {
			if (strtolower($pm->potongan) === 'alpha') {
				$alpha_deduction = (float)$pm->jml_potongan;
			}
		}

		$list = $this->db->query("
			SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_jabatan.nama_jabatan,
				   data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = ?
			GROUP BY data_pegawai.nik
			ORDER BY data_pegawai.nama_pegawai ASC
		", array($bulantahun))->result();

		$rows = array();
		$no = 1;
		foreach ($list as $g) {
			$tj   = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$pot  = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			$lemb = $this->ModelPenggajian->hitung_uang_lembur($g->nik, $bulan, $tahun);
			$pinj = $this->ModelPenggajian->hitung_potongan_pinjaman($g->nik, $bulan, $tahun);

			$total_tunj = (float)$g->tj_transport + (float)$g->uang_makan + (float)$tj['total'];
			$total_pot  = ((float)$g->alpha * $alpha_deduction) + (float)$pot['total'] + (float)$pinj['total'];
			$thp        = (float)$g->gaji_pokok + $total_tunj + (float)$lemb['uang_lembur'] - $total_pot;

			$rows[] = array(
				$no++,
				$g->nik,
				$g->nama_pegawai,
				$g->nama_jabatan,
				$g->gaji_pokok,
				$total_tunj,
				$lemb['uang_lembur'],
				$total_pot,
				$thp
			);
		}

		$this->_output_csv(
			'Laporan_Gaji_' . $bulan . '_' . $tahun . '.csv',
			array('No', 'NIK', 'Nama Pegawai', 'Jabatan', 'Gaji Pokok', 'Total Tunjangan', 'Uang Lembur', 'Total Potongan', 'Take Home Pay'),
			$rows
		);
	}

	public function export_absensi_csv() {
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$bulantahun = $bulan . $tahun;

		$this->ModelAbsensiHarian->sinkron_ke_kehadiran($bulan, $tahun);
		$list = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan = ? ORDER BY nama_pegawai ASC", array($bulantahun))->result();

		$rows = array();
		$no = 1;
		foreach ($list as $a) {
			$rows[] = array($no++, $a->nik, $a->nama_pegawai, $a->nama_jabatan, $a->hadir, $a->sakit, $a->alpha);
		}

		$this->_output_csv(
			'Laporan_Absensi_' . $bulan . '_' . $tahun . '.csv',
			array('No', 'NIK', 'Nama Pegawai', 'Jabatan', 'Hadir', 'Sakit', 'Alpha'),
			$rows
		);
	}

	public function export_cuti_csv() {
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');

		$list = $this->db->query("
			SELECT c.*, p.nama_pegawai, p.jabatan
			FROM data_cuti c
			INNER JOIN data_pegawai p ON c.nik = p.nik
			WHERE MONTH(c.tanggal_mulai) = ? AND YEAR(c.tanggal_mulai) = ? AND c.status_cuti = 'Disetujui'
			ORDER BY c.tanggal_mulai ASC
		", array($bulan, $tahun))->result();

		$rows = array();
		$no = 1;
		foreach ($list as $c) {
			$rows[] = array($no++, $c->nik, $c->nama_pegawai, $c->jabatan, $c->jenis_cuti, $c->tanggal_mulai, $c->tanggal_akhir, $c->alasan, $c->status_cuti);
		}

		$this->_output_csv(
			'Laporan_Cuti_' . $bulan . '_' . $tahun . '.csv',
			array('No', 'NIK', 'Nama Pegawai', 'Jabatan', 'Jenis Cuti', 'Tanggal Mulai', 'Tanggal Akhir', 'Alasan', 'Status'),
			$rows
		);
	}

	public function export_lembur_csv() {
		$bulan = $this->input->get_post('bulan', TRUE) ?: date('m');
		$tahun = $this->input->get_post('tahun', TRUE) ?: date('Y');
		$setting = $this->db->get_where('setting_absensi', array('id' => 1))->row();
		$tarif   = $setting ? (int)$setting->tarif_lembur_per_jam : 20000;

		$list = $this->db->query("
			SELECT l.*, p.nama_pegawai, p.jabatan
			FROM data_lembur l
			INNER JOIN data_pegawai p ON l.nik = p.nik
			WHERE DATE_FORMAT(l.tanggal_lembur, '%Y-%m') = ? AND l.status = 'Disetujui'
			ORDER BY l.tanggal_lembur ASC
		", array($tahun . '-' . $bulan))->result();

		$rows = array();
		$no = 1;
		foreach ($list as $l) {
			$rows[] = array($no++, $l->nik, $l->nama_pegawai, $l->jabatan, $l->tanggal_lembur, $l->jam_mulai, $l->jam_selesai, $l->durasi_jam, (int)$l->durasi_jam * $tarif, $l->keterangan);
		}

		$this->_output_csv(
			'Laporan_Lembur_' . $bulan . '_' . $tahun . '.csv',
			array('No', 'NIK', 'Nama Pegawai', 'Jabatan', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Durasi (Jam)', 'Total Kompensasi', 'Keterangan'),
			$rows
		);
	}

	public function export_pegawai_csv() {
		$jabatan = $this->input->get_post('jabatan', TRUE);
		if (!empty($jabatan) && $jabatan !== 'semua') {
			$list = $this->db->query("SELECT * FROM data_pegawai WHERE jabatan = ? ORDER BY nama_pegawai ASC", array($jabatan))->result();
		} else {
			$list = $this->db->query("SELECT * FROM data_pegawai ORDER BY nama_pegawai ASC")->result();
		}

		$rows = array();
		$no = 1;
		foreach ($list as $p) {
			$role = ($p->hak_akses == '1') ? 'Admin' : (($p->hak_akses == '3') ? 'Pimpinan' : 'Pegawai');
			$rows[] = array($no++, $p->nik, $p->nama_pegawai, $p->jenis_kelamin, $p->jabatan, $p->tanggal_masuk, $p->status, $role);
		}

		$this->_output_csv(
			'Data_Pegawai_Klinik.csv',
			array('No', 'NIK', 'Nama Pegawai', 'Jenis Kelamin', 'Jabatan', 'Tanggal Masuk', 'Status', 'Hak Akses'),
			$rows
		);
	}
}
