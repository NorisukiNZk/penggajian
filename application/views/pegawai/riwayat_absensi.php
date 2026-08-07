<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<!-- Filter Bulan & Tahun -->
	<div class="card mb-3">
		<div class="card-header bg-info text-white">
			<i class="fas fa-filter"></i> Filter Periode
		</div>
		<div class="card-body">
			<form class="form-inline" method="GET" action="<?php echo base_url('pegawai/absensi/riwayat') ?>">
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
			</form>
		</div>
	</div>

	<!-- Tabel Riwayat Absensi -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				<?php echo $nama_bulan[$bulan] ?> <?php echo $tahun ?>
			</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="5%">No</th>
							<th class="text-center">Tanggal</th>
							<th class="text-center">Hari</th>
							<th class="text-center">Jam Masuk</th>
							<th class="text-center">Jam Pulang</th>
							<th class="text-center">Status</th>
							<th class="text-center">Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($absensi) > 0) : ?>
							<?php $no = 1; foreach ($absensi as $a) : ?>
								<?php
								$hari_list = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
								$nama_hari = $hari_list[date('l', strtotime($a->tanggal))];
								?>
								<tr>
									<td class="text-center"><?php echo $no++ ?></td>
									<td class="text-center"><?php echo date('d-m-Y', strtotime($a->tanggal)) ?></td>
									<td class="text-center"><?php echo $nama_hari ?></td>
									<td class="text-center">
										<?php echo $a->jam_masuk ? date('H:i:s', strtotime($a->jam_masuk)) : '-' ?>
									</td>
									<td class="text-center">
										<?php echo $a->jam_pulang ? date('H:i:s', strtotime($a->jam_pulang)) : '-' ?>
									</td>
									<td class="text-center">
										<?php
										switch ($a->status) {
											case 'tepat_waktu':
												echo '<span class="badge badge-success">✅ Tepat Waktu</span>';
												break;
											case 'terlambat':
												echo '<span class="badge badge-warning">⚠️ Terlambat</span>';
												break;
											case 'sakit':
												echo '<span class="badge badge-info">🏥 Sakit</span>';
												break;
											case 'izin':
												echo '<span class="badge badge-primary">📋 Izin</span>';
												break;
											case 'alpha':
												echo '<span class="badge badge-danger">❌ Alpha</span>';
												break;
										}
										?>
									</td>
									<td class="text-center"><?php echo $a->keterangan ? $a->keterangan : '-' ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="7" class="text-center text-muted">Belum ada data absensi untuk periode ini.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
