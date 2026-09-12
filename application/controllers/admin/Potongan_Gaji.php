<?php
class Potongan_Gaji extends CI_Controller {

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
		redirect('admin/komponen_gaji?tab=potongan');
	}

	public function tambah_data_aksi() {
		$potongan		= $this->input->post('potongan');
		$jml_potongan	= $this->input->post('jml_potongan');

		if(empty($potongan) || empty($jml_potongan)) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Nama Potongan dan Jumlah wajib diisi.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		} else {
			$data = array(
				'potongan' 		=> $potongan,
				'jml_potongan' 	=> $jml_potongan,
			);
			$this->ModelPenggajian->insert_data($data, 'potongan_gaji');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Sukses!</strong> Data potongan berhasil ditambahkan.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		}
		redirect('admin/komponen_gaji?tab=potongan');
	}

	public function update_data_aksi() {
		$id				= $this->input->post('id');
		$potongan		= $this->input->post('potongan');
		$jml_potongan	= $this->input->post('jml_potongan');

		if(empty($potongan) || empty($jml_potongan)) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Gagal!</strong> Nama Potongan dan Jumlah wajib diisi.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		} else {
			$data = array(
				'potongan' 		=> $potongan,
				'jml_potongan' 	=> $jml_potongan,
			);

			$where = array(
				'id' => $id
			);

			$this->ModelPenggajian->update_data('potongan_gaji', $data, $where);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Sukses!</strong> Data potongan berhasil diupdate.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		}
		redirect('admin/komponen_gaji?tab=potongan');
	}

	public function _rules() {
		$this->form_validation->set_rules('potongan','Nama Potongan','required');
		$this->form_validation->set_rules('jml_potongan','Jumlah Potongan','required');
	}

	public function delete_data($id) {
		$where = array('id' => $id);
		$this->ModelPenggajian->delete_data($where, 'potongan_gaji');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
		redirect('admin/komponen_gaji?tab=potongan');
	}

}
?>