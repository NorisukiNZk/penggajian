<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Info Komponen -->
	<div class="card shadow mb-4">
		<div class="card-header py-3 bg-primary text-white">
			<h6 class="m-0 font-weight-bold">Detail Komponen: <?php echo $komponen->nama_komponen ?></h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<strong>Tipe:</strong> 
					<?php if ($komponen->tipe == 'tunjangan') : ?>
						<span class="badge badge-success">Tunjangan (+)</span>
					<?php else : ?>
						<span class="badge badge-danger">Potongan (-)</span>
					<?php endif; ?>
				</div>
				<div class="col-md-4">
					<strong>Nominal Default:</strong> 
					<?php if ($komponen->is_persentase == 1) : ?>
						<?php echo $komponen->nominal ?>% dari Gaji Pokok
					<?php else : ?>
						Rp. <?php echo number_format($komponen->nominal, 0, ',', '.') ?>
					<?php endif; ?>
				</div>
				<div class="col-md-4">
					<strong>Status:</strong> 
					<?php echo ($komponen->is_aktif == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Nonaktif</span>' ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Filter Bulan & Tahun -->
	<div class="card mb-3">
		<div class="card-header bg-info text-white">
			Filter Periode
		</div>
		<div class="card-body">
			<form class="form-inline" method="GET" action="<?php echo base_url('admin/komponen_gaji/kelola_pegawai/' . $komponen->id_komponen) ?>">
				<div class="form-group mb-2">
					<label>Bulan</label>
					<select class="form-control ml-3" name="bulan">
						<option value="01" <?php echo ($bulan == '01') ? 'selected' : '' ?>>Januari</option>
						<option value="02" <?php echo ($bulan == '02') ? 'selected' : '' ?>>Februari</option>
						<option value="03" <?php echo ($bulan == '03') ? 'selected' : '' ?>>Maret</option>
						<option value="04" <?php echo ($bulan == '04') ? 'selected' : '' ?>>April</option>
						<option value="05" <?php echo ($bulan == '05') ? 'selected' : '' ?>>Mei</option>
						<option value="06" <?php echo ($bulan == '06') ? 'selected' : '' ?>>Juni</option>
						<option value="07" <?php echo ($bulan == '07') ? 'selected' : '' ?>>Juli</option>
						<option value="08" <?php echo ($bulan == '08') ? 'selected' : '' ?>>Agustus</option>
						<option value="09" <?php echo ($bulan == '09') ? 'selected' : '' ?>>September</option>
						<option value="10" <?php echo ($bulan == '10') ? 'selected' : '' ?>>Oktober</option>
						<option value="11" <?php echo ($bulan == '11') ? 'selected' : '' ?>>November</option>
						<option value="12" <?php echo ($bulan == '12') ? 'selected' : '' ?>>Desember</option>
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

	<!-- Tabel Pegawai & Override -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				Override Nominal per Pegawai — Bulan <?php echo $bulan ?>/<?php echo $tahun ?>
			</h6>
		</div>
		<div class="card-body">
			<div class="alert alert-info">
				<i class="fas fa-info-circle"></i> 
				Kosongkan nominal untuk menggunakan <strong>nilai default</strong> (<?php echo ($komponen->is_persentase == 1) ? $komponen->nominal . '% dari Gaji Pokok' : 'Rp. ' . number_format($komponen->nominal, 0, ',', '.') ?>). 
				Isi nominal hanya jika pegawai tersebut mendapat nilai <strong>berbeda</strong> dari default.
			</div>

			<form method="POST" action="<?php echo base_url('admin/komponen_gaji/simpan_komponen_pegawai') ?>">
				<input type="hidden" name="id_komponen" value="<?php echo $komponen->id_komponen ?>">
				<input type="hidden" name="bulan" value="<?php echo $bulan ?>">
				<input type="hidden" name="tahun" value="<?php echo $tahun ?>">

				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" width="5%">No</th>
								<th class="text-center">NIK</th>
								<th class="text-center">Nama Pegawai</th>
								<th class="text-center">Jabatan</th>
								<th class="text-center" width="20%">Nominal Override (Rp)</th>
								<th class="text-center" width="10%">Status</th>
								<th class="text-center" width="8%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; foreach ($pegawai_komponen as $pk) : ?>
							<tr>
								<td class="text-center"><?php echo $no++ ?></td>
								<td class="text-center"><?php echo $pk->nik ?></td>
								<td><?php echo $pk->nama_pegawai ?></td>
								<td class="text-center"><?php echo $pk->jabatan ?></td>
								<td>
									<input type="hidden" name="nik[]" value="<?php echo $pk->nik ?>">
									<input type="number" class="form-control form-control-sm" name="nominal_override[]" 
										   value="<?php echo ($pk->nominal_override) ? $pk->nominal_override : '' ?>" 
										   placeholder="Kosongkan = default" min="0">
								</td>
								<td class="text-center">
									<?php if ($pk->nominal_override) : ?>
										<span class="badge badge-warning">Override: Rp. <?php echo number_format($pk->nominal_override, 0, ',', '.') ?></span>
									<?php else : ?>
										<span class="badge badge-secondary">Default</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<?php if ($pk->id_override) : ?>
										<a href="<?php echo base_url('admin/komponen_gaji/hapus_komponen_pegawai/' . $pk->id_override . '/' . $komponen->id_komponen) ?>" 
										   class="btn btn-sm btn-danger" title="Hapus Override"
										   onclick="return confirm('Hapus override untuk pegawai ini?')">
											<i class="fas fa-times"></i>
										</a>
									<?php else : ?>
										<span class="text-muted">-</span>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<hr>
				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Override</button>
				<a href="<?php echo base_url('admin/komponen_gaji') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
			
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
