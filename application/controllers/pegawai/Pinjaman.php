<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjaman extends CI_Controller {

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

    public function index() 
    {
        $data['title'] = "Pengajuan Pinjaman & Kasbon Pegawai";
        $nik = $this->session->userdata('nik');

        // Ambil riwayat pinjaman pegawai
        $data['pinjaman'] = $this->db->query("
            SELECT * FROM data_pinjaman 
            WHERE nik = ? 
            ORDER BY id_pinjaman DESC
        ", array($nik))->result();

        // Hitung Metrik KPI Personal Pegawai
        $data['kpi_total'] = count($data['pinjaman']);
        $data['kpi_pending'] = 0;
        $data['kpi_aktif'] = 0;
        $data['kpi_lunas'] = 0;

        foreach ($data['pinjaman'] as $p) {
            if ($p->status == 'Pending') $data['kpi_pending']++;
            elseif ($p->status == 'Disetujui') $data['kpi_aktif']++;
            elseif ($p->status == 'Lunas') $data['kpi_lunas']++;
        }

        // Ambil profil pegawai untuk verifikasi status aktif
        $data['pegawai'] = $this->db->query("
            SELECT p.*, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
            FROM data_pegawai p
            LEFT JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
            WHERE p.nik = ?
        ", array($nik))->row();

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/pinjaman/data_pinjaman', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah()
    {
        $data['title'] = "Formulir Pengajuan Pinjaman / Kasbon";
        $nik = $this->session->userdata('nik');

        // Ambil profil lengkap pegawai beserta jabatan & komponen gaji
        $pegawai = $this->db->query("
            SELECT p.*, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
            FROM data_pegawai p
            LEFT JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
            WHERE p.nik = ?
        ", array($nik))->row();

        if (!$pegawai) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Profil Tidak Ditemukan!</strong> Hubungi Administrator HRD.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman');
            return;
        }

        // 1. Hitung Masa Kerja Pegawai
        $tgl_masuk = new DateTime($pegawai->tanggal_masuk);
        $today = new DateTime();
        $interval = $tgl_masuk->diff($today);
        $total_bulan_kerja = ($interval->y * 12) + $interval->m;

        $data['pegawai'] = $pegawai;
        $data['masa_kerja_tahun'] = $interval->y;
        $data['masa_kerja_bulan'] = $interval->m;
        $data['total_bulan_kerja'] = $total_bulan_kerja;
        $data['is_eligible_tenure'] = ($total_bulan_kerja >= 6); // Syarat minimal 6 bulan kerja

        // 2. Hitung Batas Finansial
        $gaji_pokok = floatval($pegawai->gaji_pokok);
        $tj_transport = floatval($pegawai->tj_transport);
        $uang_makan = floatval($pegawai->uang_makan);
        $total_gaji = $gaji_pokok + $tj_transport + $uang_makan;

        $data['gaji_pokok'] = $gaji_pokok;
        $data['total_gaji'] = $total_gaji;
        $data['plafon_maksimal'] = $gaji_pokok * 2; // Maksimal 2x Gaji Pokok
        $data['cicilan_maksimal'] = $total_gaji * 0.40; // Maksimal beban cicilan 40% dari total gaji

        // 3. Cek apakah masih ada pinjaman pending atau pinjaman aktif yang belum lunas
        $data['has_active_loan'] = $this->db->query("
            SELECT * FROM data_pinjaman 
            WHERE nik = ? 
              AND status IN ('Pending', 'Disetujui') 
            LIMIT 1
        ", array($nik))->row();

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/pinjaman/tambah_pinjaman', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah_aksi()
    {
        $nik = $this->session->userdata('nik');

        // Ambil data profil pegawai & jabatan
        $pegawai = $this->db->query("
            SELECT p.*, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan
            FROM data_pegawai p
            LEFT JOIN data_jabatan j ON p.jabatan = j.nama_jabatan
            WHERE p.nik = ?
        ", array($nik))->row();

        if (!$pegawai) {
            redirect('pegawai/pinjaman');
            return;
        }

        // Hitung masa kerja
        $tgl_masuk = new DateTime($pegawai->tanggal_masuk);
        $today = new DateTime();
        $diff = $tgl_masuk->diff($today);
        $total_bulan_kerja = ($diff->y * 12) + $diff->m;

        // 1. Validasi Masa Kerja (Minimal 6 Bulan)
        if ($total_bulan_kerja < 6) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pengajuan Gagal!</strong> Anda belum memenuhi syarat masa kerja minimal 6 bulan (Masa kerja Anda saat ini: ' . $diff->y . ' tahun ' . $diff->m . ' bulan).
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman/tambah');
            return;
        }

        // 2. Validasi Pinjaman Aktif / Pending (One Active Loan Rule)
        $active_loan = $this->db->query("
            SELECT id_pinjaman, status, jumlah_pinjaman FROM data_pinjaman 
            WHERE nik = ? AND status IN ('Pending', 'Disetujui')
            LIMIT 1
        ", array($nik))->row();

        if ($active_loan) {
            $status_txt = ($active_loan->status == 'Pending') ? 'masih dalam antrean verifikasi' : 'masih aktif dan belum lunas';
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Pengajuan Ditolak!</strong> Anda ' . $status_txt . '. Klinik menerapkan prinsip <em>One Active Loan Rule</em> demi kesehatan finansial pegawai.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman');
            return;
        }

        // 3. Validasi Form Input
        $jumlah_pinjaman = floatval($this->input->post('jumlah_pinjaman', TRUE));
        $tenor_bulan = intval($this->input->post('tenor_bulan', TRUE));
        $alasan = trim($this->input->post('alasan', TRUE));
        $kontak_nama = trim($this->input->post('kontak_darurat_nama', TRUE));
        $kontak_hp = trim($this->input->post('kontak_darurat_hp', TRUE));
        $kontak_hub = trim($this->input->post('kontak_darurat_hubungan', TRUE));

        $gaji_pokok = floatval($pegawai->gaji_pokok);
        $total_gaji = $gaji_pokok + floatval($pegawai->tj_transport) + floatval($pegawai->uang_makan);
        $plafon_maks = $gaji_pokok * 2;

        if ($jumlah_pinjaman <= 0 || $tenor_bulan <= 0 || empty($alasan) || empty($kontak_nama) || empty($kontak_hp) || empty($kontak_hub)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Belum Lengkap!</strong> Seluruh kolom formulir termasuk kontak darurat wajib diisi.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman/tambah');
            return;
        }

        // 4. Validasi Plafon Maksimal
        if ($jumlah_pinjaman > $plafon_maks) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Melebihi Plafon Kredit!</strong> Nominal pinjaman maksimal untuk jabatan Anda adalah <strong>Rp ' . number_format($plafon_maks, 0, ',', '.') . '</strong> (2x Gaji Pokok).
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman/tambah');
            return;
        }

        // 5. Validasi Beban Cicilan (Debt Service Ratio maks. 40% dari Total Gaji)
        $cicilan_per_bulan = ceil($jumlah_pinjaman / $tenor_bulan);
        $batas_cicilan = $total_gaji * 0.40;

        if ($cicilan_per_bulan > $batas_cicilan) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Beban Cicilan Terlalu Tinggi!</strong> Estimasi cicilan (Rp ' . number_format($cicilan_per_bulan, 0, ',', '.') . '/bln) melebihi batas aman 40% gaji Anda (Maks: Rp ' . number_format($batas_cicilan, 0, ',', '.') . '/bln). Silakan perpanjang tenor angsuran atau kurangi nominal pinjaman.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman/tambah');
            return;
        }

        // 6. Handle Upload File KTP (Wajib)
        $this->load->library('upload');
        $file_ktp = '';
        $file_jaminan = '';

        if (!empty($_FILES['file_ktp']['name'])) {
            $config['upload_path']   = './uploads/pinjaman/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 3072; // 3 MB
            $config['file_name']     = 'ktp_' . $nik . '_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_ktp')) {
                $uploadData = $this->upload->data();
                $file_ktp = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal Upload KTP!</strong> ' . $this->upload->display_errors('', '') . '
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>');
                redirect('pegawai/pinjaman/tambah');
                return;
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Foto KTP Wajib Dilampirkan!</strong> Silakan unggah foto identitas KTP Anda untuk validasi hukum.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman/tambah');
            return;
        }

        // 7. Handle Upload File Jaminan / Ijazah / Pendukung (Opsional)
        if (!empty($_FILES['file_jaminan']['name'])) {
            $config2['upload_path']   = './uploads/pinjaman/';
            $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config2['max_size']      = 5120; // 5 MB
            $config2['file_name']     = 'jaminan_' . $nik . '_' . time();

            $this->upload->initialize($config2);

            if ($this->upload->do_upload('file_jaminan')) {
                $uploadData2 = $this->upload->data();
                $file_jaminan = $uploadData2['file_name'];
            }
        }

        // 8. Simpan ke Database
        $data_insert = array(
            'nik'                     => $nik,
            'tgl_pengajuan'           => date('Y-m-d'),
            'jumlah_pinjaman'         => $jumlah_pinjaman,
            'tenor_bulan'             => $tenor_bulan,
            'alasan'                  => $alasan,
            'file_ktp'                => $file_ktp,
            'file_jaminan'            => $file_jaminan,
            'kontak_darurat_nama'     => $kontak_nama,
            'kontak_darurat_hp'       => $kontak_hp,
            'kontak_darurat_hubungan' => $kontak_hub,
            'status'                  => 'Pending',
            'sisa_tenor'              => $tenor_bulan
        );

        $insert = $this->db->insert('data_pinjaman', $data_insert);

        if ($insert) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Pengajuan Pinjaman Terkirim!</strong> Permohonan kasbon Anda telah masuk ke sistem dan sedang menunggu verifikasi Pimpinan / HRD.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Menyimpan Data!</strong> Terjadi kesalahan sistem saat memproses pengajuan.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
        }

        redirect('pegawai/pinjaman');
    }

    public function batal($id = null)
    {
        if (!$id) {
            redirect('pegawai/pinjaman');
            return;
        }

        $nik = $this->session->userdata('nik');
        $pinjaman = $this->db->get_where('data_pinjaman', array('id_pinjaman' => $id, 'nik' => $nik))->row();

        if (!$pinjaman) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data Tidak Ditemukan!</strong> Pengajuan pinjaman tidak valid.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman');
            return;
        }

        if ($pinjaman->status != 'Pending') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Tidak Dapat Dibatalkan!</strong> Pengajuan ini sudah berstatus "' . $pinjaman->status . '" dan telah diproses oleh manajemen.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman');
            return;
        }

        // Hapus file dokumen fisik jika ada
        if (!empty($pinjaman->file_ktp) && file_exists(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_ktp)) {
            unlink(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_ktp);
        }
        if (!empty($pinjaman->file_jaminan) && file_exists(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_jaminan)) {
            unlink(FCPATH . 'uploads/pinjaman/' . $pinjaman->file_jaminan);
        }

        $this->db->delete('data_pinjaman', array('id_pinjaman' => $id, 'nik' => $nik));

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Pengajuan Dibatalkan!</strong> Berkas permohonan pinjaman Anda berhasil ditarik dan dibatalkan.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>');

        redirect('pegawai/pinjaman');
    }

    public function cetak_sppk($id = null)
    {
        if (!$id) {
            redirect('pegawai/pinjaman');
            return;
        }

        $nik = $this->session->userdata('nik');
        $pinjaman = $this->db->query("
            SELECT p.*, g.nama_pegawai, g.jenis_kelamin, g.status as status_karyawan, g.tanggal_masuk, j.nama_jabatan, j.gaji_pokok
            FROM data_pinjaman p
            JOIN data_pegawai g ON p.nik = g.nik
            LEFT JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
            WHERE p.id_pinjaman = ? AND p.nik = ?
        ", array($id, $nik))->row();

        if (!$pinjaman) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Dokumen Tidak Ditemukan!</strong> Surat perjanjian pinjaman tidak dapat diakses.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>');
            redirect('pegawai/pinjaman');
            return;
        }

        $data['title'] = "Surat Perjanjian Pinjaman Karyawan (SPPK)";
        $data['p'] = $pinjaman;

        $this->load->view('admin/pinjaman/cetak_sppk', $data);
    }
}
