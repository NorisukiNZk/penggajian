<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
		<a href="<?php echo base_url('admin/komponen_gaji/tambah') ?>" class="btn btn-primary">
			<i class="fas fa-plus"></i> Tambah Komponen Baru
		</a>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Komponen Tunjangan & Potongan</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="5%">No</th>
							<th class="text-center">Nama Komponen</th>
							<th class="text-center" width="12%">Tipe</th>
							<th class="text-center" width="15%">Nominal</th>
							<th class="text-center" width="10%">Perhitungan</th>
							<th class="text-center" width="10%">Status</th>
							<th class="text-center" width="20%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($komponen as $k) : ?>
						<tr>
							<td class="text-center"><?php echo $no++ ?></td>
							<td><?php echo $k->nama_komponen ?></td>
							<td class="text-center">
								<?php if ($k->tipe == 'tunjangan') : ?>
									<span class="badge badge-success"><i class="fas fa-plus-circle"></i> Tunjangan</span>
								<?php else : ?>
									<span class="badge badge-danger"><i class="fas fa-minus-circle"></i> Potongan</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if ($k->is_persentase == 1) : ?>
									<?php echo $k->nominal ?>% dari Gaji Pokok
								<?php else : ?>
									Rp. <?php echo number_format($k->nominal, 0, ',', '.') ?>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if ($k->is_persentase == 1) : ?>
									<span class="badge badge-info">Persentase</span>
								<?php else : ?>
									<span class="badge badge-secondary">Nominal</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/komponen_gaji/toggle/' . $k->id_komponen) ?>" 
								   class="btn btn-sm <?php echo ($k->is_aktif == 1) ? 'btn-success' : 'btn-secondary' ?>"
								   title="Klik untuk <?php echo ($k->is_aktif == 1) ? 'nonaktifkan' : 'aktifkan' ?>">
									<?php echo ($k->is_aktif == 1) ? '<i class="fas fa-check"></i> Aktif' : '<i class="fas fa-times"></i> Nonaktif' ?>
								</a>
							</td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/komponen_gaji/edit/' . $k->id_komponen) ?>" class="btn btn-sm btn-warning" title="Edit">
									<i class="fas fa-edit"></i> Edit
								</a>
								<a href="<?php echo base_url('admin/komponen_gaji/kelola_pegawai/' . $k->id_komponen) ?>" class="btn btn-sm btn-info" title="Kelola per Pegawai">
									<i class="fas fa-users"></i> Pegawai
								</a>
								<a href="<?php echo base_url('admin/komponen_gaji/hapus/' . $k->id_komponen) ?>" class="btn btn-sm btn-danger" title="Hapus"
								   onclick="return confirm('Apakah Anda yakin ingin menghapus komponen ini? Semua data terkait akan ikut terhapus.')">
									<i class="fas fa-trash"></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Info Card -->
	<div class="row">
		<div class="col-md-6">
			<div class="card border-left-success shadow mb-4">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Tunjangan Aktif</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
						<?php 
						$total_tunjangan = 0;
						foreach ($komponen as $k) {
							if ($k->tipe == 'tunjangan' && $k->is_aktif == 1) $total_tunjangan++;
						}
						echo $total_tunjangan;
						?> komponen
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card border-left-danger shadow mb-4">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Potongan Aktif</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">
						<?php 
						$total_potongan = 0;
						foreach ($komponen as $k) {
							if ($k->tipe == 'potongan' && $k->is_aktif == 1) $total_potongan++;
						}
						echo $total_potongan;
						?> komponen
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
