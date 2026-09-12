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

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['bulantahun'] = $bulantahun;

		$data['potongan'] = $this->ModelPenggajian->get_data('potongan_gaji')->result();
		$data['gaji'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,
			data_pegawai.jenis_kelamin,data_pegawai.photo,data_jabatan.nama_jabatan,data_jabatan.gaji_pokok,
			data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
			WHERE data_kehadiran.bulan=?
			ORDER BY data_pegawai.nama_pegawai ASC", array($bulantahun))->result();

		$alpha_rate = 0;
		foreach ($data['potongan'] as $p) {
			if (strtolower($p->potongan) == 'alpha') {
				$alpha_rate = (int)$p->jml_potongan;
			}
		}

		$total_take_home_pay = 0;
		$total_gaji_pokok_all = 0;
		$total_variabel_lembur = 0;
		$total_potongan_all = 0;
		$total_jam_lembur_all = 0;

		$data['komponen_per_pegawai'] = array();
		foreach ($data['gaji'] as $g) {
			$tunjangan = $this->ModelKomponen->hitung_total_tunjangan($g->nik, $bulantahun, $g->gaji_pokok);
			$potongan_dinamis = $this->ModelKomponen->hitung_total_potongan($g->nik, $bulantahun, $g->gaji_pokok);
			$lembur = $this->ModelPenggajian->hitung_uang_lembur($g->nik, $bulan, $tahun);
			$pinjaman = $this->ModelPenggajian->hitung_potongan_pinjaman($g->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam'],
				'pinjaman'    => $pinjaman
			);

			$pot_alpha = (int)$g->alpha * $alpha_rate;
			$net_salary = (int)$g->gaji_pokok + (int)$g->tj_transport + (int)$g->uang_makan + (int)$lembur['uang_lembur'] + (int)$tunjangan['total'] - $pot_alpha - (int)$potongan_dinamis['total'] - (int)$pinjaman['total'];

			$total_take_home_pay += $net_salary;
			$total_gaji_pokok_all += (int)$g->gaji_pokok + (int)$g->tj_transport + (int)$g->uang_makan;
			$total_variabel_lembur += (int)$lembur['uang_lembur'] + (int)$tunjangan['total'];
			$total_potongan_all += $pot_alpha + (int)$potongan_dinamis['total'] + (int)$pinjaman['total'];
			$total_jam_lembur_all += (float)$lembur['total_jam'];
		}

		$data['kpi'] = array(
			'total_thp'          => $total_take_home_pay,
			'total_pokok_tetap'  => $total_gaji_pokok_all,
			'total_variabel'     => $total_variabel_lembur,
			'total_potongan'     => $total_potongan_all,
			'total_jam_lembur'   => $total_jam_lembur_all,
			'total_pegawai_gaji' => count($data['gaji'])
		);

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
		
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
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

            // Hitung Pinjaman
            $pinjaman = $this->ModelPenggajian->hitung_potongan_pinjaman($g->nik, $bulan, $tahun);

			$data['komponen_per_pegawai'][$g->nik] = array(
				'tunjangan'   => $tunjangan,
				'potongan'    => $potongan_dinamis,
				'uang_lembur' => $lembur['uang_lembur'],
				'jam_lembur'  => $lembur['total_jam'],
                'pinjaman'    => $pinjaman
			);
		}

		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_gaji', $data);
	}
}
?>