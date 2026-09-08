<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Cuti extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('hak_akses') != '1'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong> Silakan login sebagai Administrator.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "Data Pengajuan Cuti & Izin";
        
        // Komputasi Metrik Ringkasan KPI
        $data['count_menunggu']  = $this->db->get_where('data_cuti', ['status_cuti' => 'Menunggu'])->num_rows();
        $data['count_disetujui'] = $this->db->get_where('data_cuti', ['status_cuti' => 'Disetujui'])->num_rows();
        $data['count_ditolak']   = $this->db->get_where('data_cuti', ['status_cuti' => 'Ditolak'])->num_rows();
        $data['count_total']     = $this->db->count_all('data_cuti');

        // Query Pengajuan Cuti (Prioritas 'Menunggu' berada di urutan teratas)
        $data['cuti'] = $this->db->query("
            SELECT data_cuti.*, data_pegawai.nama_pegawai, data_pegawai.jabatan, data_pegawai.photo 
            FROM data_cuti 
            INNER JOIN data_pegawai ON data_cuti.nik = data_pegawai.nik 
            ORDER BY (CASE WHEN data_cuti.status_cuti = 'Menunggu' THEN 0 ELSE 1 END), id_cuti DESC
        ")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/data_cuti', $data);
        $this->load->view('template_admin/footer');
    }

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
        if (empty($pesan_admin)) {
            $pesan_admin = 'Disetujui tanpa catatan khusus.';
        }

        // Transaksi Database Atomik
        $this->db->trans_start();

        // 1. Update status cuti dan catatan admin
        $this->db->where('id_cuti', $id);
        $this->db->update('data_cuti', [
            'status_cuti' => 'Disetujui',
            'pesan_admin' => $pesan_admin
        ]);

        // 2. Sinkronisasi otomatis ke Absensi Harian
        $begin = new DateTime($cuti->tanggal_mulai);
        $end = new DateTime($cuti->tanggal_akhir);
        $end = $end->modify('+1 day'); // mencakup tanggal akhir

        $interval = new DateInterval('P1D');
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
                    'keterangan' => 'Cuti (' . $cuti->jenis_cuti . '): ' . $cuti->alasan
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
                <strong>Berhasil!</strong> Pengajuan cuti telah disetujui dan disinkronkan ke Absensi Harian.
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
            $pesan_admin = 'Ditolak (Tanpa Alasan Spesifik).';
        }

        $this->db->where('id_cuti', $id);
        $this->db->update('data_cuti', [
            'status_cuti' => 'Ditolak',
            'pesan_admin' => $pesan_admin
        ]);

        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ditolak!</strong> Pengajuan cuti telah ditolak dengan catatan: <em>"' . htmlspecialchars($pesan_admin, ENT_QUOTES, 'UTF-8') . '"</em>.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');

        redirect('admin/data_cuti');
    }

    public function hapus($id) {
        $this->db->where('id_cuti', $id);
        $this->db->delete('data_cuti');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data riwayat cuti telah berhasil dihapus.
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
            SELECT c.*, p.nama_pegawai, p.jabatan, p.jenis_kelamin, p.status as status_karyawan, p.tanggal_masuk, p.photo
            FROM data_cuti c
            JOIN data_pegawai p ON c.nik = p.nik
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
        $data['cuti'] = $cuti;

        $this->load->view('pegawai/cetak_surat_cuti', $data);
    }
}

?>
