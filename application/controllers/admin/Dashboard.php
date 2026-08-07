<?php

class Dashboard extends CI_Controller {

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
		$data['title'] = "Dashboard Analytics";
		$hari_ini = date('Y-m-d');

		// 1. Top Cards: Total Pegawai & Absensi Hari Ini
		$data['total_pegawai'] = $this->db->query("SELECT * FROM data_pegawai")->num_rows();
		
		// Asumsi menggunakan absensi_harian jika ada, jika tidak 0
		$q_hadir = $this->db->query("SELECT * FROM absensi_harian WHERE tanggal='$hari_ini' AND status='tepat_waktu'");
		$data['hadir_hari_ini'] = $q_hadir ? $q_hadir->num_rows() : 0;

		$q_terlambat = $this->db->query("SELECT * FROM absensi_harian WHERE tanggal='$hari_ini' AND status='terlambat'");
		$data['terlambat_hari_ini'] = $q_terlambat ? $q_terlambat->num_rows() : 0;

		$q_sakit_izin = $this->db->query("SELECT * FROM absensi_harian WHERE tanggal='$hari_ini' AND status IN ('sakit', 'izin')");
		$data['sakit_izin_hari_ini'] = $q_sakit_izin ? $q_sakit_izin->num_rows() : 0;

		// 2. Data Grafik 1: Distribusi Jabatan (Pie Chart)
		$distribusi_jabatan = $this->db->query("SELECT jabatan, COUNT(*) as jumlah FROM data_pegawai GROUP BY jabatan")->result();
		$label_jabatan = [];
		$data_jabatan = [];
		foreach($distribusi_jabatan as $dj) {
			$label_jabatan[] = $dj->jabatan;
			$data_jabatan[] = $dj->jumlah;
		}
		$data['label_jabatan'] = json_encode($label_jabatan);
		$data['data_jabatan'] = json_encode($data_jabatan);

		// 3. Data Grafik 2: Trend Kehadiran 6 Bulan Terakhir (Line Chart)
		// Mengambil rekap kehadiran, diurutkan berdasarkan format bulan tahun mY
		$trend_query = $this->db->query("
			SELECT bulan, SUM(hadir) as total_hadir, SUM(sakit) as total_sakit, SUM(alpha) as total_alpha 
			FROM data_kehadiran 
			GROUP BY bulan 
			ORDER BY STR_TO_DATE(CONCAT('01', bulan), '%d%m%Y') ASC 
			LIMIT 6
		")->result();

		$label_bulan = [];
		$trend_hadir = [];
		$trend_sakit = [];
		$trend_alpha = [];

		$nama_bulan = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agt','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des');

		foreach($trend_query as $tq) {
			$b = substr($tq->bulan, 0, 2);
			$y = substr($tq->bulan, 2, 4);
			$label_bulan[] = (isset($nama_bulan[$b]) ? $nama_bulan[$b] : $b) . " " . $y;
			$trend_hadir[] = $tq->total_hadir;
			$trend_sakit[] = $tq->total_sakit;
			$trend_alpha[] = $tq->total_alpha;
		}
		$data['label_bulan'] = json_encode($label_bulan);
		$data['trend_hadir'] = json_encode($trend_hadir);
		$data['trend_sakit'] = json_encode($trend_sakit);
		$data['trend_alpha'] = json_encode($trend_alpha);

		// Data Hari Libur Nasional (Terdekat)
		$data['hari_libur'] = $this->db->query("SELECT * FROM hari_libur WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 5")->result();

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('template_admin/footer', $data);
	}
}
?>