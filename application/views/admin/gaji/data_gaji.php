<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<div class="card shadow mb-4 border-0">
		<div class="card-header bg-modern-blue text-white d-flex flex-row align-items-center justify-content-between" style="border-radius: 10px 10px 0 0;">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-filter mr-2"></i> Filter Data Gaji Pegawai</h6>
		</div>
		<div class="card-body">
			<form class="form-inline">
				<div class="form-group mb-2">
					<label for="bulan" class="font-weight-bold mr-2">Bulan</label>
					<select class="form-control form-control-sm" name="bulan" id="bulan">
						<option value="">-- Pilih Bulan --</option>
						<option value="01">Januari</option>
						<option value="02">Februari</option>
						<option value="03">Maret</option>
						<option value="04">April</option>
						<option value="05">Mei</option>
						<option value="06">Juni</option>
						<option value="07">Juli</option>
						<option value="08">Agustus</option>
						<option value="09">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Desember</option>
					</select>
				</div>
				<div class="form-group mb-2 ml-4">
					<label for="tahun" class="font-weight-bold mr-2">Tahun</label>
					<select class="form-control form-control-sm" name="tahun" id="tahun">
						<option value="">-- Pilih Tahun --</option>
						<?php $tahun = date('Y');
						for ($i = 2020; $i < $tahun + 5; $i++) { ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
				</div>

				<?php
				if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
					$bulan = $_GET['bulan'];
					$tahun = $_GET['tahun'];
					$bulantahun = $bulan . $tahun;
				} else {
					$bulan = date('m');
					$tahun = date('Y');
					$bulantahun = $bulan . $tahun;
				}
				?>

				<button type="submit" class="btn btn-sm btn-primary mb-2 ml-auto shadow-sm"><i class="fas fa-eye mr-1"></i> Tampilkan Data</button>

				<?php if (count($gaji) > 0) { ?>
					<a href="<?php echo base_url('admin/data_penggajian/cetak_gaji?bulan=' . $bulan), '&tahun=' . $tahun ?>" class="btn btn-sm btn-success mb-2 ml-3 shadow-sm" target="_blank"><i class="fas fa-print mr-1"></i> Cetak Daftar Gaji</a>
				<?php } else { ?>
					<button type="button" class="btn btn-sm btn-success mb-2 ml-3 shadow-sm" data-toggle="modal" data-target="#exampleModal">
						<i class="fas fa-print mr-1"></i> Cetak Daftar Gaji</button>
				<?php } ?>

			</form>
		</div>
	</div>
</div>

<?php
if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$bulantahun = $bulan . $tahun;
} else {
	$bulan = date('m');
	$tahun = date('Y');
	$bulantahun = $bulan . $tahun;
}
?>

<div class="alert alert-info">
	Menampilkan Data Gaji Pegawai Bulan: <span class="font-weight-bold"><?php echo $bulan ?></span> Tahun: <span class="font-weight-bold"><?php echo $tahun ?></span>
</div>

<?php

$jml_data = count($gaji);
if ($jml_data > 0) { ?>

	<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead class="thead-dark">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">NIK</th>
								<th class="text-center">Nama Pegawai</th>
								<th class="text-center">Jenis Kelamin</th>
								<th class="text-center">Jabatan</th>
								<th class="text-center">GajI Pokok</th>
								<th class="text-center">Tj. Transport</th>
								<th class="text-center">Uang Makan</th>
								<th class="text-center">Tunjangan Lain</th>
								<th class="text-center">Potongan (Alpha)</th>
								<th class="text-center">Potongan Lain</th>
								<th class="text-center">Total Gaji</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								// Mengambil nilai potongan khusus Alpha
								$alpha = 0;
								foreach ($potongan as $p) {
									if (strtolower($p->potongan) == 'alpha') {
										$alpha = $p->jml_potongan;
									}
								}
								
								$no = 1;
								foreach ($gaji as $g) : 
									$potongan_alpha = $g->alpha * $alpha;
									// Komponen dinamis
									$tj_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['tunjangan']['total'] : 0;
									$pot_lain = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['potongan']['total'] : 0;
									$total_gaji = $g->gaji_pokok + $g->tj_transport + $g->uang_makan + $tj_lain - $potongan_alpha - $pot_lain;
							?>
									<tr>
										<td class="text-center align-middle"><?php echo $no++ ?></td>
										<td class="text-center align-middle"><?php echo $g->nik ?></td>
										<td class="text-left align-middle font-weight-bold"><?php echo $g->nama_pegawai ?></td>
										<td class="text-center align-middle"><?php echo $g->jenis_kelamin ?></td>
										<td class="text-center align-middle"><?php echo $g->nama_jabatan ?></td>
										<td class="text-right align-middle">Rp. <?php echo number_format($g->gaji_pokok, 0, ',', '.') ?></td>
										<td class="text-right align-middle">Rp. <?php echo number_format($g->tj_transport, 0, ',', '.') ?></td>
										<td class="text-right align-middle">Rp. <?php echo number_format($g->uang_makan, 0, ',', '.') ?></td>
										<td class="text-right align-middle">
											<?php if ($tj_lain > 0) : ?>
												<span class="text-success">+Rp. <?php echo number_format($tj_lain, 0, ',', '.') ?></span>
											<?php else : ?>
												<span class="text-muted">Rp. 0</span>
											<?php endif; ?>
										</td>
										<td class="text-right align-middle">
											<?php if ($potongan_alpha > 0) : ?>
												<span class="text-danger">-Rp. <?php echo number_format($potongan_alpha, 0, ',', '.') ?></span>
											<?php else : ?>
												<span class="text-muted">Rp. 0</span>
											<?php endif; ?>
										</td>
										<td class="text-right align-middle">
											<?php if ($pot_lain > 0) : ?>
												<span class="text-danger">-Rp. <?php echo number_format($pot_lain, 0, ',', '.') ?></span>
											<?php else : ?>
												<span class="text-muted">Rp. 0</span>
											<?php endif; ?>
										</td>
										<td class="text-right align-middle font-weight-bold text-primary">Rp. <?php echo number_format($total_gaji, 0, ',', '.') ?></td>
									</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } else { ?>
	<span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data absensi kosong, silakan input data kehadiran pada bulan dan tahun yang anda pilih</span>
<?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Data gaji masih kosong, silahkan input absensi terlebih dahulu pada bulan dan tahun yang Anda pilih.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>