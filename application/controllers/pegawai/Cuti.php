<?php
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
        $data['title'] = "Riwayat Pengajuan Cuti/Izin";
        $nik = $this->session->userdata('nik');
        
        $data['cuti'] = $this->db->query("SELECT * FROM data_cuti WHERE nik='$nik' ORDER BY id_cuti DESC")->result();

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/data_cuti', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah() {
        $data['title'] = "Form Pengajuan Cuti/Izin";

        $this->load->view('template_pegawai/header', $data);
        $this->load->view('template_pegawai/sidebar');
        $this->load->view('pegawai/tambah_cuti', $data);
        $this->load->view('template_pegawai/footer');
    }

    public function tambah_aksi() {
        $nik = $this->session->userdata('nik');
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $jenis_cuti = $this->input->post('jenis_cuti');
        $alasan = $this->input->post('alasan');

        $data = array(
            'nik' => $nik,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis_cuti' => $jenis_cuti,
            'alasan' => $alasan,
            'status_cuti' => 'Menunggu'
        );

        $this->db->insert('data_cuti', $data);
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Pengajuan cuti/izin Anda sedang menunggu persetujuan HRD.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('pegawai/cuti');
    }
}
?>
