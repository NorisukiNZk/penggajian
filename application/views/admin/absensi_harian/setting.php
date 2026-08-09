<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<div class="row">
		<div class="col-lg-8">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-primary text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-cog"></i> Aturan Jam Kerja</h6>
				</div>
				<div class="card-body">
					<form method="POST" action="<?php echo base_url('admin/absensi_harian/update_setting') ?>">

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Gerbang Absen Masuk Buka</label>
							<div class="col-sm-8">
								<input type="time" class="form-control" name="mulai_absen_masuk" value="<?php echo $setting->mulai_absen_masuk ?>">
								<small class="text-muted">Jam paling awal pegawai bisa klik Absen Masuk (default: 06:00)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Jam Masuk Resmi</label>
							<div class="col-sm-8">
								<input type="time" class="form-control" name="jam_masuk" value="<?php echo $setting->jam_masuk ?>">
								<small class="text-muted">Jam pegawai seharusnya sudah hadir (default: 08:00)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Toleransi Keterlambatan</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input type="number" class="form-control" name="toleransi_menit" value="<?php echo $setting->toleransi_menit ?>" min="0" max="60">
									<div class="input-group-append">
										<span class="input-group-text">menit</span>
									</div>
								</div>
								<small class="text-muted">Grace period setelah jam masuk resmi. Dalam rentang ini masih dianggap "Tepat Waktu" (default: 15 menit)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Gerbang Absen Pulang Buka</label>
							<div class="col-sm-8">
								<input type="time" class="form-control" name="mulai_absen_pulang" value="<?php echo $setting->mulai_absen_pulang ?>">
								<small class="text-muted">Jam paling awal pegawai bisa klik Absen Pulang (default: 15:00)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Jam Pulang Resmi</label>
							<div class="col-sm-8">
								<input type="time" class="form-control" name="jam_pulang" value="<?php echo $setting->jam_pulang ?>">
								<small class="text-muted">Jam seharusnya pegawai pulang (default: 17:00)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Batas Terlambat Berat</label>
							<div class="col-sm-8">
								<input type="time" class="form-control" name="batas_terlambat_berat" value="<?php echo $setting->batas_terlambat_berat ?>">
								<small class="text-muted">Jam maksimal absen masih diterima. Lewat jam ini = terlambat berat (default: 09:00)</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-4 col-form-label font-weight-bold">Terlambat → Alpha</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input type="number" class="form-control" name="maks_terlambat_jadi_alpha" value="<?php echo $setting->maks_terlambat_jadi_alpha ?>" min="1" max="10">
									<div class="input-group-append">
										<span class="input-group-text">kali terlambat = 1 Alpha</span>
									</div>
								</div>
								<small class="text-muted">Berapa kali terlambat dalam 1 bulan yang dianggap sebagai 1 hari Alpha (default: 3)</small>
							</div>
						</div>

						<hr>
						<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Setting</button>
						<a href="<?php echo base_url('admin/absensi_harian') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
					
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
				</div>
			</div>
		</div>

		<!-- Info Panel -->
		<div class="col-lg-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-info text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle"></i> Panduan</h6>
				</div>
				<div class="card-body">
					<h6 class="font-weight-bold">Alur Penentuan Status:</h6>
					<table class="table table-sm">
						<tr>
							<td><span class="badge badge-success">Tepat Waktu</span></td>
							<td>Absen sebelum jam masuk + toleransi</td>
						</tr>
						<tr>
							<td><span class="badge badge-warning">Terlambat</span></td>
							<td>Absen setelah toleransi</td>
						</tr>
						<tr>
							<td><span class="badge badge-danger">Alpha</span></td>
							<td>Tidak absen sama sekali</td>
						</tr>
					</table>

					<hr>
					<h6 class="font-weight-bold">Setting Saat Ini:</h6>
					<ul class="list-unstyled">
						<li>⏰ Masuk: <strong><?php echo date('H:i', strtotime($setting->jam_masuk)) ?></strong></li>
						<li>⏳ Toleransi: <strong><?php echo $setting->toleransi_menit ?> menit</strong></li>
						<li>✅ Batas tepat waktu: <strong><?php echo date('H:i', strtotime($setting->jam_masuk . ' +' . $setting->toleransi_menit . ' minutes')) ?></strong></li>
						<li>🏠 Pulang: <strong><?php echo date('H:i', strtotime($setting->jam_pulang)) ?></strong></li>
						<li>⚠️ <?php echo $setting->maks_terlambat_jadi_alpha ?>x terlambat = 1 Alpha</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
