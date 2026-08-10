<?php

class Data_Penggajian extends CI_Controller {

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
		$data['title'] = "Data Gaji Pegawai";
		$bulan = $this->input->get('bulan', TRUE);
		$tahun = $this->input->get('tahun', TRUE);
		if(!empty($bulan) && !empty($tahun)){
			$bulantahun = $bulan.$tahun;
		}else{
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan.$tahun;
		}
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['gaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,
			data_pegawai.jenis_kelamin,data_jabatan.nama_jabatan,data_jabatan.gaji_pokok,
			data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
			WHERE data_kehadiran.bulan=?
			ORDER BY data_pegawai.nama_pegawai ASC", array($bulantahun))->result();

		// Komponen dinamis: hitung per pegawai
		$data['komponen_per_pegawai'] = array();
		foreach ($data['gaji'] as $g) {
			$tunjangan = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			
			// Hitung Lembur
			$lembur = $this->ModelPenggajian->hitung_uang_lembur($g->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam']
			);
		}

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/data_gaji', $data);
		$this->load->view('template_admin/footer');
	}

	public function cetak_gaji(){

	$data['title'] = "Cetak Data Gaji Pegawai";
		$bulan = $this->input->get('bulan', TRUE);
		$tahun = $this->input->get('tahun', TRUE);
		if(!empty($bulan) && !empty($tahun)){
			$bulantahun = $bulan.$tahun;
		}else{
			$bulan = date('m');
			$tahun = date('Y');
			$bulantahun = $bulan.$tahun;
		}
		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['cetak_gaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,
			data_pegawai.jenis_kelamin,data_jabatan.nama_jabatan,data_jabatan.gaji_pokok,
			data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
			WHERE data_kehadiran.bulan=?
			ORDER BY data_pegawai.nama_pegawai ASC", array($bulantahun))->result();

		// Komponen dinamis: hitung per pegawai
		$data['komponen_per_pegawai'] = array();
		foreach ($data['cetak_gaji'] as $g) {
			$tunjangan = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			
			// Hitung Lembur
			$lembur = $this->ModelPenggajian->hitung_uang_lembur($g->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam']
			);
		}

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}
?>