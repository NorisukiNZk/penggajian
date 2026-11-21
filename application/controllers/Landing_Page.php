<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_Page extends CI_Controller {

	public function index()
	{
		$data['total_pegawai'] = (int)$this->db->count_all('data_pegawai');
		$data['total_jabatan'] = (int)$this->db->count_all('data_jabatan');
		$data['total_peran']   = 3;
		$data['total_laporan'] = 9;

		$this->load->view('landing_page', $data);
	}
}
