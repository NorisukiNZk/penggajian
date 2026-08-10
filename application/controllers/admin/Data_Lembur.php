<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_Lembur extends CI_Controller {

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
		$data['title'] = "Approval Data Lembur";
		
		// Ambil semua data lembur beserta nama pegawai
		$data['lembur'] = $this->db->query("
			SELECT data_lembur.*, data_pegawai.nama_pegawai, data_pegawai.jabatan 
			FROM data_lembur 
			INNER JOIN data_pegawai ON data_lembur.nik = data_pegawai.nik 
			ORDER BY data_lembur.status = 'Pending' DESC, data_lembur.tanggal_lembur DESC
		")->result();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/lembur/data_lembur', $data);
		$this->load->view('template_admin/footer');
	}

	public function aksi_approval()
	{
		$id_lembur = $this->input->post('id_lembur');
		$status = $this->input->post('status'); // 'Disetujui' atau 'Ditolak'

		$this->db->where('id_lembur', $id_lembur);
		$this->db->update('data_lembur', array('status' => $status));

		if ($status == 'Disetujui') {
			$pesan = "Pengajuan lembur disetujui.";
			$tipe = "success";
		} else {
			$pesan = "Pengajuan lembur ditolak.";
			$tipe = "danger";
		}

		$this->session->set_flashdata('pesan','<div class="alert alert-' . $tipe . ' alert-dismissible fade show" role="alert">
			<strong>Sukses!</strong> ' . $pesan . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/data_lembur');
	}
}
?>
