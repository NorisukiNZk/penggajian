<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuan extends CI_Controller {

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
		if (!in_array($tab, array('cuti', 'lembur', 'pinjaman'))) {
			$tab = 'cuti';
		}

		$data['title']      = 'Meja Persetujuan Pimpinan';
		$data['active_tab'] = $tab;

		// Data Cuti Lengkap dengan Pengganti Shift (Prioritaskan yang Diteruskan ke Direktur & Menunggu)
		$data['cuti'] = $this->db->query("
			SELECT data_cuti.*,
				   p1.nama_pegawai, p1.jabatan, p1.photo,
				   p2.nama_pegawai AS nama_pengganti, p2.jabatan AS jabatan_pengganti
			FROM data_cuti
			INNER JOIN data_pegawai p1 ON data_cuti.nik = p1.nik
			LEFT JOIN data_pegawai p2 ON data_cuti.nik_pengganti = p2.nik
			ORDER BY (CASE
				WHEN data_cuti.status_cuti IN ('Menunggu', 'Pending') AND data_cuti.status_approval = 'Diteruskan ke Direktur' THEN 0
				WHEN data_cuti.status_cuti IN ('Menunggu', 'Pending') THEN 1
				ELSE 2
			END), data_cuti.id_cuti DESC
		")->result();

		// Data Lembur
		$data['lembur'] = $this->db->query("
			SELECT data_lembur.*, data_pegawai.nama_pegawai, data_pegawai.jabatan
			FROM data_lembur
			INNER JOIN data_pegawai ON data_lembur.nik = data_pegawai.nik
			ORDER BY (CASE WHEN data_lembur.status IN ('Pending', 'Menunggu') THEN 0 ELSE 1 END), data_lembur.tanggal_lembur DESC
		")->result();

		// Data Pinjaman Lengkap dengan Gaji Pokok untuk Evaluasi DSR
		$data['pinjaman'] = $this->db->query("
			SELECT p.*, g.nama_pegawai, g.photo, g.status AS status_karyawan, g.tanggal_masuk,
				   j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
			FROM data_pinjaman p
			INNER JOIN data_pegawai g ON p.nik = g.nik
			LEFT JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
			ORDER BY (CASE WHEN p.status IN ('Pending', 'Menunggu') THEN 0 ELSE 1 END), p.id_pinjaman DESC
		")->result();

		$q_c = $this->db->query("SELECT COUNT(*) AS total FROM data_cuti WHERE status_cuti IN ('Menunggu', 'Pending')")->row();
		$q_l = $this->db->query("SELECT COUNT(*) AS total FROM data_lembur WHERE status IN ('Pending', 'Menunggu')")->row();
		$q_p = $this->db->query("SELECT COUNT(*) AS total FROM data_pinjaman WHERE status IN ('Pending', 'Menunggu')")->row();

		$data['pending_cuti']     = $q_c ? (int)$q_c->total : 0;
		$data['pending_lembur']   = $q_l ? (int)$q_l->total : 0;
		$data['pending_pinjaman'] = $q_p ? (int)$q_p->total : 0;

		$this->load->view('template_pimpinan/header', $data);
		$this->load->view('template_pimpinan/navbar', $data);
		$this->load->view('pimpinan/persetujuan', $data);
		$this->load->view('template_pimpinan/footer', $data);
	}

	// =====================================================================
	// PERSETUJUAN CUTI (SINKRON OTOMATIS KE ABSENSI HARIAN)
	// =====================================================================
	public function approve_cuti($id) {
		$cuti = $this->db->get_where('data_cuti', array('id_cuti' => $id))->row();
		if (!$cuti) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data pengajuan cuti tidak ditemukan.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			redirect('pimpinan/persetujuan?tab=cuti');
			return;
		}

		$pesan_pimpinan = trim((string)$this->input->post('pesan_admin', TRUE));
		if (empty($pesan_pimpinan)) {
			$pesan_pimpinan = 'Disetujui langsung oleh Pimpinan / Direktur Utama Klinik Hidayatullah.';
		}

		$this->db->trans_start();

		$this->db->where('id_cuti', $id)->update('data_cuti', array(
			'status_cuti'     => 'Disetujui',
			'status_approval' => 'Disetujui Direktur',
			'pesan_admin'     => $pesan_pimpinan
		));

		$begin     = new DateTime($cuti->tanggal_mulai);
		$end       = (new DateTime($cuti->tanggal_akhir))->modify('+1 day');
		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		$status_absensi = (strtolower($cuti->jenis_cuti) === 'sakit') ? 'sakit' : 'izin';

		foreach ($daterange as $date) {
			$tgl = $date->format('Y-m-d');
			$cek = $this->db->get_where('absensi_harian', array('nik' => $cuti->nik, 'tanggal' => $tgl))->num_rows();
			if ($cek === 0) {
				$this->db->insert('absensi_harian', array(
					'nik'        => $cuti->nik,
					'tanggal'    => $tgl,
					'jam_masuk'  => '00:00:00',
					'jam_pulang' => '00:00:00',
					'status'     => $status_absensi,
					'keterangan' => 'Cuti Sah (' . $cuti->jenis_cuti . '): ' . $cuti->alasan
				));
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Terjadi kendala sistem saat mengesahkan cuti.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Disetujui!</strong> Pengajuan cuti disahkan Pimpinan dan otomatis disinkronkan ke absensi harian.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		}

		redirect('pimpinan/persetujuan?tab=cuti');
	}

	public function reject_cuti($id) {
		$cuti = $this->db->get_where('data_cuti', array('id_cuti' => $id))->row();
		if (!$cuti) {
			redirect('pimpinan/persetujuan?tab=cuti');
			return;
		}

		$pesan_pimpinan = trim((string)$this->input->post('pesan_admin', TRUE));
		if (empty($pesan_pimpinan)) {
			$pesan_pimpinan = 'Ditolak oleh Pimpinan berdasarkan pertimbangan operasional klinik.';
		}

		if ($cuti->status_cuti === 'Disetujui') {
			$this->db->where('nik', $cuti->nik)
				->where('tanggal >=', $cuti->tanggal_mulai)
				->where('tanggal <=', $cuti->tanggal_akhir)
				->like('keterangan', 'Cuti')
				->delete('absensi_harian');
		}

		$this->db->where('id_cuti', $id)->update('data_cuti', array(
			'status_cuti'     => 'Ditolak',
			'status_approval' => 'Ditolak',
			'pesan_admin'     => $pesan_pimpinan
		));

		$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Ditolak!</strong> Permohonan cuti telah ditolak beserta catatan Pimpinan.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		redirect('pimpinan/persetujuan?tab=cuti');
	}

	public function cetak_surat_cuti($id = null) {
		if (!$id) {
			redirect('pimpinan/persetujuan?tab=cuti');
			return;
		}

		$cuti = $this->db->query("
			SELECT c.*,
				   p.nama_pegawai, p.jabatan, p.jenis_kelamin, p.status AS status_karyawan, p.tanggal_masuk, p.photo,
				   p2.nama_pegawai AS nama_pengganti, p2.jabatan AS jabatan_pengganti
			FROM data_cuti c
			INNER JOIN data_pegawai p ON c.nik = p.nik
			LEFT JOIN data_pegawai p2 ON c.nik_pengganti = p2.nik
			WHERE c.id_cuti = ?
		", array($id))->row();

		if (!$cuti) {
			redirect('pimpinan/persetujuan?tab=cuti');
			return;
		}

		$data['title'] = 'Surat Keterangan Cuti & Izin Resmi';
		$data['cuti']  = $cuti;
		$this->load->view('pegawai/cetak_surat_cuti', $data);
	}

	// =====================================================================
	// PERSETUJUAN LEMBUR
	// =====================================================================
	public function aksi_lembur() {
		$id_lembur = $this->input->post('id_lembur', TRUE);
		$status    = $this->input->post('status', TRUE);

		if (!in_array($status, array('Disetujui', 'Ditolak'))) {
			redirect('pimpinan/persetujuan?tab=lembur');
			return;
		}

		$this->db->where('id_lembur', $id_lembur)->update('data_lembur', array('status' => $status));

		$tipe  = ($status === 'Disetujui') ? 'success' : 'warning';
		$pesan = ($status === 'Disetujui') ? 'Pengajuan lembur disetujui Pimpinan.' : 'Pengajuan lembur ditolak Pimpinan.';

		$this->session->set_flashdata('pesan', '<div class="alert alert-' . $tipe . ' alert-dismissible fade show" role="alert"><strong>Keputusan Tersimpan!</strong> ' . $pesan . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		redirect('pimpinan/persetujuan?tab=lembur');
	}

	// =====================================================================
	// PERSETUJUAN PINJAMAN / KASBON
	// =====================================================================
	public function setujui_pinjaman($id) {
		$pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
		if (!$pinjaman) {
			redirect('pimpinan/persetujuan?tab=pinjaman');
			return;
		}

		$pesan_pimpinan = trim((string)$this->input->post('pesan_admin', TRUE));
		if (empty($pesan_pimpinan)) {
			$pesan_pimpinan = 'Disetujui oleh Pimpinan Klinik. Potongan cicilan aktif sesuai jadwal payroll.';
		}

		$this->db->trans_start();
		$this->db->where('id_pinjaman', $id)->update('data_pinjaman', array(
			'status'        => 'Disetujui',
			'tgl_disetujui' => date('Y-m-d'),
			'pesan_admin'   => $pesan_pimpinan,
			'sisa_tenor'    => $pinjaman->tenor_bulan
		));
		$this->db->trans_complete();

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Pinjaman Disetujui!</strong> Surat Perjanjian Pinjaman Karyawan (SPPK) telah siap dicetak.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		redirect('pimpinan/persetujuan?tab=pinjaman');
	}

	public function tolak_pinjaman($id) {
		$pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
		if (!$pinjaman) {
			redirect('pimpinan/persetujuan?tab=pinjaman');
			return;
		}

		$pesan_pimpinan = trim((string)$this->input->post('pesan_admin', TRUE));
		if (empty($pesan_pimpinan)) {
			$pesan_pimpinan = 'Ditolak oleh Pimpinan setelah evaluasi kelayakan angsuran.';
		}

		$this->db->where('id_pinjaman', $id)->update('data_pinjaman', array(
			'status'      => 'Ditolak',
			'pesan_admin' => $pesan_pimpinan
		));

		$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Pinjaman Ditolak!</strong> Catatan keputusan Pimpinan telah dicatat.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		redirect('pimpinan/persetujuan?tab=pinjaman');
	}

	public function cetak_sppk($id = null) {
		if (!$id) {
			redirect('pimpinan/persetujuan?tab=pinjaman');
			return;
		}

		$pinjaman = $this->db->query("
			SELECT p.*, g.nama_pegawai, g.jenis_kelamin, g.status AS status_karyawan, g.tanggal_masuk, j.nama_jabatan, j.gaji_pokok
			FROM data_pinjaman p
			INNER JOIN data_pegawai g ON p.nik = g.nik
			LEFT JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
			WHERE p.id_pinjaman = ?
		", array($id))->row();

		if (!$pinjaman) {
			redirect('pimpinan/persetujuan?tab=pinjaman');
			return;
		}

		$data['title'] = 'Surat Perjanjian Pinjaman Karyawan (SPPK)';
		$data['p']     = $pinjaman;
		$this->load->view('admin/pinjaman/cetak_sppk', $data);
	}
}
