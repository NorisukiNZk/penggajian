<?php
class Laporan_Tahunan extends CI_Controller {

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
		$data['title'] = "Laporan Rekap Gaji Tahunan";

		$this->load->view('template_admin/header',$data);
		$this->load->view('template_admin/sidebar');
		$this->load->view('admin/gaji/laporan_tahunan_form');
		$this->load->view('template_admin/footer');
	}

	public function cetak_laporan_tahunan() {
		$data['title'] = "Cetak Laporan Gaji Tahunan";
	
		$tahun = $this->input->post('tahun', TRUE);
	
		if (empty($tahun)) {
			$tahun = date('Y');
		}
	
        // Ambil potongan alpha master
        $potongan_master = $this->ModelPenggajian->get_data('potongan_gaji')->result();
        $alpha_deduction = 0;
        foreach ($potongan_master as $pm) {
            if (strtolower($pm->potongan) == 'alpha') {
                $alpha_deduction = $pm->jml_potongan;
            }
        }
        
        // Ambil semua pegawai
        $pegawai = $this->db->query("SELECT p.nik, p.nama_pegawai, j.nama_jabatan, j.gaji_pokok, j.tj_transport, j.uang_makan 
            FROM data_pegawai p 
            INNER JOIN data_jabatan j ON p.jabatan = j.nama_jabatan 
            ORDER BY p.nama_pegawai ASC")->result();

        $rekap_tahunan = array();

        foreach($pegawai as $p) {
            // Inisialisasi total tahunan
            $total_gaji = 0;
            $total_tunjangan = 0;
            $total_potongan = 0;
            $total_lembur = 0;
            $total_bersih = 0;

            // Loop 12 bulan dalam setahun
            for($i = 1; $i <= 12; $i++) {
                $bulan_loop = str_pad($i, 2, '0', STR_PAD_LEFT);
                $bulantahun = $bulan_loop . $tahun;

                // Cek kehadiran bulan ini
                $kehadiran = $this->db->query("SELECT alpha FROM data_kehadiran WHERE nik = ? AND bulan = ?", array($p->nik, $bulantahun))->row();
                
                if($kehadiran) {
                    // Hitung Pendapatan Pasti
                    $gaji_bln = $p->gaji_pokok + $p->tj_transport + $p->uang_makan;
                    $total_gaji += $gaji_bln;

                    // Hitung Lembur
                    $lembur = $this->ModelPenggajian->hitung_uang_lembur($p->nik, $bulan_loop, $tahun);
                    $total_lembur += $lembur['uang_lembur'];

                    // Hitung Tunjangan Dinamis
                    $tj_dinamis = $this->ModelKomponen->hitung_total_tunjangan($p->nik, $bulantahun, $p->gaji_pokok);
                    $total_tunjangan += $tj_dinamis['total'];

                    // Hitung Potongan
                    $pot_alpha = $kehadiran->alpha * $alpha_deduction;
                    $pot_dinamis = $this->ModelKomponen->hitung_total_potongan($p->nik, $bulantahun, $p->gaji_pokok);
                    $total_potongan += ($pot_alpha + $pot_dinamis['total']);

                    // Hitung Bersih Bulan Ini
                    $bersih_bln = $gaji_bln + $lembur['uang_lembur'] + $tj_dinamis['total'] - ($pot_alpha + $pot_dinamis['total']);
                    $total_bersih += $bersih_bln;
                }
            }

            // Jika dia punya data gaji di tahun tersebut (total_bersih > 0), masukkan ke array laporan
            if($total_bersih > 0) {
                $rekap_tahunan[] = array(
                    'nik' => $p->nik,
                    'nama_pegawai' => $p->nama_pegawai,
                    'jabatan' => $p->nama_jabatan,
                    'gaji_tunjangan' => $total_gaji + $total_tunjangan,
                    'uang_lembur' => $total_lembur,
                    'potongan' => $total_potongan,
                    'gaji_bersih' => $total_bersih
                );
            }
        }

		$data['tahun'] = $tahun;
        $data['rekap'] = $rekap_tahunan;
	
		$this->load->view('template_admin/header', $data);
		$this->load->view('admin/gaji/cetak_laporan_tahunan', $data);
	}
}
?>
