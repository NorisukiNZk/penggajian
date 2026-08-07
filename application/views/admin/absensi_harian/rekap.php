<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Filter Bulan & Tahun -->
	<div class="card mb-3">
		<div class="card-header bg-info text-white">
			<i class="fas fa-filter"></i> Filter Periode
		</div>
		<div class="card-body">
			<form class="form-inline" method="GET" action="<?php echo base_url('admin/absensi_harian/rekap') ?>">
				<div class="form-group mb-2">
					<label>Bulan</label>
					<select class="form-control ml-3" name="bulan">
						<?php
						$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
						foreach ($nama_bulan as $key => $val) : ?>
							<option value="<?php echo $key ?>" <?php echo ($bulan == $key) ? 'selected' : '' ?>><?php echo $val ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group mb-2 ml-3">
					<label>Tahun</label>
					<select class="form-control ml-3" name="tahun">
						<?php $thn = date('Y');
						for ($i = 2020; $i < $thn + 5; $i++) { ?>
							<option value="<?php echo $i ?>" <?php echo ($tahun == $i) ? 'selected' : '' ?>><?php echo $i ?></option>
						<?php } ?>
					</select>
				</div>
				<button type="submit" class="btn btn-info mb-2 ml-3"><i class="fas fa-search"></i> Tampilkan</button>
			
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
		</div>
	</div>

	<!-- Info Setting -->
	<div class="alert alert-warning">
		<i class="fas fa-info-circle"></i>
		<strong>Aturan:</strong> Terlambat <?php echo $setting->maks_terlambat_jadi_alpha ?>x dalam 1 bulan = dianggap 1 hari Alpha (otomatis terhitung di kolom "Alpha dari Terlambat")
	</div>

	<!-- Tabel Rekap -->
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between align-items-center">
			<h6 class="m-0 font-weight-bold text-primary">Rekap Bulan <?php echo $nama_bulan[$bulan] ?> <?php echo $tahun ?></h6>
			<form method="POST" action="<?php echo base_url('admin/absensi_harian/sinkron_gaji') ?>" class="d-inline">
				<input type="hidden" name="bulan" value="<?php echo $bulan ?>">
				<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
				<button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Sinkronkan data absensi bulan ini ke Data Kehadiran untuk perhitungan gaji?')">
					<i class="fas fa-sync"></i> Sinkron ke Gaji
				</button>
			
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="4%">No</th>
							<th class="text-center">NIK</th>
							<th class="text-center">Nama Pegawai</th>
							<th class="text-center">Jabatan</th>
							<th class="text-center" width="7%">Hadir</th>
							<th class="text-center" width="7%">Terlambat</th>
							<th class="text-center" width="7%">Sakit</th>
							<th class="text-center" width="7%">Izin</th>
							<th class="text-center" width="7%">Alpha</th>
							<th class="text-center" width="7%">Alpha (Terlambat)</th>
							<th class="text-center" width="7%">Total Alpha</th>
							<th class="text-center" width="8%">Detail</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($rekap as $r) : ?>
						<tr>
							<td class="text-center"><?php echo $no++ ?></td>
							<td class="text-center"><?php echo $r['nik'] ?></td>
							<td><?php echo $r['nama_pegawai'] ?></td>
							<td class="text-center"><?php echo $r['jabatan'] ?></td>
							<td class="text-center"><span class="badge badge-success"><?php echo $r['hadir'] ?></span></td>
							<td class="text-center"><span class="badge badge-warning"><?php echo $r['terlambat'] ?></span></td>
							<td class="text-center"><span class="badge badge-info"><?php echo $r['sakit'] ?></span></td>
							<td class="text-center"><span class="badge badge-primary"><?php echo $r['izin'] ?></span></td>
							<td class="text-center"><span class="badge badge-danger"><?php echo $r['alpha'] ?></span></td>
							<td class="text-center"><span class="badge badge-dark"><?php echo $r['alpha_dari_terlambat'] ?></span></td>
							<td class="text-center"><span class="badge badge-danger font-weight-bold" style="font-size: 14px;"><?php echo $r['total_alpha'] ?></span></td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/absensi_harian/detail/' . $r['nik'] . '?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-sm btn-primary">
									<i class="fas fa-eye"></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
