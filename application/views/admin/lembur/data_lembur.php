<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<div class="card shadow mb-4">
		<div class="card-header py-3 bg-primary text-white">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-tasks"></i> Menunggu Persetujuan & Riwayat</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-light">
						<tr>
							<th class="text-center">No</th>
							<th>Nama Pegawai</th>
							<th>Tanggal</th>
							<th>Jam Lembur</th>
							<th class="text-center">Durasi</th>
							<th>Keterangan</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aksi (Approval)</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($lembur as $l) : ?>
						<tr>
							<td class="text-center"><?php echo $no++ ?></td>
							<td>
								<strong><?php echo $l->nama_pegawai ?></strong><br>
								<small class="text-muted"><?php echo $l->jabatan ?></small>
							</td>
							<td><?php echo date('d M Y', strtotime($l->tanggal_lembur)) ?></td>
							<td>
								<i class="fas fa-clock text-info"></i> <?php echo date('H:i', strtotime($l->jam_mulai)) ?> - <?php echo date('H:i', strtotime($l->jam_selesai)) ?>
							</td>
							<td class="text-center font-weight-bold text-primary"><?php echo $l->durasi_jam ?> Jam</td>
							<td><?php echo $l->keterangan ?></td>
							<td class="text-center">
								<?php if($l->status == 'Pending') : ?>
									<span class="badge badge-warning p-2"><i class="fas fa-hourglass-half"></i> Pending</span>
								<?php elseif($l->status == 'Disetujui') : ?>
									<span class="badge badge-success p-2"><i class="fas fa-check-circle"></i> Disetujui</span>
								<?php elseif($l->status == 'Ditolak') : ?>
									<span class="badge badge-danger p-2"><i class="fas fa-times-circle"></i> Ditolak</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if($l->status == 'Pending') : ?>
									<!-- Form Setujui -->
									<form action="<?php echo base_url('admin/data_lembur/aksi_approval') ?>" method="POST" class="d-inline">
										<input type="hidden" name="id_lembur" value="<?php echo $l->id_lembur ?>">
										<input type="hidden" name="status" value="Disetujui">
										
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
<button type="submit" class="btn btn-sm btn-success mb-1" onclick="return confirm('Setujui pengajuan lembur ini?')">
											<i class="fas fa-check"></i> Setujui
										</button>
									</form>
									<!-- Form Tolak -->
									<form action="<?php echo base_url('admin/data_lembur/aksi_approval') ?>" method="POST" class="d-inline">
										<input type="hidden" name="id_lembur" value="<?php echo $l->id_lembur ?>">
										<input type="hidden" name="status" value="Ditolak">
										
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
<button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Tolak pengajuan lembur ini?')">
											<i class="fas fa-times"></i> Tolak
										</button>
									</form>
								<?php else : ?>
									<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-lock"></i> Selesai</button>
								<?php endif; ?>
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
