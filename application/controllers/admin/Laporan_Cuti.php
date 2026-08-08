<?php
class Laporan_Cuti extends CI_Controller {

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
		$data['title'] = "Laporan Cuti Pegawai";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/cuti/laporan_cuti_form', $data);
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_cuti() {
		$data['title'] = "Cetak Laporan Cuti Pegawai";
	
		$bulan = $this->input->post('bulan', TRUE);
		$tahun = $this->input->post('tahun', TRUE);
	
		if(empty($bulan) || empty($tahun)) {
			$bulan = date('m');
			$tahun = date('Y');
		}

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // Ambil data cuti yang disetujui pada bulan & tahun tersebut
        // Membandingkan tanggal_mulai dengan bulan/tahun yang difilter
        $this->db->select('data_cuti.*, data_pegawai.nama_pegawai, data_pegawai.jabatan');
        $this->db->from('data_cuti');
        $this->db->join('data_pegawai', 'data_cuti.nik = data_pegawai.nik');
        $this->db->where('MONTH(data_cuti.tanggal_mulai)', $bulan);
        $this->db->where('YEAR(data_cuti.tanggal_mulai)', $tahun);
        $this->db->where('data_cuti.status_cuti', 'Disetujui');
        $this->db->order_by('data_cuti.tanggal_mulai', 'ASC');

        $data['laporan_cuti'] = $this->db->get()->result();
	
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/cuti/cetak_laporan_cuti', $data);
	}
}
?>
