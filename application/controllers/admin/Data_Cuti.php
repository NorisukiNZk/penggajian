<?php
class Data_Cuti extends CI_Controller {
    
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

    public function index() {
        $data['title'] = "Data Pengajuan Cuti & Izin";
        
        $data['cuti'] = $this->db->query("
            SELECT data_cuti.*, data_pegawai.nama_pegawai, data_pegawai.jabatan 
            FROM data_cuti 
            INNER JOIN data_pegawai ON data_cuti.nik = data_pegawai.nik 
            ORDER BY id_cuti DESC
        ")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/data_cuti', $data);
        $this->load->view('template_admin/footer');
    }

    public function approve($id) {
        $pesan_admin = $this->input->post('pesan_admin');
        if (empty($pesan_admin)) $pesan_admin = 'Disetujui tanpa catatan khusus.';

        // Update status cuti dan simpan pesan admin
        $this->db->query("UPDATE data_cuti SET status_cuti = 'Disetujui', pesan_admin = '$pesan_admin' WHERE id_cuti = '$id'");

        // Optional/Advanced: Sinkronisasi ke absensi harian
        $cuti = $this->db->query("SELECT * FROM data_cuti WHERE id_cuti = '$id'")->row();
        
        $begin = new DateTime($cuti->tanggal_mulai);
        $end = new DateTime($cuti->tanggal_akhir);
        $end = $end->modify('+1 day'); // include the end date in DatePeriod

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        $status_absensi = 'izin';
        if($cuti->jenis_cuti == 'Sakit') $status_absensi = 'sakit';

        foreach($daterange as $date){
            $tgl = $date->format("Y-m-d");
            // Cek apakah sudah absen hari itu
            $cek = $this->db->query("SELECT * FROM absensi_harian WHERE nik = '$cuti->nik' AND tanggal = '$tgl'")->num_rows();
            if($cek == 0) {
                $this->db->insert('absensi_harian', array(
                    'nik' => $cuti->nik,
                    'tanggal' => $tgl,
                    'jam_masuk' => '00:00:00',
                    'jam_pulang' => '00:00:00',
                    'status' => $status_absensi,
                    'keterangan' => 'Cuti: ' . $cuti->alasan
                ));
            }
        }

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Pengajuan cuti disetujui dan telah disinkronkan ke Absensi Harian.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('admin/data_cuti');
    }

    public function reject($id) {
        $pesan_admin = $this->input->post('pesan_admin');
        if (empty($pesan_admin)) $pesan_admin = 'Ditolak (Tanpa Alasan Spesifik).';

        $this->db->query("UPDATE data_cuti SET status_cuti = 'Ditolak', pesan_admin = '$pesan_admin' WHERE id_cuti = '$id'");
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ditolak!</strong> Pengajuan cuti telah ditolak.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('admin/data_cuti');
    }
}
?>
