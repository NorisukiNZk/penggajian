<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('hak_akses') != '1'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong> Silakan login sebagai Administrator HRD.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = "Manajemen Pinjaman & Kasbon Pegawai";

        // Komputasi Metrik Eksekutif (4 KPI Cards)
        $data['kpi_pending'] = $this->db->get_where('data_pinjaman', array('status' => 'Pending'))->num_rows();
        $data['kpi_aktif']   = $this->db->get_where('data_pinjaman', array('status' => 'Disetujui'))->num_rows();
        $data['kpi_lunas']   = $this->db->get_where('data_pinjaman', array('status' => 'Lunas'))->num_rows();
        $data['kpi_total']   = $this->db->count_all('data_pinjaman');

        // Hitung total dana aktif beredar
        $q_sum = $this->db->query("SELECT SUM(jumlah_pinjaman) as total_dana FROM data_pinjaman WHERE status IN ('Disetujui', 'Lunas')")->row();
        $data['kpi_total_dana'] = $q_sum && $q_sum->total_dana ? $q_sum->total_dana : 0;

        // Query Pengajuan Pinjaman (Antrean 'Pending' diprioritaskan di paling atas)
        $data['pinjaman'] = $this->db->query("
            SELECT p.*, g.nama_pegawai, g.photo, g.jenis_kelamin, g.status as status_karyawan, g.tanggal_masuk, 
                   j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
            FROM data_pinjaman p
            JOIN data_pegawai g ON p.nik = g.nik
            LEFT JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
            ORDER BY (CASE WHEN p.status = 'Pending' THEN 0 ELSE 1 END), p.id_pinjaman DESC
        ")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/pinjaman/data_pinjaman', $data);
        $this->load->view('template_admin/footer');
    }

    public function setujui($id)
    {
        $pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
        if (!$pinjaman) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data pengajuan pinjaman tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/pinjaman');
            return;
        }

        $pesan_admin = trim($this->input->post('pesan_admin', TRUE));
        if (empty($pesan_admin)) {
            $pesan_admin = 'Disetujui oleh HRD/Pimpinan Klinik. Pemotongan cicilan aktif mulai payroll bulan ini.';
        }

        // Transaksi Database Atomik
        $this->db->trans_start();

        $this->db->where('id_pinjaman', $id);
        $this->db->update('data_pinjaman', array(
            'status'        => 'Disetujui',
            'tgl_disetujui' => date('Y-m-d'),
            'pesan_admin'   => $pesan_admin,
            'sisa_tenor'    => $pinjaman->tenor_bulan
        ));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Terjadi kendala saat menyetujui pinjaman.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Pengajuan pinjaman telah disetujui. Surat Perjanjian Pinjaman Karyawan (SPPK) telah resmi diterbitkan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        }

        redirect('admin/pinjaman');
    }

    public function tolak($id)
    {
        $pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
        if (!$pinjaman) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data pengajuan pinjaman tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/pinjaman');
            return;
        }

        $pesan_admin = trim($this->input->post('pesan_admin', TRUE));
        if (empty($pesan_admin)) {
            $pesan_admin = 'Ditolak setelah evaluasi beban kredit/anggaran.';
        }

        $this->db->where('id_pinjaman', $id);
        $this->db->update('data_pinjaman', array(
            'status'      => 'Ditolak',
            'pesan_admin' => $pesan_admin
        ));

        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ditolak!</strong> Permohonan pinjaman telah ditolak dengan catatan: <em>"' . htmlspecialchars($pesan_admin, ENT_QUOTES, 'UTF-8') . '"</em>.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('admin/pinjaman');
    }

    public function lunas($id)
    {
        $pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
        if (!$pinjaman) {
            redirect('admin/pinjaman');
            return;
        }

        $this->db->where('id_pinjaman', $id);
        $this->db->update('data_pinjaman', array(
            'status'      => 'Lunas',
            'sisa_tenor'  => 0,
            'pesan_admin' => 'Telah dilunasi penuh pada ' . date('d/m/Y') . '.'
        ));

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pinjaman Lunas!</strong> Status fasilitas kasbon telah ditandai lunas penuh.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('admin/pinjaman');
    }

    public function hapus($id)
    {
        $pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id))->row();
        if ($pinjaman) {
            // Hapus file dokumen fisik jika ada
            if (!empty($pinjaman->file_ktp) && file_exists(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_ktp)) {
                unlink(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_ktp);
            }
            if (!empty($pinjaman->file_jaminan) && file_exists(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_jaminan)) {
                unlink(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_jaminan);
            }

            $this->db->delete('data_pinjaman', array('id_pinjaman' => $id));

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data riwayat pinjaman telah dihapus dari sistem.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        }

        redirect('admin/pinjaman');
    }

    public function cetak_sppk($id = null)
    {
        if (!$id) {
            redirect('admin/pinjaman');
            return;
        }

        $pinjaman = $this->db->query("
            SELECT p.*, g.nama_pegawai, g.jenis_kelamin, g.status as status_karyawan, g.tanggal_masuk, j.nama_jabatan, j.gaji_pokok
            FROM data_pinjaman p
            JOIN data_pegawai g ON p.nik = g.nik
            LEFT JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
            WHERE p.id_pinjaman = ?
        ", array($id))->row();

        if (!$pinjaman) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Dokumen Tidak Ditemukan!</strong> Berkas surat perjanjian pinjaman tidak tersedia.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/pinjaman');
            return;
        }

        $data['title'] = "Surat Perjanjian Pinjaman Karyawan (SPPK)";
        $data['p'] = $pinjaman;

        $this->load->view('admin/pinjaman/cetak_sppk', $data);
    }
}
