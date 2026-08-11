<?php
class Pinjaman extends CI_Controller {

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

    public function index() 
    {
        $data['title'] = "Pengajuan Pinjaman Karyawan";
        $nik = $this->session->userdata('nik');
        $data['pinjaman'] = $this->db->query("SELECT * FROM data_pinjaman WHERE nik = ? ORDER BY id_pinjaman DESC", array($nik))->result();

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/pinjaman/data_pinjaman', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah()
    {
        $data['title'] = "Ajukan Pinjaman Baru";

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/pinjaman/tambah_pinjaman', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah_aksi()
    {
        $this->form_validation->set_rules('jumlah_pinjaman', 'Jumlah Pinjaman', 'required|numeric');
        $this->form_validation->set_rules('tenor_bulan', 'Tenor', 'required|numeric');
        $this->form_validation->set_rules('alasan', 'Alasan', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $nik = $this->session->userdata('nik');
            $jumlah_pinjaman = $this->input->post('jumlah_pinjaman');
            $tenor_bulan = $this->input->post('tenor_bulan');
            $alasan = $this->input->post('alasan');

            $data = array(
                'nik' => $nik,
                'tgl_pengajuan' => date('Y-m-d'),
                'jumlah_pinjaman' => $jumlah_pinjaman,
                'tenor_bulan' => $tenor_bulan,
                'alasan' => $alasan,
                'status' => 'Pending'
            );

            $this->db->insert('data_pinjaman', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Pengajuan pinjaman telah dikirim, menunggu persetujuan HRD.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('pegawai/pinjaman');
        }
    }
}
?>
