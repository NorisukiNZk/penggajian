<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Edit Komponen Gaji</h6>
		</div>
		<div class="card-body">
			<form method="POST" action="<?php echo base_url('admin/komponen_gaji/edit_aksi') ?>">
				<input type="hidden" name="id_komponen" value="<?php echo $komponen->id_komponen ?>">

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Komponen <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="nama_komponen" value="<?php echo set_value('nama_komponen', $komponen->nama_komponen) ?>">
						<?php echo form_error('nama_komponen', '<small class="text-danger">', '</small>') ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Tipe <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<select class="form-control" name="tipe">
							<option value="">-- Pilih Tipe --</option>
							<option value="tunjangan" <?php echo ($komponen->tipe == 'tunjangan') ? 'selected' : '' ?>>Tunjangan (+)</option>
							<option value="potongan" <?php echo ($komponen->tipe == 'potongan') ? 'selected' : '' ?>>Potongan (-)</option>
						</select>
						<?php echo form_error('tipe', '<small class="text-danger">', '</small>') ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nominal <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<div class="input-group">
							<div class="input-group-prepend" id="nominal-prefix">
								<span class="input-group-text"><?php echo ($komponen->is_persentase == 1) ? '%' : 'Rp' ?></span>
							</div>
							<input type="number" class="form-control" name="nominal" value="<?php echo set_value('nominal', $komponen->nominal) ?>" min="0">
						</div>
						<?php echo form_error('nominal', '<small class="text-danger">', '</small>') ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Jenis Perhitungan</label>
					<div class="col-sm-9">
						<div class="custom-control custom-switch mt-2">
							<input type="checkbox" class="custom-control-input" id="is_persentase" name="is_persentase" value="1"
								<?php echo ($komponen->is_persentase == 1) ? 'checked' : '' ?>>
							<label class="custom-control-label" for="is_persentase">Hitung sebagai persentase dari Gaji Pokok</label>
						</div>
						<small class="text-muted">Jika diaktifkan, nominal di atas akan dihitung sebagai persentase (%). Contoh: 10 = 10% dari gaji pokok.</small>
					</div>
				</div>

				<hr>
				<div class="form-group row">
					<div class="col-sm-9 offset-sm-3">
						<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
						<a href="<?php echo base_url('admin/komponen_gaji') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
					</div>
				</div>
			
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
		</div>
	</div>
</div>

<script>
document.getElementById('is_persentase').addEventListener('change', function() {
	var prefix = document.querySelector('#nominal-prefix .input-group-text');
	if (this.checked) {
		prefix.textContent = '%';
	} else {
		prefix.textContent = 'Rp';
	}
});
</script>
<!-- /.container-fluid -->
