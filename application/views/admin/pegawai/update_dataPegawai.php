<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

	<div class="card shadow mb-5" style="max-width: 70%">
		<div class="card-header bg-primary text-white">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-user-edit"></i> Form Edit Pegawai</h6>
		</div>
		<div class="card-body">

			<?php foreach ($pegawai as $p)  : ?>
			<form method="POST" action="<?php echo base_url('admin/data_pegawai/update_data_aksi')?>" enctype="multipart/form-data">
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">NIK</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-id-card"></i></span>
								</div>
								<input type="hidden" name="id_pegawai" class="form-control" value="<?php echo $p->id_pegawai?>">
								<input type="number" name="nik" class="form-control" value="<?php echo $p->nik?>">
							</div>
							<?php echo form_error('nik', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Nama Pegawai</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="nama_pegawai" class="form-control" value="<?php echo $p->nama_pegawai?>">
							</div>
							<?php echo form_error('nama_pegawai', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Username</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-at"></i></span>
								</div>
								<input type="text" name="username" class="form-control" value="<?php echo $p->username?>">
							</div>
							<?php echo form_error('username', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Password</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-lock"></i></span>
								</div>
								<input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
							</div>
							<small class="form-text text-muted">Isi hanya jika ingin mereset password pegawai ini.</small>
							<?php echo form_error('password', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control">
								<option value="<?php echo $p->jenis_kelamin ?>"><?php echo $p->jenis_kelamin ?></option>
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
							<?php echo form_error('jenis_kelamin', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Jabatan</label>
							<select name="jabatan" class="form-control">
								<option value="<?php echo $p->jabatan ?>"><?php echo $p->jabatan ?></option>
								<?php foreach($jabatan as $j) :?>
								<option value="<?php echo $j->nama_jabatan ?>"><?php echo $j->nama_jabatan ?></option>
								<?php endforeach; ?>
							</select>
							<?php echo form_error('jabatan', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Tanggal Masuk</label>
							<input type="date" name="tanggal_masuk" class="form-control" value="<?php echo $p->tanggal_masuk?>">
							<?php echo form_error('tanggal_masuk', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Status Pekerjaan</label>
							<select name="status" class="form-control">
								<option value="<?php echo $p->status ?>"><?php echo $p->status ?></option>
								<option value="Karyawan Tetap">Karyawan Tetap</option>
								<option value="Karyawan Tidak Tetap">Karyawan Tidak Tetap</option>
							</select>
							<?php echo form_error('status', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Hak Akses</label>
							<select name="hak_akses" class="form-control">
								<option value="<?php echo $p->hak_akses ?>">
									<?php if($p->hak_akses=='1') {
										echo "Admin";
									} else {
										echo "Pegawai";
									} ?>
								</option>
								<option value="1">Admin</option>
								<option value="2">Pegawai</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Photo Profil Baru <small class="text-muted">(Abaikan jika tidak diubah)</small></label>
							<input type="file" name="photo" class="form-control-file">
						</div>
					</div>
				</div>

				<hr>
				<div class="d-flex justify-content-between">
					<a href="<?php echo base_url('admin/data_pegawai')?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Data</button>
				</div>
			
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
			</form>
		<?php endforeach; ?>
		</div>
	</div>

</div>
<!-- /.container-fluid -->