<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('hak_akses') != '1'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Akses Ditolak!</strong> Anda harus login sebagai Administrator.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "Pusat Laporan & Rekapitulasi Terpadu";

        $bulan_ini = date('m');
        $tahun_ini = date('Y');

        // Ringkasan cepat metrik operasional & payroll klinik
        $data['total_pegawai'] = $this->db->count_all('data_pegawai');
        $data['total_jabatan'] = $this->db->count_all('data_jabatan');
        
        $q_cuti = $this->db->query("SELECT COUNT(*) as total FROM data_cuti WHERE MONTH(tanggal_mulai) = ? AND YEAR(tanggal_mulai) = ? AND status_cuti = 'Disetujui'", array($bulan_ini, $tahun_ini));
        $data['cuti_bulan_ini'] = ($q_cuti && $q_cuti->row()) ? ($q_cuti->row()->total ?? 0) : 0;
        
        $q_lembur = $this->db->query("SELECT COUNT(*) as total, SUM(durasi_jam) as jam FROM data_lembur WHERE DATE_FORMAT(tanggal_lembur, '%Y-%m') = ? AND status = 'Disetujui'", array($tahun_ini . '-' . $bulan_ini));
        $data['lembur_bulan_ini'] = ($q_lembur && $q_lembur->row()) ? $q_lembur->row() : (object)['total' => 0, 'jam' => 0];
        
        $q_pinjaman = $this->db->query("SELECT COUNT(*) as total, SUM(jumlah_pinjaman) as sisa FROM data_pinjaman WHERE status = 'Disetujui'");
        $data['pinjaman_aktif'] = ($q_pinjaman && $q_pinjaman->row()) ? $q_pinjaman->row() : (object)['total' => 0, 'sisa' => 0];

        $data['bulan_aktif'] = $bulan_ini;
        $data['tahun_aktif'] = $tahun_ini;

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('template_admin/footer');
    }
}
?>
