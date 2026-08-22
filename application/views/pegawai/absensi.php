<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<div class="row">
		<!-- Jam Real-Time -->
		<div class="col-lg-5">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-primary text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-clock"></i> Jam Sekarang</h6>
				</div>
				<div class="card-body text-center">
					<div id="jam-realtime" style="font-size: 48px; font-weight: bold; color: #4e73df;"></div>
					<p class="text-muted mb-0" id="tanggal-realtime" style="font-size: 16px;"></p>
					<hr>
					<div class="row text-center">
						<div class="col-4">
							<small class="text-muted">Jam Masuk</small><br>
							<span class="font-weight-bold text-success"><?php echo date('H:i', strtotime($setting->jam_masuk)) ?></span>
						</div>
						<div class="col-4">
							<small class="text-muted">Toleransi</small><br>
							<span class="font-weight-bold text-warning"><?php echo $setting->toleransi_menit ?> menit</span>
						</div>
						<div class="col-4">
							<small class="text-muted">Jam Pulang</small><br>
							<span class="font-weight-bold text-info"><?php echo date('H:i', strtotime($setting->jam_pulang)) ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Status Absensi Hari Ini -->
		<div class="col-lg-7">
			<div class="card shadow mb-4">
				<div class="card-header py-3 bg-dark text-white">
					<h6 class="m-0 font-weight-bold"><i class="fas fa-user-check"></i> Status Absensi Hari Ini — <?php echo date('d F Y') ?></h6>
				</div>
				<div class="card-body">
					<?php if ($absensi_hari_ini) : ?>
						<!-- Sudah absen masuk -->
						<div class="row mb-3">
							<div class="col-6">
								<div class="card border-left-success">
									<div class="card-body py-3">
										<div class="text-xs font-weight-bold text-success text-uppercase">Absen Masuk</div>
										<div class="h4 mb-0 font-weight-bold"><?php echo date('H:i:s', strtotime($absensi_hari_ini->jam_masuk)) ?></div>
										<span class="badge badge-<?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? 'success' : 'warning' ?>">
											<?php echo ($absensi_hari_ini->status == 'tepat_waktu') ? '✅ Tepat Waktu' : '⚠️ Terlambat' ?>
										</span>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card border-left-info">
									<div class="card-body py-3">
										<div class="text-xs font-weight-bold text-info text-uppercase">Absen Pulang</div>
										<?php if ($absensi_hari_ini->jam_pulang) : ?>
											<div class="h4 mb-0 font-weight-bold"><?php echo date('H:i:s', strtotime($absensi_hari_ini->jam_pulang)) ?></div>
											<span class="badge badge-info">✅ Sudah Pulang</span>
										<?php else : ?>
											<div class="h4 mb-0 font-weight-bold text-muted">--:--:--</div>
											<span class="badge badge-secondary">Belum Absen Pulang</span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>

						<?php if ($absensi_hari_ini->keterangan) : ?>
							<div class="alert alert-info py-2 mb-3">
								<small><i class="fas fa-info-circle"></i> <?php echo $absensi_hari_ini->keterangan ?></small>
							</div>
						<?php endif; ?>

						<!-- Tombol Absen Pulang -->
						<?php 
						$jam_sekarang = date('H:i:s');
						if (!$absensi_hari_ini->jam_pulang) : ?>
							<?php if ($jam_sekarang >= $setting->mulai_absen_pulang) : ?>
								<a href="<?php echo base_url('pegawai/absensi/absen_pulang') ?>" class="btn btn-info btn-lg btn-block btn-konfirmasi" data-judul="Absen Pulang?" data-pesan="Apakah Anda yakin ingin melakukan Absen Pulang sekarang?" data-tipe="question" data-warna="#36b9cc" data-btn-teks="<i class='fas fa-sign-out-alt'></i> Ya, Pulang!">
									<i class="fas fa-sign-out-alt fa-2x"></i><br>
									<span style="font-size: 20px;">ABSEN PULANG</span>
								</a>
							<?php else : ?>
								<button class="btn btn-secondary btn-lg btn-block text-white" disabled style="cursor: not-allowed; opacity: 0.7;">
									<i class="fas fa-lock fa-2x mb-2"></i><br>
									<span style="font-size: 20px; font-weight: bold;">BELUM WAKTUNYA PULANG</span><br>
									<small>Gerbang dibuka jam <?php echo date('H:i', strtotime($setting->mulai_absen_pulang)) ?></small>
								</button>
							<?php endif; ?>
						<?php else : ?>
							<div class="alert alert-success text-center py-3 mb-0">
								<i class="fas fa-check-circle fa-2x mb-2"></i><br>
								<strong>Absensi hari ini sudah lengkap!</strong>
							</div>
						<?php endif; ?>

					<?php else : ?>
						<!-- Belum absen -->
						<div class="text-center mb-3">
							<p class="text-muted">Anda belum melakukan absen masuk hari ini.</p>
						</div>
						<?php 
						$jam_sekarang = date('H:i:s');
						if ($jam_sekarang >= $setting->mulai_absen_masuk && $jam_sekarang <= $setting->batas_terlambat_berat) : ?>
							<a href="<?php echo base_url('pegawai/absensi/absen_masuk') ?>" class="btn btn-success btn-lg btn-block py-4 btn-konfirmasi" data-judul="Absen Masuk?" data-pesan="Catat kehadiran kerja Anda hari ini?" data-tipe="question" data-warna="#1cc88a" data-btn-teks="<i class='fas fa-sign-in-alt'></i> Ya, Absen Masuk!">
								<i class="fas fa-sign-in-alt fa-3x mb-2"></i><br>
								<span style="font-size: 24px; font-weight: bold;">ABSEN MASUK</span>
							</a>
						<?php elseif ($jam_sekarang < $setting->mulai_absen_masuk) : ?>
							<button class="btn btn-secondary btn-lg btn-block py-4 text-white" disabled style="cursor: not-allowed; opacity: 0.7;">
								<i class="fas fa-lock fa-3x mb-2"></i><br>
								<span style="font-size: 24px; font-weight: bold;">BELUM WAKTUNYA MASUK</span><br>
								<small>Gerbang absen masuk dibuka jam <?php echo date('H:i', strtotime($setting->mulai_absen_masuk)) ?></small>
							</button>
						<?php else : ?>
							<button class="btn btn-danger btn-lg btn-block py-4 text-white" disabled style="cursor: not-allowed; opacity: 0.7;">
								<i class="fas fa-times-circle fa-3x mb-2"></i><br>
								<span style="font-size: 24px; font-weight: bold;">GERBANG ABSEN DITUTUP</span><br>
								<small>Melewati batas maksimal keterlambatan (<?php echo date('H:i', strtotime($setting->batas_terlambat_berat)) ?>)</small>
							</button>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Ringkasan Bulan Ini -->
	<div class="row">
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir Bulan Ini</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['hadir'] ?> hari</div>
						</div>
						<div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['terlambat'] ?> kali</div>
						</div>
						<div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sakit / Izin</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['sakit'] + $ringkasan['izin'] ?> hari</div>
						</div>
						<div class="col-auto"><i class="fas fa-hospital fa-2x text-gray-300"></i></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-danger shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alpha</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ringkasan['alpha'] ?> hari</div>
						</div>
						<div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Script Jam Real-Time -->
<script>
function updateClock() {
	var now = new Date();
	var hours = String(now.getHours()).padStart(2, '0');
	var minutes = String(now.getMinutes()).padStart(2, '0');
	var seconds = String(now.getSeconds()).padStart(2, '0');
	document.getElementById('jam-realtime').textContent = hours + ':' + minutes + ':' + seconds;

	var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
	var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
	document.getElementById('tanggal-realtime').textContent = hari[now.getDay()] + ', ' + now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear();
}
setInterval(updateClock, 1000);
updateClock();
</script>
<!-- /.container-fluid -->
