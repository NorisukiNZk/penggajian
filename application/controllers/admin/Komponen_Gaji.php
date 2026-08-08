<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komponen_Gaji extends CI_Controller {

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

	/**
	 * Halaman daftar semua komponen gaji
	 */
	public function index() 
	{
		$data['title'] = "Komponen Gaji (Tunjangan & Potongan)";
		$data['komponen'] = $this->ModelKomponen->get_all_komponen();

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/komponen/data_komponen', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Form tambah komponen baru
	 */
	public function tambah()
	{
		$data['title'] = "Tambah Komponen Gaji";

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/komponen/tambah_komponen', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Proses simpan komponen baru
	 */
	public function tambah_aksi()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE) {
			$this->tambah();
		} else {
			$data = array(
				'nama_komponen' => $this->input->post('nama_komponen'),
				'tipe'          => $this->input->post('tipe'),
				'nominal'       => $this->input->post('nominal'),
				'is_persentase' => $this->input->post('is_persentase') ? 1 : 0,
				'is_aktif'      => 1,
				'created_at'    => date('Y-m-d H:i:s')
			);

			$this->ModelKomponen->insert_komponen($data);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Komponen gaji berhasil ditambahkan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/komponen_gaji');
		}
	}

	/**
	 * Form edit komponen
	 */
	public function edit($id)
	{
		$data['title'] = "Edit Komponen Gaji";
		$data['komponen'] = $this->ModelKomponen->get_komponen_by_id($id);

		if (!$data['komponen']) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Komponen tidak ditemukan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/komponen_gaji');
		}

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/komponen/edit_komponen', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Proses update komponen
	 */
	public function edit_aksi()
	{
		$this->_rules();

		$id = $this->input->post('id_komponen');

		if($this->form_validation->run() == FALSE) {
			$this->edit($id);
		} else {
			$data = array(
				'nama_komponen' => $this->input->post('nama_komponen'),
				'tipe'          => $this->input->post('tipe'),
				'nominal'       => $this->input->post('nominal'),
				'is_persentase' => $this->input->post('is_persentase') ? 1 : 0,
			);

			$this->ModelKomponen->update_komponen($id, $data);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Komponen gaji berhasil diupdate!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/komponen_gaji');
		}
	}

	/**
	 * Hapus komponen
	 */
	public function hapus($id)
	{
		$this->ModelKomponen->delete_komponen($id);
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Komponen gaji berhasil dihapus!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/komponen_gaji');
	}

	/**
	 * Toggle status aktif/nonaktif
	 */
	public function toggle($id)
	{
		$this->ModelKomponen->toggle_status($id);
		$this->session->set_flashdata('pesan','<div class="alert alert-info alert-dismissible fade show" role="alert">
			<strong>Status komponen berhasil diubah!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/komponen_gaji');
	}

	/**
	 * Halaman kelola komponen per pegawai (override nominal)
	 */
	public function kelola_pegawai($id_komponen)
	{
		$data['title'] = "Kelola Komponen per Pegawai";
		$data['komponen'] = $this->ModelKomponen->get_komponen_by_id($id_komponen);

		if (!$data['komponen']) {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Komponen tidak ditemukan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
			redirect('admin/komponen_gaji');
		}

		// Ambil bulan & tahun dari GET
		if ($this->input->get('bulan', TRUE) != '' && $this->input->get('tahun', TRUE) != '') {
			$bulan = $this->input->get('bulan', TRUE);
			$tahun = $this->input->get('tahun', TRUE);
		} else {
			$bulan = date('m');
			$tahun = date('Y');
		}
		$bulantahun = $bulan . $tahun;

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['pegawai_komponen'] = $this->ModelKomponen->get_pegawai_komponen($id_komponen, $bulantahun);

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/komponen/kelola_pegawai', $data);
		$this->load->view('template_admin/footer');
	}

	/**
	 * Proses simpan override nominal per pegawai
	 */
	public function simpan_komponen_pegawai()
	{
		$id_komponen = $this->input->post('id_komponen');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$bulantahun = $bulan . $tahun;
		$nik_list = $this->input->post('nik');
		$nominal_list = $this->input->post('nominal_override');

		if ($nik_list && $nominal_list) {
			foreach ($nik_list as $key => $nik) {
				$nominal = $nominal_list[$key];
				if ($nominal !== '' && $nominal > 0) {
					$data = array(
						'id_komponen'     => $id_komponen,
						'nik'             => $nik,
						'bulan'           => $bulantahun,
						'nominal_override' => $nominal
					);
					$this->ModelKomponen->set_komponen_pegawai($data);
				}
			}
		}

		$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data komponen per pegawai berhasil disimpan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/komponen_gaji/kelola_pegawai/' . $id_komponen . '?bulan=' . $bulan . '&tahun=' . $tahun);
	}

	/**
	 * Hapus override komponen per pegawai
	 */
	public function hapus_komponen_pegawai($id_override, $id_komponen)
	{
		$this->ModelKomponen->delete_komponen_pegawai($id_override);
		$this->session->set_flashdata('pesan','<div class="alert alert-info alert-dismissible fade show" role="alert">
			<strong>Override komponen pegawai berhasil dihapus!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
		redirect('admin/komponen_gaji/kelola_pegawai/' . $id_komponen);
	}

	/**
	 * Validasi form
	 */
	public function _rules()
	{
		$this->form_validation->set_rules('nama_komponen', 'Nama Komponen', 'required');
		$this->form_validation->set_rules('tipe', 'Tipe', 'required');
		$this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
	}
}
?>
