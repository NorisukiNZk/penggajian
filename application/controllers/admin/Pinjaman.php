<?php
class Pinjaman extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('hak_akses') != '1'){
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
        $data['title'] = "Data Pinjaman Karyawan";
        $data['pinjaman'] = $this->db->query("SELECT p.*, g.nama_pegawai, j.nama_jabatan 
                                              FROM data_pinjaman p
                                              JOIN data_pegawai g ON p.nik = g.nik
                                              JOIN data_jabatan j ON g.jabatan = j.nama_jabatan
                                              ORDER BY p.id_pinjaman DESC")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/pinjaman/data_pinjaman', $data);
        $this->load->view('template_admin/footer');
    }

    public function setujui($id)
    {
        $data = array(
            'status' => 'Disetujui',
            'tgl_disetujui' => date('Y-m-d')
        );
        $this->db->where('id_pinjaman', $id);
        $this->db->update('data_pinjaman', $data);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Pengajuan Pinjaman Disetujui.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin/pinjaman');
    }

    public function tolak($id)
    {
        $data = array(
            'status' => 'Ditolak'
        );
        $this->db->where('id_pinjaman', $id);
        $this->db->update('data_pinjaman', $data);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Pengajuan Pinjaman Ditolak.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('admin/pinjaman');
    }
}
?>
