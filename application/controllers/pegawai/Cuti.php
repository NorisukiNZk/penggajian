<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('hak_akses') != '2'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "Riwayat Pengajuan Cuti & Izin";
        $nik = $this->session->userdata('nik');
        
        // Data Cuti Pegawai Terkait
        $data['cuti'] = $this->db->query("
            SELECT * FROM data_cuti 
            WHERE nik = ? 
            ORDER BY id_cuti DESC
        ", array($nik))->result();

        // Metrik Ringkasan Pegawai
        $data['kpi_total'] = count($data['cuti']);
        $data['kpi_menunggu'] = 0;
        $data['kpi_disetujui'] = 0;
        $data['kpi_ditolak'] = 0;

        foreach ($data['cuti'] as $item) {
            if ($item->status_cuti == 'Menunggu') $data['kpi_menunggu']++;
            elseif ($item->status_cuti == 'Disetujui') $data['kpi_disetujui']++;
            elseif ($item->status_cuti == 'Ditolak') $data['kpi_ditolak']++;
        }

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/data_cuti', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah() {
        $data['title'] = "Form Pengajuan Cuti & Izin";
        $nik = $this->session->userdata('nik');

        // Profil Pegawai untuk preview ringkasan
        $data['pegawai'] = $this->db->get_where('data_pegawai', array('nik' => $nik))->row();

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/tambah_cuti', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah_aksi() {
        $nik = $this->session->userdata('nik');
        $tanggal_mulai = trim($this->input->post('tanggal_mulai', TRUE));
        $tanggal_akhir = trim($this->input->post('tanggal_akhir', TRUE));
        $jenis_cuti = trim($this->input->post('jenis_cuti', TRUE));
        $alasan = trim($this->input->post('alasan', TRUE));

        // 1. Validasi Kelengkapan Field
        if (empty($tanggal_mulai) || empty($tanggal_akhir) || empty($jenis_cuti) || empty($alasan)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pengajuan Gagal!</strong> Seluruh kolom formulir wajib diisi dengan lengkap.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        // 2. Validasi Logika Rentang Tanggal
        $time_mulai = strtotime($tanggal_mulai);
        $time_akhir = strtotime($tanggal_akhir);

        if (!$time_mulai || !$time_akhir) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Format Tanggal Tidak Valid!</strong> Silakan pilih tanggal yang sesuai.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        if ($time_akhir < $time_mulai) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Rentang Tanggal Tidak Valid!</strong> Tanggal akhir cuti tidak boleh lebih awal dari tanggal mulai cuti.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        // 3. Validasi Anti-Overlap (Pencegahan Bentrok Tanggal Cuti)
        // Mengecek apakah sudah ada cuti berstatus 'Menunggu' atau 'Disetujui' pada rentang yang sama
        $bentrok = $this->db->query("
            SELECT id_cuti, tanggal_mulai, tanggal_akhir, status_cuti 
            FROM data_cuti 
            WHERE nik = ? 
              AND status_cuti != 'Ditolak'
              AND tanggal_mulai <= ? 
              AND tanggal_akhir >= ?
            LIMIT 1
        ", array($nik, $tanggal_akhir, $tanggal_mulai))->row();

        if ($bentrok) {
            $fmt_mulai = date('d/m/Y', strtotime($bentrok->tanggal_mulai));
            $fmt_akhir = date('d/m/Y', strtotime($bentrok->tanggal_akhir));
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Jadwal Bentrok!</strong> Anda sudah memiliki pengajuan cuti (' . $bentrok->status_cuti . ') pada rentang tanggal ' . $fmt_mulai . ' s/d ' . $fmt_akhir . '. Tidak dapat mengajukan cuti ganda pada periode yang sama.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        // 4. Simpan ke Database
        $data = array(
            'nik' => $nik,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis_cuti' => $jenis_cuti,
            'alasan' => $alasan,
            'status_cuti' => 'Menunggu'
        );

        $insert = $this->db->insert('data_cuti', $data);

        if ($insert) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Pengajuan Berhasil Dikirim!</strong> Permohonan cuti/izin Anda sedang menunggu peninjauan dan persetujuan HRD.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Menyimpan!</strong> Terjadi kendala saat menyimpan data pengajuan. Silakan coba kembali.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
        }

        redirect('pegawai/cuti');
    }

    public function batal($id = null) {
        if (!$id) {
            redirect('pegawai/cuti');
            return;
        }

        $nik = $this->session->userdata('nik');
        $cuti = $this->db->get_where('data_cuti', array('id_cuti' => $id, 'nik' => $nik))->row();

        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Tidak Ditemukan!</strong> Pengajuan cuti tidak tersedia atau bukan milik Anda.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti');
            return;
        }

        // Hanya boleh batalkan yang masih berstatus 'Menunggu'
        if ($cuti->status_cuti != 'Menunggu') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Tidak Dapat Dibatalkan!</strong> Pengajuan ini sudah berstatus "' . $cuti->status_cuti . '" dan tidak dapat dibatalkan secara sepihak.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti');
            return;
        }

        // Hapus pengajuan
        $this->db->delete('data_cuti', array('id_cuti' => $id, 'nik' => $nik));

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pengajuan Dibatalkan!</strong> Permohonan cuti/izin Anda telah berhasil dibatalkan dari sistem.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');

        redirect('pegawai/cuti');
    }

    public function cetak_surat($id = null) {
        if (!$id) {
            redirect('pegawai/cuti');
            return;
        }

        $nik = $this->session->userdata('nik');
        $cuti = $this->db->query("
            SELECT c.*, p.nama_pegawai, p.jabatan, p.jenis_kelamin, p.status as status_karyawan, p.tanggal_masuk, p.photo
            FROM data_cuti c
            JOIN data_pegawai p ON c.nik = p.nik
            WHERE c.id_cuti = ? AND c.nik = ?
        ", array($id, $nik))->row();

        if (!$cuti) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Tidak Ditemukan!</strong> Dokumen surat permohonan cuti tidak dapat diakses.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti');
            return;
        }

        $data['title'] = "Surat Keterangan Cuti & Izin Resmi";
        $data['cuti'] = $cuti;

        $this->load->view('pegawai/cetak_surat_cuti', $data);
    }
}
