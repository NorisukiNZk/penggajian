<!-- Begin Page Content -->
<div class="container-fluid py-2">

	<!-- Page Heading & Current Date -->
	<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
		<div>
			<h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title ?></h1>
			<p class="text-muted small mb-0">Ringkasan analitik absensi dan kepegawaian real-time Klinik Hidayatullah.</p>
		</div>

		<div id="date" class="px-3 py-2 bg-white rounded-pill border shadow-sm small font-weight-bold text-primary mt-2 mt-md-0">
			<i class="fas fa-calendar-alt text-info mr-1"></i> <span id="currentDateText">Memuat tanggal...</span>
		</div>
		<script>
			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth();
			var year = date.getFullYear();
			document.getElementById("currentDateText").innerText = day + " " + months[month] + " " + year;
		</script>
	</div>

	<!-- Content Row: Top Cards (Modern Real-Time Absensi KPI) -->
	<div class="row">

		<!-- Total Pegawai Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary h-100 py-2">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 0.05em;">Total Pegawai Aktif</div>
							<div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $total_pegawai ?> <span class="text-xs font-weight-normal text-muted">Orang</span></div>
							<span class="badge badge-light border text-primary mt-2 small"><i class="fas fa-id-badge mr-1"></i> Terdaftar</span>
						</div>
						<div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd);">
							<i class="fas fa-users fa-lg text-primary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Hadir Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success h-100 py-2">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="letter-spacing: 0.05em;">Hadir Tepat Waktu</div>
							<div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $hadir_hari_ini ?> <span class="text-xs font-weight-normal text-muted">Orang</span></div>
							<span class="badge badge-light border text-success mt-2 small"><i class="fas fa-check-circle mr-1"></i> Hari ini</span>
						</div>
						<div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
							<i class="fas fa-check-double fa-lg text-success"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Terlambat Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning h-100 py-2">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="letter-spacing: 0.05em;">Terlambat Masuk</div>
							<div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $terlambat_hari_ini ?> <span class="text-xs font-weight-normal text-muted">Orang</span></div>
							<span class="badge badge-light border text-warning mt-2 small"><i class="fas fa-clock mr-1"></i> Melewati batas</span>
						</div>
						<div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
							<i class="fas fa-user-clock fa-lg text-warning"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Sakit/Izin Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info h-100 py-2">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<div>
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="letter-spacing: 0.05em;">Sakit / Izin Resmi</div>
							<div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $sakit_izin_hari_ini ?> <span class="text-xs font-weight-normal text-muted">Orang</span></div>
							<span class="badge badge-light border text-info mt-2 small"><i class="fas fa-notes-medical mr-1"></i> Disetujui</span>
						</div>
						<div class="p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
							<i class="fas fa-hospital-user fa-lg text-info"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Content Row: Modern Chart.js v4 Analytics -->
	<div class="row">

		<!-- Line Chart: Trend Kehadiran -->
		<div class="col-xl-8 col-lg-7 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-header d-flex flex-row align-items-center justify-content-between">
					<div>
						<h6 class="m-0 font-weight-bold text-primary">
							<i class="fas fa-chart-area mr-1"></i> Tren Kehadiran Pegawai
						</h6>
						<small class="text-muted">Riwayat presensi 6 bulan terakhir</small>
					</div>
					<div class="d-flex">
						<span class="badge badge-pill badge-light border text-success mr-1"><i class="fas fa-circle fa-xs mr-1"></i> Hadir</span>
						<span class="badge badge-pill badge-light border text-warning mr-1"><i class="fas fa-circle fa-xs mr-1"></i> Sakit/Izin</span>
						<span class="badge badge-pill badge-light border text-danger"><i class="fas fa-circle fa-xs mr-1"></i> Alpha</span>
					</div>
				</div>
				<div class="card-body">
					<div class="chart-area" style="height: 330px; position: relative;">
						<canvas id="trendKehadiranChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<!-- Doughnut Chart: Distribusi Jabatan -->
		<div class="col-xl-4 col-lg-5 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-header d-flex flex-row align-items-center justify-content-between">
					<div>
						<h6 class="m-0 font-weight-bold text-primary">
							<i class="fas fa-chart-pie mr-1"></i> Komposisi Jabatan
						</h6>
						<small class="text-muted">Sebaran tenaga medis & operasional</small>
					</div>
				</div>
				<div class="card-body d-flex flex-column justify-content-center">
					<div class="chart-pie" style="height: 270px; position: relative;">
						<canvas id="distribusiJabatanChart"></canvas>
					</div>
					<div class="text-center mt-3 small text-muted">
						<i class="fas fa-info-circle mr-1"></i> Arahkan kursor pada diagram untuk melihat total per posisi.
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Content Row: Widgets Antrean & Kalender Libur -->
	<div class="row">
		<!-- Kalender Libur Widget -->
		<div class="col-xl-6 col-lg-6 mb-4">
			<div class="card shadow-sm h-100 border-left-danger">
				<div class="card-header d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-danger">
						<i class="fas fa-calendar-times mr-1"></i> Hari Libur & Tanggal Merah
					</h6>
					<a href="<?php echo base_url('admin/hari_libur') ?>" class="btn btn-sm btn-light border text-danger">
						Kelola <i class="fas fa-arrow-right fa-xs"></i>
					</a>
				</div>
				<div class="card-body">
					<?php if(empty($hari_libur)) { ?>
						<div class="text-center py-4 text-muted">
							<i class="fas fa-calendar-check fa-3x text-gray-300 mb-2"></i>
							<p class="mb-0">Tidak ada jadwal hari libur terdekat.</p>
						</div>
					<?php } else { ?>
						<div class="list-group list-group-flush">
							<?php foreach($hari_libur as $hl): ?>
							<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
								<div>
									<h6 class="my-0 font-weight-bold text-gray-800"><?php echo $hl->keterangan ?></h6>
									<small class="text-danger font-weight-bold"><i class="fas fa-calendar-day mr-1"></i> <?php echo date('d F Y', strtotime($hl->tanggal)) ?></small>
								</div>
								<span class="badge badge-danger">Libur</span>
							</div>
							<?php endforeach; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<!-- Pusat Antrean Persetujuan HRD -->
		<div class="col-xl-6 col-lg-6 mb-4">
			<div class="card shadow-sm h-100 border-left-warning">
				<div class="card-header d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">
						<i class="fas fa-bell mr-1"></i> Pusat Persetujuan & Antrean HRD
					</h6>
					<?php if ($total_pending > 0) : ?>
						<span class="badge badge-warning text-dark"><i class="fas fa-exclamation-circle mr-1"></i> <?php echo $total_pending ?> Menunggu</span>
					<?php else : ?>
						<span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Semua Beres (0)</span>
					<?php endif; ?>
				</div>
				<div class="card-body d-flex flex-column justify-content-between">
					<div class="list-group list-group-flush mb-3">
						
						<!-- Item Cuti -->
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
							<div>
								<h6 class="my-0 font-weight-bold text-gray-800">
									<i class="fas fa-umbrella-beach text-info mr-2"></i> Pengajuan Cuti Pegawai
								</h6>
								<small class="text-muted">Permohonan izin sakit & cuti tahunan</small>
							</div>
							<div class="d-flex align-items-center">
								<?php if ($pending_cuti > 0) : ?>
									<span class="badge badge-warning text-dark mr-2"><?php echo $pending_cuti ?> Pending</span>
								<?php else : ?>
									<span class="badge badge-light border text-muted mr-2">0</span>
								<?php endif; ?>
								<a href="<?php echo base_url('admin/data_cuti') ?>" class="btn btn-sm btn-outline-info">
									Buka <i class="fas fa-arrow-right fa-xs"></i>
								</a>
							</div>
						</div>

						<!-- Item Lembur -->
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
							<div>
								<h6 class="my-0 font-weight-bold text-gray-800">
									<i class="fas fa-business-time text-warning mr-2"></i> Pengajuan Lembur Pegawai
								</h6>
								<small class="text-muted">Verifikasi durasi & jam lembur tugas</small>
							</div>
							<div class="d-flex align-items-center">
								<?php if ($pending_lembur > 0) : ?>
									<span class="badge badge-warning text-dark mr-2"><?php echo $pending_lembur ?> Pending</span>
								<?php else : ?>
									<span class="badge badge-light border text-muted mr-2">0</span>
								<?php endif; ?>
								<a href="<?php echo base_url('admin/data_lembur') ?>" class="btn btn-sm btn-outline-warning">
									Buka <i class="fas fa-arrow-right fa-xs"></i>
								</a>
							</div>
						</div>

						<!-- Item Kasbon -->
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
							<div>
								<h6 class="my-0 font-weight-bold text-gray-800">
									<i class="fas fa-hand-holding-usd text-success mr-2"></i> Permohonan Pinjaman Kasbon
								</h6>
								<small class="text-muted">Verifikasi plafon dan skema angsuran</small>
							</div>
							<div class="d-flex align-items-center">
								<?php if ($pending_pinjaman > 0) : ?>
									<span class="badge badge-warning text-dark mr-2"><?php echo $pending_pinjaman ?> Pending</span>
								<?php else : ?>
									<span class="badge badge-light border text-muted mr-2">0</span>
								<?php endif; ?>
								<a href="<?php echo base_url('admin/pinjaman') ?>" class="btn btn-sm btn-outline-success">
									Buka <i class="fas fa-arrow-right fa-xs"></i>
								</a>
							</div>
						</div>

					</div>

					<!-- Status Box Footer -->
					<?php if ($total_pending == 0) : ?>
						<div class="p-3 bg-light rounded text-center text-success small font-weight-bold border border-success">
							<i class="fas fa-check-circle mr-1"></i> Tidak ada antrean pengajuan yang menunggu keputusan Anda saat ini.
						</div>
					<?php else : ?>
						<div class="p-3 bg-light rounded text-center text-warning small font-weight-bold border border-warning">
							<i class="fas fa-bell mr-1"></i> Mohon tinjau total <b><?php echo $total_pending ?></b> pengajuan di atas untuk kelancaran operasional.
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

<!-- Scripts khusus untuk Chart Dashboard Analytics (Chart.js v4.4+) -->
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {

	// 1. Chart: Distribusi Jabatan (Chart.js v4 Doughnut)
	var ctxPie = document.getElementById("distribusiJabatanChart");
	if (ctxPie) {
		new Chart(ctxPie, {
			type: 'doughnut',
			data: {
				labels: <?php echo $label_jabatan; ?>,
				datasets: [{
					data: <?php echo $data_jabatan; ?>,
					backgroundColor: [
						'#0c2b4d', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#64748b'
					],
					hoverBackgroundColor: [
						'#123d6c', '#0284c7', '#059669', '#d97706', '#dc2626', '#7c3aed', '#475569'
					],
					borderWidth: 2,
					borderColor: '#ffffff',
					hoverOffset: 6
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '72%',
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							boxWidth: 10,
							padding: 12,
							usePointStyle: true,
							pointStyle: 'circle',
							font: {
								family: "'Plus Jakarta Sans', sans-serif",
								size: 11,
								weight: '600'
							}
						}
					},
					tooltip: {
						padding: 12,
						cornerRadius: 10,
						bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
						callbacks: {
							label: function(context) {
								return ' ' + context.label + ': ' + context.raw + ' Orang';
							}
						}
					}
				}
			}
		});
	}

	// 2. Chart: Tren Kehadiran 6 Bulan (Chart.js v4 Line with Gradients)
	var ctxLine = document.getElementById("trendKehadiranChart");
	if (ctxLine) {
		var ctx2d = ctxLine.getContext('2d');
		
		var gradHadir = ctx2d.createLinearGradient(0, 0, 0, 300);
		gradHadir.addColorStop(0, 'rgba(16, 185, 129, 0.28)');
		gradHadir.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

		var gradSakit = ctx2d.createLinearGradient(0, 0, 0, 300);
		gradSakit.addColorStop(0, 'rgba(245, 158, 11, 0.22)');
		gradSakit.addColorStop(1, 'rgba(245, 158, 11, 0.01)');

		var gradAlpha = ctx2d.createLinearGradient(0, 0, 0, 300);
		gradAlpha.addColorStop(0, 'rgba(239, 68, 68, 0.22)');
		gradAlpha.addColorStop(1, 'rgba(239, 68, 68, 0.01)');

		new Chart(ctxLine, {
			type: 'line',
			data: {
				labels: <?php echo $label_bulan; ?>,
				datasets: [
					{
						label: "Hadir",
						data: <?php echo $trend_hadir; ?>,
						fill: true,
						backgroundColor: gradHadir,
						borderColor: '#10b981',
						borderWidth: 3,
						tension: 0.4,
						pointRadius: 4,
						pointBackgroundColor: '#10b981',
						pointBorderColor: '#ffffff',
						pointBorderWidth: 2,
						pointHoverRadius: 6
					},
					{
						label: "Sakit/Izin",
						data: <?php echo $trend_sakit; ?>,
						fill: true,
						backgroundColor: gradSakit,
						borderColor: '#f59e0b',
						borderWidth: 2.5,
						tension: 0.4,
						pointRadius: 4,
						pointBackgroundColor: '#f59e0b',
						pointBorderColor: '#ffffff',
						pointBorderWidth: 2,
						pointHoverRadius: 6
					},
					{
						label: "Alpha",
						data: <?php echo $trend_alpha; ?>,
						fill: true,
						backgroundColor: gradAlpha,
						borderColor: '#ef4444',
						borderWidth: 2.5,
						tension: 0.4,
						pointRadius: 4,
						pointBackgroundColor: '#ef4444',
						pointBorderColor: '#ffffff',
						pointBorderWidth: 2,
						pointHoverRadius: 6
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				interaction: {
					mode: 'index',
					intersect: false
				},
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						padding: 12,
						cornerRadius: 10,
						bodyFont: { family: "'Plus Jakarta Sans', sans-serif" },
						titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' }
					}
				},
				scales: {
					x: {
						grid: { display: false },
						ticks: {
							font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: '500' },
							color: '#64748b'
						}
					},
					y: {
						beginAtZero: true,
						grid: {
							color: 'rgba(226, 232, 240, 0.7)',
							drawBorder: false,
							borderDash: [4, 4]
						},
						ticks: {
							font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
							color: '#64748b',
							stepSize: 5
						}
					}
				}
			}
		});
	}
});
</script>
