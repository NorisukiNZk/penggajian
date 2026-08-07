<?php
class Hari_Libur extends CI_Controller {
    
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
        $data['title'] = "Manajemen Hari Libur Nasional & Cuti Bersama";
        $data['libur'] = $this->db->query("SELECT * FROM hari_libur ORDER BY tanggal ASC")->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/hari_libur', $data);
        $this->load->view('template_admin/footer');
    }

    public function tambah_aksi() {
        $tanggal = $this->input->post('tanggal');
        $keterangan = $this->input->post('keterangan');

        // Check for duplicate
        $cek = $this->db->query("SELECT * FROM hari_libur WHERE tanggal = '$tanggal'")->num_rows();
        
        if ($cek > 0) {
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Tanggal merah tersebut sudah ada di database.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
        } else {
            $data = array(
                'tanggal' => $tanggal,
                'keterangan' => $keterangan
            );
            $this->db->insert('hari_libur', $data);
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Tanggal merah berhasil ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
        }
        redirect('admin/hari_libur');
    }

    public function hapus($id) {
        $this->db->where('id_libur', $id);
        $this->db->delete('hari_libur');

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Tanggal merah berhasil dihapus.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
        redirect('admin/hari_libur');
    }

    public function sync_api() {
        $year = date('Y');
        // Menggunakan sumber JSON statis dari Github (lebih stabil daripada API Vercel gratisan)
        $url = "https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); // 15 detik timeout (file cukup besar)
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 && $output) {
            $data = json_decode($output, true);
            $berhasil = 0;
            if (is_array($data)) {
                foreach($data as $tanggal => $info) {
                    // Hanya filter tahun saat ini
                    if (strpos($tanggal, (string)$year) === 0) {
                        // Hanya ambil jika benar-benar hari libur
                        if (isset($info['holiday']) && $info['holiday'] == true) {
                            $keterangan = implode(", ", $info['summary']);
                            
                            // Cek duplikat agar tidak dobel
                            $cek = $this->db->get_where('hari_libur', array('tanggal' => $tanggal))->num_rows();
                            if($cek == 0) {
                                $this->db->insert('hari_libur', array(
                                    'tanggal' => $tanggal,
                                    'keterangan' => $keterangan
                                ));
                                $berhasil++;
                            }
                        }
                    }
                }
                
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sync API Berhasil!</strong> '.$berhasil.' data libur nasional ditarik secara otomatis.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            }
        } else {
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Sync API!</strong> Server Github sedang tidak merespon (HTTP '.$http_code.') atau butuh koneksi internet. Silakan input manual sementara waktu.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
        }
        redirect('admin/hari_libur');
    }
}
?>
