<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Cuti extends CI_Controller {
    
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

    public function index() {
        $data['title'] = "Data Pengajuan Cuti & Pendelegasian Tugas";
        
        // Komputasi Metrik Ringkasan KPI
        $data['count_menunggu']  = $this->db->get_where('data_cuti', ['status_cuti' => 'Menunggu'])->num_rows();
        $data['count_disetujui'] = $this->db->get_where('data_cuti', ['status_cuti' => 'Disetujui'])->num_rows();
        $data['count_ditolak']   = $this->db->get_where('data_cuti', ['status_cuti' => 'Ditolak'])->num_rows();
        $data['count_total']     = $this->db->count_all('data_cuti');
        $data['setting_cuti']    = $this->ModelPenggajian->get_setting_cuti();

        // Query Pengajuan Cuti Lengkap dengan Rekan Pengganti Shift
        $data['cuti'] = $this->db->query("
            SELECT data_cuti.*, 
                   p1.nama_pegawai, p1.jabatan, p1.photo,
                   p2.nama_pegawai as nama_pengganti, p2.jabatan as jabatan_pengganti
            FROM data_cuti 
            INNER JOIN data_pegawai p1 ON data_cuti.nik = p1.nik 
            LEFT JOIN data_pegawai p2 ON data_cuti.nik_pengganti = p2.nik
            ORDER BY (CASE WHEN data_cuti.status_cuti = 'Menunggu' THEN 0 ELSE 1 END), data_cuti.id_cuti DESC
        ")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/data_cuti', $data);
        $this->load->view('template_admin/footer');
    }

    // Alur 1: Meneruskan ke Direktur Utama dengan Rekomendasi/Telaah HRD
    public function teruskan_direktur($id) {
        $cuti = $this->db->get_where('data_cuti', ['id_cuti' => $id])->row();
        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data pengajuan cuti tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/data_cuti');
            return;
        }

        $catatan_hrd = trim($this->input->post('catatan_hrd', TRUE));
        if (empty($catatan_hrd)) {
            $catatan_hrd = 'Berkas dan pengganti shift telah diverifikasi HRD. Direkomendasikan untuk disetujui Direktur Utama.';
        }

        $update = $this->db->where('id_cuti', $id)->update('data_cuti', [
            'status_approval' => 'Diteruskan ke Direktur',
            'catatan_hrd'     => $catatan_hrd
        ]);

        if ($update) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Berhasil Diteruskan!</strong> Pengajuan cuti telah ditelaah dan diteruskan ke Direktur Utama dengan catatan rekomendasi HRD.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Kendala teknis saat memperbarui status pengajuan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        }

        redirect('admin/data_cuti');
    }

    // Alur 2: Pengesahan & Persetujuan Final (Direct / Delegated Approval)
    public function approve($id) {
        $cuti = $this->db->get_where('data_cuti', ['id_cuti' => $id])->row();
        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data pengajuan cuti tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/data_cuti');
            return;
        }

        $pesan_admin = trim($this->input->post('pesan_admin', TRUE));
        $catatan_hrd = trim($this->input->post('catatan_hrd', TRUE));

        if (empty($pesan_admin)) {
            $pesan_admin = 'Disetujui sah oleh Direktur Utama & Manajemen HRD Klinik Hidayatullah.';
        }
        if (empty($catatan_hrd) && !empty($cuti->catatan_hrd)) {
            $catatan_hrd = $cuti->catatan_hrd;
        }

        // Transaksi Database Atomik
        $this->db->trans_start();

        // 1. Update status cuti, status approval, dan pesan
        $this->db->where('id_cuti', $id);
        $this->db->update('data_cuti', [
            'status_cuti'     => 'Disetujui',
            'status_approval' => 'Disetujui Direktur',
            'pesan_admin'     => $pesan_admin,
            'catatan_hrd'     => $catatan_hrd
        ]);

        // 2. Sinkronisasi otomatis ke Absensi Harian
        $begin = new DateTime($cuti->tanggal_mulai);
        $end   = new DateTime($cuti->tanggal_akhir);
        $end   = $end->modify('+1 day'); // mencakup tanggal akhir inklusif

        $interval  = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        $status_absensi = (strtolower($cuti->jenis_cuti) == 'sakit') ? 'sakit' : 'izin';

        foreach($daterange as $date){
            $tgl = $date->format("Y-m-d");
            
            // Cek apakah tanggal sudah tercatat di absensi harian
            $cek = $this->db->get_where('absensi_harian', [
                'nik' => $cuti->nik, 
                'tanggal' => $tgl
            ])->num_rows();

            if($cek == 0) {
                $this->db->insert('absensi_harian', [
                    'nik'        => $cuti->nik,
                    'tanggal'    => $tgl,
                    'jam_masuk'  => '00:00:00',
                    'jam_pulang' => '00:00:00',
                    'status'     => $status_absensi,
                    'keterangan' => 'Cuti Sah (' . $cuti->jenis_cuti . '): ' . $cuti->alasan
                ]);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Terjadi kesalahan sistem saat menyetujui pengajuan cuti.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil Disetujui!</strong> Pengajuan cuti telah disahkan atas wewenang Direktur Utama dan disinkronkan ke Absensi Harian.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        }

        redirect('admin/data_cuti');
    }

    public function reject($id) {
        $cuti = $this->db->get_where('data_cuti', ['id_cuti' => $id])->row();
        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data pengajuan cuti tidak ditemukan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/data_cuti');
            return;
        }

        $pesan_admin = trim($this->input->post('pesan_admin', TRUE));
        if (empty($pesan_admin)) {
            $pesan_admin = 'Ditolak: Tidak memenuhi persyaratan atau tidak tersedia backup operasional.';
        }

        $this->db->where('id_cuti', $id);
        $this->db->update('data_cuti', [
            'status_cuti'     => 'Ditolak',
            'status_approval' => 'Ditolak',
            'pesan_admin'     => $pesan_admin
        ]);

        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ditolak!</strong> Pengajuan cuti telah ditolak dengan catatan: <em>"' . htmlspecialchars($pesan_admin, ENT_QUOTES, 'UTF-8') . '"</em>.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('admin/data_cuti');
    }

    public function hapus($id) {
        $cuti = $this->db->get_where('data_cuti', ['id_cuti' => $id])->row();
        if ($cuti && !empty($cuti->file_lampiran) && file_exists('./uploads/cuti/' . $cuti->file_lampiran)) {
            @unlink('./uploads/cuti/' . $cuti->file_lampiran);
        }

        $this->db->where('id_cuti', $id);
        $this->db->delete('data_cuti');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Dihapus!</strong> Data pengajuan cuti telah berhasil dihapus dari sistem.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('admin/data_cuti');
    }

    public function cetak_surat($id = null) {
        if (!$id) {
            redirect('admin/data_cuti');
            return;
        }

        $cuti = $this->db->query("
            SELECT c.*, 
                   p.nama_pegawai, p.jabatan, p.jenis_kelamin, p.status as status_karyawan, p.tanggal_masuk, p.photo,
                   p2.nama_pegawai as nama_pengganti, p2.jabatan as jabatan_pengganti
            FROM data_cuti c
            JOIN data_pegawai p ON c.nik = p.nik
            LEFT JOIN data_pegawai p2 ON c.nik_pengganti = p2.nik
            WHERE c.id_cuti = ?
        ", array($id))->row();

        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Tidak Ditemukan!</strong> Dokumen surat permohonan cuti tidak dapat diakses.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('admin/data_cuti');
            return;
        }

        $data['title'] = "Surat Keterangan Cuti & Izin Resmi";
        $data['cuti']  = $cuti;

        $this->load->view('pegawai/cetak_surat_cuti', $data);
    }

    /**
     * Halaman Pengaturan Kebijakan Kuota Cuti Pegawai
     */
    public function setting() {
        $data['title'] = "Pengaturan Kuota Cuti Pegawai";
        $data['setting'] = $this->ModelPenggajian->get_setting_cuti();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/cuti/setting', $data);
        $this->load->view('template_admin/footer');
    }

    /**
     * Proses Simpan Pengaturan Kebijakan Kuota Cuti
     */
    public function update_setting() {
        $mode = $this->input->post('mode_kuota_cuti', TRUE);
        $kuota_tahunan = (int)$this->input->post('kuota_cuti_tahunan', TRUE);
        $kuota_bulanan = (int)$this->input->post('kuota_cuti_bulanan', TRUE);
        $keterangan = trim($this->input->post('keterangan_kebijakan', TRUE));

        // Validasi input
        if (!in_array($mode, ['Tahunan', 'Bulanan', 'Kombinasi'])) {
            $mode = 'Kombinasi';
        }
        if ($kuota_tahunan < 1) $kuota_tahunan = 12;
        if ($kuota_bulanan < 1) $kuota_bulanan = 5;

        $update_data = array(
            'mode_kuota_cuti'      => $mode,
            'kuota_cuti_tahunan'   => $kuota_tahunan,
            'kuota_cuti_bulanan'   => $kuota_bulanan,
            'keterangan_kebijakan' => $keterangan
        );

        $this->db->where('id', 1);
        $this->db->update('setting_cuti', $update_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> <strong>Pengaturan Disimpan!</strong> Kebijakan kuota cuti pegawai berhasil diperbarui dan langsung diterapkan ke seluruh sistem.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('admin/data_cuti/setting');
    }
}
