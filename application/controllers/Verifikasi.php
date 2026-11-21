<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends CI_Controller {

	public function index() {
		$data['title']   = 'Verifikasi Dokumen Digital';
		$data['checked'] = false;
		$data['valid']   = false;
		$data['detail']  = null;
		$data['pesan']   = '';
		$data['input']   = array(
			'tipe'    => '',
			'ref'     => '',
			'periode' => '',
			'sig'     => ''
		);

		$this->load->view('verifikasi_dokumen', $data);
	}

	public function cek() {
		$tipe    = strtolower(trim((string)$this->input->get_post('tipe', TRUE)));
		$ref     = trim((string)$this->input->get_post('ref', TRUE));
		$periode = trim((string)$this->input->get_post('periode', TRUE));
		$sig     = strtoupper(trim((string)$this->input->get_post('sig', TRUE)));

		// Jika user memasukkan format lengkap seperti SLIP-ABC123DEF456, ambil bagian hash-nya
		if (strpos($sig, '-') !== false) {
			$parts = explode('-', $sig);
			$sig   = end($parts);
		}

		$data['title']   = 'Hasil Verifikasi Dokumen Digital';
		$data['checked'] = true;
		$data['valid']   = false;
		$data['detail']  = null;
		$data['pesan']   = '';
		$data['input']   = array(
			'tipe'    => $tipe,
			'ref'     => $ref,
			'periode' => $periode,
			'sig'     => $sig
		);

		$allowed_types = array(
			'slip'       => 'Slip Gaji Resmi Pegawai',
			'cuti'       => 'Surat Keterangan Cuti / Izin',
			'sppk'       => 'Surat Perjanjian Pinjaman Karyawan (SPPK)',
			'lap_gaji'   => 'Laporan Rekap Gaji Bulanan',
			'lap_tahun'  => 'Laporan Rekap Gaji Tahunan',
			'lap_absen'  => 'Laporan Rekap Absensi Bulanan',
			'lap_cuti'   => 'Laporan Cuti Pegawai',
			'lap_lembur' => 'Laporan Lembur Karyawan',
			'lap_potong' => 'Laporan Potongan Gaji',
			'lap_peg'    => 'Laporan Master Data Pegawai',
			'lap_jab'    => 'Laporan Standar Jabatan & Remunerasi'
		);

		if (!isset($allowed_types[$tipe]) || $ref === '' || $sig === '') {
			$data['pesan'] = 'Parameter verifikasi belum lengkap. Pastikan jenis dokumen, referensi, dan kode tanda tangan terisi.';
			$this->load->view('verifikasi_dokumen', $data);
			return;
		}

		if (!qr_doc_verify_signature($tipe, $ref, $periode, $sig)) {
			$data['pesan'] = 'Tanda tangan digital (HMAC-SHA256) tidak cocok dengan data dokumen. Dokumen kemungkinan telah diubah atau kode verifikasi salah.';
			$this->load->view('verifikasi_dokumen', $data);
			return;
		}

		// Verifikasi eksistensi data nyata di database sesuai jenis dokumen
		$meta = array(
			'jenis_dokumen' => $allowed_types[$tipe],
			'kode_sah'      => strtoupper($tipe) . '-' . $sig,
			'penandatangan' => 'Dr. H. Muhammad Hidayatullah (Pimpinan Klinik Pratama)',
			'sip'           => 'SIP: 445/098/Dinkes-Bjb/2022',
			'waktu_cek'     => date('d M Y, H:i:s') . ' WITA',
			'ringkasan'     => array()
		);

		if ($tipe === 'slip') {
			$row = $this->db->query("
				SELECT p.nik, p.nama_pegawai, p.jabatan, k.bulan
				FROM data_pegawai p
				INNER JOIN data_kehadiran k ON k.nik = p.nik
				WHERE p.nik = ? AND k.bulan = ?
				LIMIT 1
			", array($ref, $periode))->row();

			if (!$row) {
				$data['pesan'] = 'Tanda tangan valid secara format, namun catatan slip gaji untuk NIK dan periode tersebut tidak ditemukan di database.';
				$this->load->view('verifikasi_dokumen', $data);
				return;
			}
			$meta['ringkasan'] = array(
				'Nama Pegawai' => $row->nama_pegawai,
				'NIK'          => $row->nik,
				'Jabatan'      => $row->jabatan,
				'Periode Slip' => substr($row->bulan, 0, 2) . '/' . substr($row->bulan, 2, 4)
			);
		} elseif ($tipe === 'cuti') {
			$row = $this->db->query("
				SELECT c.*, p.nama_pegawai, p.jabatan
				FROM data_cuti c
				INNER JOIN data_pegawai p ON c.nik = p.nik
				WHERE c.id_cuti = ?
				LIMIT 1
			", array($ref))->row();

			if (!$row) {
				$data['pesan'] = 'Catatan permohonan cuti tidak ditemukan pada database klinik.';
				$this->load->view('verifikasi_dokumen', $data);
				return;
			}
			$meta['ringkasan'] = array(
				'Nama Pegawai'  => $row->nama_pegawai . ' (' . $row->jabatan . ')',
				'NIK'           => $row->nik,
				'Kategori Cuti' => $row->jenis_cuti,
				'Periode Cuti'  => date('d M Y', strtotime($row->tanggal_mulai)) . ' s/d ' . date('d M Y', strtotime($row->tanggal_akhir)),
				'Status'        => $row->status_cuti
			);
		} elseif ($tipe === 'sppk') {
			$row = $this->db->query("
				SELECT p.*, g.nama_pegawai, g.jabatan
				FROM data_pinjaman p
				INNER JOIN data_pegawai g ON p.nik = g.nik
				WHERE p.id_pinjaman = ?
				LIMIT 1
			", array($ref))->row();

			if (!$row) {
				$data['pesan'] = 'Catatan Surat Perjanjian Pinjaman Karyawan (SPPK) tidak ditemukan pada database.';
				$this->load->view('verifikasi_dokumen', $data);
				return;
			}
			$meta['ringkasan'] = array(
				'Nama Peminjam'    => $row->nama_pegawai . ' (' . $row->jabatan . ')',
				'Kode Pinjaman'    => '#PINJ-' . sprintf('%04d', $row->id_pinjaman),
				'Nominal Pinjaman' => 'Rp ' . number_format((float)$row->jumlah_pinjaman, 0, ',', '.'),
				'Tenor'            => $row->tenor_bulan . ' Bulan',
				'Status'           => $row->status
			);
		} else {
			$meta['ringkasan'] = array(
				'Instansi Penerbit' => 'Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru',
				'Cakupan / Filter'  => $ref,
				'Periode Laporan'   => $periode !== '' ? $periode : 'Sesuai tanggal cetak',
				'Status Arsip'      => 'Sah diterbitkan melalui sistem HRIS resmi'
			);
		}

		$data['valid']  = true;
		$data['detail'] = $meta;
		$this->load->view('verifikasi_dokumen', $data);
	}
}
