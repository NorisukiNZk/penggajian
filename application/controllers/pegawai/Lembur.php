<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lembur extends CI_Controller {

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
		$data['title'] = "Pengajuan Lembur";
		$nik = $this->session->userdata('nik');

		// Ambil data lembur pegawai yang bersangkutan
		$data['lembur'] = $this->db->query("SELECT * FROM data_lembur WHERE nik = ? ORDER BY tanggal_lembur DESC", array($nik))->result();

		$this->load->view('template_pegawai/header', $data);
		$this->load->view('template_pegawai/sidebar');
		$this->load->view('pegawai/lembur/data_lembur', $data);
		$this->load->view('template_pegawai/footer');
	}

	public function tambah_aksi()
	{
		$nik            = $this->session->userdata('nik');
		$tanggal_lembur = $this->input->post('tanggal_lembur');
		$jam_mulai      = $this->input->post('jam_mulai');
		$jam_selesai    = $this->input->post('jam_selesai');
		$keterangan     = $this->input->post('keterangan');

		// Hitung durasi
		$datetime1 = strtotime($jam_mulai);
		$datetime2 = strtotime($jam_selesai);
		
		if ($datetime2 < $datetime1) {
			// Jika lewat tengah malam (kasus jarang), tambahkan 1 hari (86400 detik)
			$datetime2 += 86400; 
		}
		
		$interval  = abs($datetime2 - $datetime1);
		$durasi_jam = round($interval / 3600); // bulatkan ke jam terdekat

		if ($durasi_jam <= 0) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Durasi lembur tidak valid.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('pegawai/lembur');
			return;
		}

		$data = array(
			'nik'            => $nik,
			'tanggal_lembur' => $tanggal_lembur,
			'jam_mulai'      => $jam_mulai,
			'jam_selesai'    => $jam_selesai,
			'durasi_jam'     => $durasi_jam,
			'keterangan'     => $keterangan,
			'status'         => 'Pending'
		);

		$this->db->insert('data_lembur', $data);
		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Berhasil!</strong> Pengajuan lembur telah dikirim dan menunggu persetujuan HRD.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('pegawai/lembur');
	}
}
?>
