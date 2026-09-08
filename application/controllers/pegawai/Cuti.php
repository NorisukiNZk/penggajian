<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('hak_akses') != '2'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong> Silakan masuk ke akun pegawai Anda.
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
        
        // Data Cuti Pegawai Terkait beserta Rekan Pengganti
        $data['cuti'] = $this->db->query("
            SELECT c.*, p2.nama_pegawai as nama_pengganti, p2.jabatan as jabatan_pengganti
            FROM data_cuti c
            LEFT JOIN data_pegawai p2 ON c.nik_pengganti = p2.nik
            WHERE c.nik = ? 
            ORDER BY c.id_cuti DESC
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

        // Hitung Saldo Cuti Pegawai Berdasarkan Kebijakan Kuota Terpusat
        $saldo_info = $this->ModelPenggajian->hitung_saldo_cuti($nik);
        $data['saldo_cuti']     = $saldo_info;
        $data['hak_cuti_total'] = $saldo_info['kuota_total_tampil'];
        $data['cuti_terpakai']  = $saldo_info['terpakai_tampil'];
        $data['sisa_cuti']      = $saldo_info['sisa_tampil'];
        $data['mode_kuota']     = $saldo_info['mode'];
        $data['label_periode']  = $saldo_info['label_periode'];

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

        // Daftar Rekan Kerja Aktif untuk Pendelegasian Shift / Handover
        $data['rekan_kerja'] = $this->db->query("
            SELECT nik, nama_pegawai, jabatan 
            FROM data_pegawai 
            WHERE nik != ? AND hak_akses = '2'
            ORDER BY nama_pegawai ASC
        ", array($nik))->result();

        // Jika rekan sesama pegawai kosong, ambil semua staf selain dirinya
        if (empty($data['rekan_kerja'])) {
            $data['rekan_kerja'] = $this->db->query("
                SELECT nik, nama_pegawai, jabatan 
                FROM data_pegawai 
                WHERE nik != ? 
                ORDER BY nama_pegawai ASC
            ", array($nik))->result();
        }

        // Kalkulasi Saldo Cuti Berdasarkan Kebijakan Terpusat
        $saldo_info = $this->ModelPenggajian->hitung_saldo_cuti($nik);
        $data['saldo_cuti']     = $saldo_info;
        $data['hak_cuti_total'] = $saldo_info['kuota_total_tampil'];
        $data['cuti_terpakai']  = $saldo_info['terpakai_tampil'];
        $data['sisa_cuti']      = $saldo_info['sisa_tampil'];
        $data['mode_kuota']     = $saldo_info['mode'];
        $data['label_periode']  = $saldo_info['label_periode'];

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/tambah_cuti', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah_aksi() {
        $nik = $this->session->userdata('nik');
        $tanggal_mulai   = trim($this->input->post('tanggal_mulai', TRUE));
        $tanggal_akhir   = trim($this->input->post('tanggal_akhir', TRUE));
        $jenis_cuti      = trim($this->input->post('jenis_cuti', TRUE));
        $alasan          = trim($this->input->post('alasan', TRUE));
        $nik_pengganti   = trim($this->input->post('nik_pengganti', TRUE));
        $tugas_pengganti = trim($this->input->post('tugas_pengganti', TRUE));
        $kontak_darurat  = trim($this->input->post('kontak_darurat', TRUE));
        $alamat_cuti     = trim($this->input->post('alamat_cuti', TRUE));

        // 1. Validasi Kelengkapan Field Wajib
        if (empty($tanggal_mulai) || empty($tanggal_akhir) || empty($jenis_cuti) || empty($alasan) || empty($nik_pengganti) || empty($kontak_darurat)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pengajuan Gagal!</strong> Kolom tanggal, kategori cuti, alasan, rekan pengganti, dan kontak darurat wajib diisi lengkap.
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
                <strong>Format Tanggal Tidak Valid!</strong> Silakan tentukan tanggal mulai dan tanggal akhir yang valid.
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

        // Hitung durasi hari cuti
        $start_dt = new DateTime($tanggal_mulai);
        $end_dt = new DateTime($tanggal_akhir);
        $end_dt->modify('+1 day');
        $durasi_hari = $start_dt->diff($end_dt)->days;

        // 3. Validasi Kuota Cuti Tahunan Berdasarkan Kebijakan Terpusat
        if ($jenis_cuti == 'Tahunan') {
            $bulan_pengajuan = date('m', $time_mulai);
            $tahun_pengajuan = date('Y', $time_mulai);
            $saldo_info = $this->ModelPenggajian->hitung_saldo_cuti($nik, $bulan_pengajuan, $tahun_pengajuan);
            $mode = $saldo_info['mode'];

            // Cek batasan tahunan jika mode Tahunan atau Kombinasi
            if ($mode == 'Tahunan' || $mode == 'Kombinasi') {
                if ($durasi_hari > $saldo_info['sisa_tahunan']) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Kuota Cuti Tahunan Tidak Mencukupi!</strong> Pengajuan sebanyak ' . $durasi_hari . ' hari melebihi sisa hak cuti tahunan Anda (' . $saldo_info['sisa_tahunan'] . ' hari tersisa dari kuota ' . $saldo_info['kuota_tahunan'] . ' hari/tahun). Silakan sesuaikan durasi cuti atau ajukan Izin Khusus.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>');
                    redirect('pegawai/cuti/tambah');
                    return;
                }
            }

            // Cek batasan bulanan jika mode Bulanan atau Kombinasi
            if ($mode == 'Bulanan' || $mode == 'Kombinasi') {
                $max_bulan = $saldo_info['kuota_bulanan'];
                $sisa_bulan = $saldo_info['sisa_bulanan'];

                if ($durasi_hari > $sisa_bulan) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Batas Kuota Cuti Bulanan Terlampaui!</strong> Berdasarkan kebijakan klinik, batas maksimal pengambilan cuti per bulan adalah ' . $max_bulan . ' hari (sisa kuota bulan ' . date('F', $time_mulai) . ': ' . $sisa_bulan . ' hari). Pengajuan Anda sebanyak ' . $durasi_hari . ' hari melebihi batas yang diizinkan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>');
                    redirect('pegawai/cuti/tambah');
                    return;
                }
            }
        }

        // 4. Validasi Anti-Overlap (Pencegahan Bentrok Tanggal Cuti)
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
                <strong>Jadwal Bentrok!</strong> Anda sudah memiliki permohonan cuti (' . $bentrok->status_cuti . ') pada rentang tanggal ' . $fmt_mulai . ' s/d ' . $fmt_akhir . '. Tidak dapat mengajukan cuti ganda pada periode yang sama.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        // 5. Upload File Bukti Pendukung / SKD (Surat Keterangan Dokter)
        $file_lampiran = null;
        if (!empty($_FILES['file_lampiran']['name'])) {
            $config['upload_path']   = './uploads/cuti/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 3072; // Maksimal 3MB
            $config['file_name']     = 'skd_' . $nik . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_lampiran')) {
                $upload_data = $this->upload->data();
                $file_lampiran = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal Mengunggah Berkas Lampiran!</strong> ' . $this->upload->display_errors('', '') . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('pegawai/cuti/tambah');
                return;
            }
        } elseif ($jenis_cuti == 'Sakit') {
            // Cuti Sakit wajib menyertakan surat dokter untuk meyakinkan Direktur
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Wajib Surat Dokter!</strong> Untuk kategori Cuti Sakit, Anda wajib melampirkan foto / scan Surat Keterangan Dokter (SKD) resmi dengan cap faskes.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti/tambah');
            return;
        }

        // 6. Simpan ke Database
        $data = array(
            'nik'             => $nik,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_akhir'   => $tanggal_akhir,
            'jenis_cuti'      => $jenis_cuti,
            'alasan'          => $alasan,
            'nik_pengganti'   => $nik_pengganti,
            'tugas_pengganti' => $tugas_pengganti,
            'file_lampiran'   => $file_lampiran,
            'kontak_darurat'  => $kontak_darurat,
            'alamat_cuti'     => $alamat_cuti,
            'status_cuti'     => 'Menunggu',
            'status_approval' => 'Menunggu Review HRD'
        );

        $insert = $this->db->insert('data_cuti', $data);

        if ($insert) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Pengajuan Berhasil Dikirim!</strong> Permohonan cuti telah tersimpan lengkap dengan delegasi tugas dan berkas lampiran. Menunggu review verifikasi HRD sebelum diteruskan ke Direktur Utama.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Menyimpan!</strong> Terjadi kendala teknis pada database. Silakan coba beberapa saat lagi.
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

        if ($cuti->status_cuti != 'Menunggu') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Tidak Dapat Dibatalkan!</strong> Pengajuan ini sudah berstatus "' . $cuti->status_cuti . '" dan tidak dapat dibatalkan secara sepihak.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>');
            redirect('pegawai/cuti');
            return;
        }

        // Hapus file lampiran jika ada
        if (!empty($cuti->file_lampiran) && file_exists('./uploads/cuti/' . $cuti->file_lampiran)) {
            @unlink('./uploads/cuti/' . $cuti->file_lampiran);
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
            SELECT c.*, 
                   p.nama_pegawai, p.jabatan, p.jenis_kelamin, p.status as status_karyawan, p.tanggal_masuk, p.photo,
                   p2.nama_pegawai as nama_pengganti, p2.jabatan as jabatan_pengganti
            FROM data_cuti c
            JOIN data_pegawai p ON c.nik = p.nik
            LEFT JOIN data_pegawai p2 ON c.nik_pengganti = p2.nik
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
        $data['cuti']  = $cuti;

        $this->load->view('pegawai/cetak_surat_cuti', $data);
    }
}
