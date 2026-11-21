<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller warisan (legacy) Data_Absensi.
 * Dipertahankan hanya sebagai pengalihan aman agar tautan lama tetap mengarah
 * ke modul modern Absensi Harian & Rekap Bulanan.
 */
class Data_Absensi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '1') {
			redirect('login');
		}
	}

	public function index()
	{
		redirect('admin/absensi_harian/rekap');
	}

	public function input_absensi()
	{
		redirect('admin/absensi_harian');
	}
}
