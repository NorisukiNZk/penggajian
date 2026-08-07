<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
		<span class="badge badge-primary" style="font-size: 16px;"><i class="fas fa-calendar-day"></i> <?php echo $tanggal ?></span>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Ringkasan Hari Ini -->
	<?php
	$sudah_masuk = 0;
	$belum_masuk = 0;
	$sudah_pulang = 0;
	$terlambat = 0;
	foreach ($absensi as $a) {
		if ($a->jam_masuk) {
			$sudah_masuk++;
			if ($a->status == 'terlambat') $terlambat++;
			if ($a->jam_pulang) $sudah_pulang++;
		} else {
			$belum_masuk++;
		}
	}
	?>

	<div class="row">
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Absen Masuk</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sudah_masuk ?> orang</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-danger shadow h-100 py-2">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Absen</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $belum_masuk ?> orang</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $terlambat ?> orang</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sudah Pulang</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sudah_pulang ?> orang</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Info Jam Kerja -->
	<div class="alert alert-info">
		<i class="fas fa-info-circle"></i>
		<strong>Jam Kerja:</strong> <?php echo date('H:i', strtotime($setting->jam_masuk)) ?> - <?php echo date('H:i', strtotime($setting->jam_pulang)) ?> |
		<strong>Toleransi:</strong> <?php echo $setting->toleransi_menit ?> menit |
		<a href="<?php echo base_url('admin/absensi_harian/setting') ?>" class="text-primary"><i class="fas fa-cog"></i> Ubah Setting</a>
	</div>

	<!-- Tabel Monitoring -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Detail Kehadiran Hari Ini</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="5%">No</th>
							<th class="text-center">Nama Pegawai</th>
							<th class="text-center">Jabatan</th>
							<th class="text-center" width="12%">Jam Masuk</th>
							<th class="text-center" width="12%">Jam Pulang</th>
							<th class="text-center" width="14%">Status</th>
							<th class="text-center">Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($absensi as $a) : ?>
						<tr>
							<td class="text-center"><?php echo $no++ ?></td>
							<td><?php echo $a->nama_pegawai ?></td>
							<td class="text-center"><?php echo $a->jabatan ?></td>
							<td class="text-center">
								<?php if ($a->jam_masuk) : ?>
									<span class="font-weight-bold"><?php echo date('H:i:s', strtotime($a->jam_masuk)) ?></span>
								<?php else : ?>
									<span class="text-muted">-</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if ($a->jam_pulang) : ?>
									<span class="font-weight-bold"><?php echo date('H:i:s', strtotime($a->jam_pulang)) ?></span>
								<?php else : ?>
									<span class="text-muted">-</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if ($a->jam_masuk) : ?>
									<?php if ($a->status == 'tepat_waktu') : ?>
										<span class="badge badge-success">✅ Tepat Waktu</span>
									<?php elseif ($a->status == 'terlambat') : ?>
										<span class="badge badge-warning">⚠️ Terlambat</span>
									<?php elseif ($a->status == 'sakit') : ?>
										<span class="badge badge-info">🏥 Sakit</span>
									<?php elseif ($a->status == 'izin') : ?>
										<span class="badge badge-primary">📋 Izin</span>
									<?php endif; ?>
								<?php else : ?>
									<span class="badge badge-danger">❌ Belum Absen</span>
								<?php endif; ?>
							</td>
							<td class="text-center"><?php echo $a->keterangan ? $a->keterangan : '-' ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
