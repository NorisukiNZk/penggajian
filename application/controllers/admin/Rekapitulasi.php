<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapitulasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model atau library yang diperlukan
    }

    public function index() {
        // Logika untuk menampilkan form rekapitulasi
        $data['title'] = "Rekapitulasi Alpa dan Sakit";
        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/pegawai/rekapitulasi_form', $data);
        $this->load->view('template_admin/footer');
    }

    public function proses_rekapitulasi() {
        // Logika untuk memproses data rekapitulasi
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        // Query untuk mendapatkan data pegawai berdasarkan bulan dan tahun
        $this->db->select('nama_pegawai, status, COUNT(*) as jumlah');
        $this->db->from('data_pegawai');
        $this->db->where('MONTH(tanggal_masuk)', $bulan);
        $this->db->where('YEAR(tanggal_masuk)', $tahun);
        $this->db->group_by('nama_pegawai, status');
        $data['rekapitulasi'] = $this->db->get()->result();

        // Siapkan judul laporan
        $data['title'] = "Rekapitulasi Alpa dan Sakit Bulan $bulan Tahun $tahun";

        // Load view untuk menampilkan hasil rekapitulasi
        $this->load->view('admin/pegawai/rekapitulasi_cetak', $data);
    }
    public function cetak()
    {
        $data['title'] = "Data Pegawai";
        $data['pegawai'] = $this->ModelPenggajian->get_data('data_pegawai')->result();
    
        // Load view untuk cetak
        $this->load->view('admin/pegawai/cetak_dataPegawai', $data);
    }
    
}