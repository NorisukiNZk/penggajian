<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title ?></h1>
      <p class="text-muted small mb-0">Sesuaikan nominal gaji pokok, tunjangan transport, dan uang makan untuk jabatan ini.</p>
    </div>
    <div class="mt-3 mt-md-0">
      <a href="<?php echo base_url('admin/data_jabatan') ?>" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
      </a>
    </div>
  </div>

	<div class="card shadow mb-5" style="max-width: 60%">
		<div class="card-header bg-primary text-white">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-edit"></i> Form Edit Jabatan</h6>
		</div>
		<div class="card-body">
			<?php foreach ($jabatan as $j): ?>
			<form method="POST" action="<?php echo base_url('admin/data_jabatan/update_data_aksi')?>">
				
				<div class="form-group">
					<label class="font-weight-bold text-dark">Nama Jabatan</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-briefcase"></i></span>
						</div>
						<input type="hidden" name="id_jabatan" class="form-control" value="<?php echo $j->id_jabatan?>">
						<input type="text" name="nama_jabatan" class="form-control" value="<?php echo $j->nama_jabatan?>">
					</div>
					<?php echo form_error('nama_jabatan', '<div class="text-small text-danger mt-1"> </div>')?>
				</div>

				<div class="form-group">
					<label class="font-weight-bold text-dark">Gaji Pokok</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>Rp</strong></span>
						</div>
						<input type="number" name="gaji_pokok" class="form-control" value="<?php echo $j->gaji_pokok?>">
					</div>
					<?php echo form_error('gaji_pokok', '<div class="text-small text-danger mt-1"> </div>')?>
				</div>

				<div class="form-group">
					<label class="font-weight-bold text-dark">Tunjangan Transport</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>Rp</strong></span>
						</div>
						<input type="number" name="tj_transport" class="form-control" value="<?php echo $j->tj_transport?>">
					</div>
					<?php echo form_error('tj_transport', '<div class="text-small text-danger mt-1"> </div>')?>
				</div>

				<div class="form-group">
					<label class="font-weight-bold text-dark">Uang Makan</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><strong>Rp</strong></span>
						</div>
						<input type="number" name="uang_makan" class="form-control" value="<?php echo $j->uang_makan?>">
					</div>
					<?php echo form_error('uang_makan', '<div class="text-small text-danger mt-1"> </div>')?>
				</div>

				<hr>
				<div class="d-flex justify-content-between">
					<a href="<?php echo base_url('admin/data_jabatan')?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Data</button>
				</div>
			
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
			</form>
			<?php endforeach; ?>
		</div>
	</div>

</div>
<!-- /.container-fluid -->