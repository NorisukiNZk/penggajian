<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title?></h1>
  </div>

	<div class="card shadow mb-5" style="max-width: 70%">
		<div class="card-header bg-primary text-white">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus"></i> Form Tambah Pegawai</h6>
		</div>
		<div class="card-body">
			<form method="POST" action="<?php echo base_url('admin/data_pegawai/tambah_data_aksi')?>" enctype="multipart/form-data">
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">NIK</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-id-card"></i></span>
								</div>
								<input type="number" name="nik" class="form-control" placeholder="Masukkan NIK">
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
								<input type="text" name="nama_pegawai" class="form-control" placeholder="Masukkan Nama Lengkap">
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
								<input type="text" name="username" class="form-control" placeholder="Username untuk login">
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
								<input type="password" name="password" class="form-control" placeholder="Masukkan Password">
							</div>
							<?php echo form_error('password', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Jenis Kelamin</label>
							<select name="jenis_kelamin" class="form-control">
								<option value="">--Pilih Jenis Kelamin--</option>
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
								<option value="">--Pilih Jabatan--</option>
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
							<input type="date" name="tanggal_masuk" class="form-control">
							<?php echo form_error('tanggal_masuk', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Status Pekerjaan</label>
							<select name="status" class="form-control">
								<option value="">--Pilih Status--</option>
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
								<option value="">--Pilih Hak Akses--</option>
								<option value="1">Admin</option>
								<option value="2">Pegawai</option>
							</select>
							<?php echo form_error('hak_akses', '<div class="text-small text-danger mt-1"> </div>')?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="font-weight-bold text-dark">Photo Profil <small class="text-muted">(Max: 2MB)</small></label>
							<input type="file" name="photo" class="form-control-file">
						</div>
					</div>
				</div>

				<hr>
				<div class="d-flex justify-content-between">
					<a href="<?php echo base_url('admin/data_pegawai')?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
					<div>
						<button type="reset" class="btn btn-warning"><i class="fas fa-undo"></i> Reset</button>
						<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
					</div>
				</div>

			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
			</form>
		</div>
	</div>

</div>
<!-- /.container-fluid -->