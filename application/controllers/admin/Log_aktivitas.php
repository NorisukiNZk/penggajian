<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_aktivitas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('hak_akses') != '1') {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Akses Ditolak!</strong> Anda harus login sebagai Administrator.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>');
			redirect('login');
		}
	}

	public function index()
	{
		$modul  = trim((string)$this->input->get('modul', TRUE));
		$search = trim((string)$this->input->get('q', TRUE));

		$filters = array(
			'modul'  => $modul,
			'search' => $search
		);

		$data['title']   = 'Log Aktivitas & Audit Sistem';
		$data['modul']   = $modul;
		$data['search']  = $search;
		$data['modules'] = $this->ModelAudit->get_distinct_modules();
		$data['logs']    = $this->ModelAudit->get_logs($filters, 200, 0);

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/log_aktivitas', $data);
		$this->load->view('template_admin/footer');
	}
}
