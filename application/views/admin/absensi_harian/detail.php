<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Info Pegawai -->
	<?php if ($pegawai) : ?>
	<div class="card mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<strong>Nama:</strong> <?php echo $pegawai->nama_pegawai ?> |
					<strong>NIK:</strong> <?php echo $pegawai->nik ?> |
					<strong>Jabatan:</strong> <?php echo $pegawai->jabatan ?>
				</div>
				<div class="col-md-6 text-right">
					<a href="<?php echo base_url('admin/absensi_harian/rekap?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-sm btn-secondary">
						<i class="fas fa-arrow-left"></i> Kembali ke Rekap
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- Filter Bulan & Tahun -->
	<div class="card mb-3">
		<div class="card-body">
			<form class="form-inline" method="GET" action="<?php echo base_url('admin/absensi_harian/detail/' . $nik) ?>">
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

	<!-- Tombol Tambah Manual -->
	<button class="btn btn-warning mb-3" data-toggle="modal" data-target="#modalTambahManual">
		<i class="fas fa-plus"></i> Tambah Absensi Manual
	</button>

	<!-- Tabel Detail Harian -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				Detail Absensi Harian — <?php echo isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : '' ?> <?php echo $tahun ?>
			</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="4%">No</th>
							<th class="text-center">Tanggal</th>
							<th class="text-center">Hari</th>
							<th class="text-center" width="12%">Jam Masuk</th>
							<th class="text-center" width="12%">Jam Pulang</th>
							<th class="text-center" width="14%">Status</th>
							<th class="text-center">Keterangan</th>
							<th class="text-center" width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($detail) > 0) : ?>
							<?php $no = 1; foreach ($detail as $d) : ?>
								<?php
								$hari_list = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
								$nama_hari = $hari_list[date('l', strtotime($d->tanggal))];
								?>
								<tr>
									<td class="text-center"><?php echo $no++ ?></td>
									<td class="text-center"><?php echo date('d-m-Y', strtotime($d->tanggal)) ?></td>
									<td class="text-center"><?php echo $nama_hari ?></td>
									<td class="text-center">
										<?php echo $d->jam_masuk ? date('H:i:s', strtotime($d->jam_masuk)) : '-' ?>
									</td>
									<td class="text-center">
										<?php echo $d->jam_pulang ? date('H:i:s', strtotime($d->jam_pulang)) : '-' ?>
									</td>
									<td class="text-center">
										<?php
										switch ($d->status) {
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
									<td class="text-center"><?php echo $d->keterangan ? $d->keterangan : '-' ?></td>
									<td class="text-center">
										<!-- Tombol ubah status -->
										<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalUbahStatus<?php echo $d->id ?>" title="Ubah Status">
											<i class="fas fa-edit"></i>
										</button>
									</td>
								</tr>

								<!-- Modal Ubah Status -->
								<div class="modal fade" id="modalUbahStatus<?php echo $d->id ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-info text-white">
												<h5 class="modal-title">Ubah Status Absensi</h5>
												<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
											</div>
											<form method="POST" action="<?php echo base_url('admin/absensi_harian/update_status') ?>">
												<div class="modal-body">
													<input type="hidden" name="id" value="<?php echo $d->id ?>">
													<input type="hidden" name="nik" value="<?php echo $nik ?>">
													<input type="hidden" name="bulan" value="<?php echo $bulan ?>">
													<input type="hidden" name="tahun" value="<?php echo $tahun ?>">

													<p><strong>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($d->tanggal)) ?></p>

													<div class="form-group">
														<label>Status</label>
														<select class="form-control" name="status">
															<option value="tepat_waktu" <?php echo ($d->status == 'tepat_waktu') ? 'selected' : '' ?>>Tepat Waktu</option>
															<option value="terlambat" <?php echo ($d->status == 'terlambat') ? 'selected' : '' ?>>Terlambat</option>
															<option value="sakit" <?php echo ($d->status == 'sakit') ? 'selected' : '' ?>>Sakit</option>
															<option value="izin" <?php echo ($d->status == 'izin') ? 'selected' : '' ?>>Izin</option>
															<option value="alpha" <?php echo ($d->status == 'alpha') ? 'selected' : '' ?>>Alpha</option>
														</select>
													</div>

													<div class="form-group">
														<label>Keterangan</label>
														<textarea class="form-control" name="keterangan" rows="2"><?php echo $d->keterangan ?></textarea>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
												</div>
											
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="8" class="text-center text-muted">Belum ada data absensi untuk periode ini.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tambah Absensi Manual -->
<div class="modal fade" id="modalTambahManual" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-warning text-dark">
				<h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Absensi Manual</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<form method="POST" action="<?php echo base_url('admin/absensi_harian/tambah_manual') ?>">
				<div class="modal-body">
					<input type="hidden" name="nik" value="<?php echo $nik ?>">
					<input type="hidden" name="bulan" value="<?php echo $bulan ?>">
					<input type="hidden" name="tahun" value="<?php echo $tahun ?>">

					<div class="form-group">
						<label>Tanggal</label>
						<input type="date" class="form-control" name="tanggal" required>
					</div>

					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option value="sakit">Sakit</option>
							<option value="izin">Izin</option>
							<option value="alpha">Alpha</option>
							<option value="tepat_waktu">Hadir (Tepat Waktu)</option>
						</select>
					</div>

					<div class="form-group">
						<label>Keterangan</label>
						<textarea class="form-control" name="keterangan" rows="2" placeholder="Opsional"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
