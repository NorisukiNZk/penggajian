<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<div class="row">
		<!-- Form Pengajuan -->
		<div class="col-lg-4">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-primary text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle"></i> Form Pengajuan Lembur</h6>
				</div>
				<div class="card-body">
					<form method="POST" action="<?php echo base_url('pegawai/lembur/tambah_aksi') ?>">
						<div class="form-group">
							<label>Tanggal Lembur</label>
							<input type="date" name="tanggal_lembur" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="form-group">
							<label>Jam Mulai (Estimasi)</label>
							<input type="time" name="jam_mulai" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Jam Selesai (Estimasi)</label>
							<input type="time" name="jam_selesai" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Keterangan Pekerjaan</label>
							<textarea name="keterangan" class="form-control" rows="3" required placeholder="Jelaskan apa yang dikerjakan saat lembur..."></textarea>
						</div>
						
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane"></i> Ajukan Lembur</button>
					</form>
				</div>
			</div>
		</div>

		<!-- Riwayat Pengajuan -->
		<div class="col-lg-8">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-success text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-history"></i> Riwayat Pengajuan Saya</h6>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
							<thead class="thead-light">
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Durasi (Jam)</th>
									<th>Keterangan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; foreach($lembur as $l) : ?>
								<tr>
									<td><?php echo $no++ ?></td>
									<td><?php echo date('d M Y', strtotime($l->tanggal_lembur)) ?></td>
									<td class="text-center font-weight-bold"><?php echo $l->durasi_jam ?> Jam</td>
									<td>
										<small>
											<i class="fas fa-clock text-info"></i> <?php echo date('H:i', strtotime($l->jam_mulai)) ?> - <?php echo date('H:i', strtotime($l->jam_selesai)) ?><br>
											<?php echo $l->keterangan ?>
										</small>
									</td>
									<td class="text-center">
										<?php if($l->status == 'Pending') : ?>
											<span class="badge badge-warning p-2"><i class="fas fa-hourglass-half"></i> Pending</span>
										<?php elseif($l->status == 'Disetujui') : ?>
											<span class="badge badge-success p-2"><i class="fas fa-check-circle"></i> Disetujui</span>
										<?php elseif($l->status == 'Ditolak') : ?>
											<span class="badge badge-danger p-2"><i class="fas fa-times-circle"></i> Ditolak</span>
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
	</div>

</div>
<!-- /.container-fluid -->
