<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_Page extends CI_Controller {

	public function index() 
	{
		$data['total_pegawai'] = $this->db->count_all('data_pegawai');
		$data['total_jabatan'] = $this->db->count_all('data_jabatan');
		$data['total_laporan'] = 10; // 10 Format Laporan Resmi Berstandar QR Code

		$this->load->view('landing_page', $data);
	}
}
