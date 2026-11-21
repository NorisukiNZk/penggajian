<!-- Begin Page Content -->
<div class="container-fluid py-2">

	<!-- Page Heading & Current Date -->
	<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
		<div>
			<h1 class="h3 mb-1 font-weight-bold adm-serif text-gray-800"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
			<p class="text-muted small mb-0">Ringkasan operasional absensi, beban penggajian, dan catatan audit Klinik Pratama Dr. H.M. Hidayatullah.</p>
		</div>

		<div id="date" class="adm-date-pill mt-2 mt-md-0">
			<i class="fas fa-calendar-alt" aria-hidden="true"></i> <span id="currentDateText">Memuat tanggal...</span>
		</div>
		<script>
			(function() {
				var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
				var d = new Date();
				var el = document.getElementById("currentDateText");
				if (el) el.innerText = d.getDate() + " " + months[d.getMonth()] + " " + d.getFullYear();
			})();
		</script>
	</div>

	<!-- Row 1: KPI Kepegawaian & Presensi Hari Ini -->
	<div class="row">
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="text-xs font-weight-bold text-uppercase text-muted mb-1" style="letter-spacing: 0.05em;">Total Pegawai Aktif</div>
						<div class="h4 mb-1 font-weight-bold adm-serif tabular-nums text-gray-800"><?php echo (int)$total_pegawai; ?> <span class="small font-weight-normal text-muted">Orang</span></div>
						<div class="small text-muted"><i class="fas fa-id-badge mr-1" aria-hidden="true"></i> Terdaftar di sistem</div>
					</div>
					<div class="adm-kpi-icon is-navy"><i class="fas fa-users" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="text-xs font-weight-bold text-uppercase text-muted mb-1" style="letter-spacing: 0.05em;">Hadir Tepat Waktu</div>
						<div class="h4 mb-1 font-weight-bold adm-serif tabular-nums text-gray-800"><?php echo (int)$hadir_hari_ini; ?> <span class="small font-weight-normal text-muted">Orang</span></div>
						<div class="small font-weight-bold text-success"><i class="fas fa-check-circle mr-1" aria-hidden="true"></i> Presensi hari ini</div>
					</div>
					<div class="adm-kpi-icon is-emerald"><i class="fas fa-check-double" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="text-xs font-weight-bold text-uppercase text-muted mb-1" style="letter-spacing: 0.05em;">Terlambat / Sakit / Izin</div>
						<div class="h4 mb-1 font-weight-bold adm-serif tabular-nums text-gray-800"><?php echo (int)$terlambat_hari_ini; ?> <span class="small font-weight-normal text-muted">/ <?php echo (int)$sakit_izin_hari_ini; ?> Izin</span></div>
						<div class="small text-muted"><i class="fas fa-clock mr-1" aria-hidden="true"></i> Catatan harian</div>
					</div>
					<div class="adm-kpi-icon is-amber"><i class="fas fa-user-clock" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card h-100">
				<div class="card-body d-flex align-items-center justify-content-between">
					<div>
						<div class="text-xs font-weight-bold text-uppercase text-muted mb-1" style="letter-spacing: 0.05em;">Estimasi Payroll Bln Ini</div>
						<div class="h5 mb-1 font-weight-bold adm-serif tabular-nums text-gray-800">Rp <?php echo number_format((int)$payroll_bulan_ini, 0, ',', '.'); ?></div>
						<a href="<?php echo base_url('admin/data_penggajian'); ?>" class="small font-weight-bold text-primary">Lihat Rincian Gaji <i class="fas fa-arrow-right fa-xs" aria-hidden="true"></i></a>
					</div>
					<div class="adm-kpi-icon is-emerald"><i class="fas fa-money-check-dollar" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 2: Grafik Pengeluaran Payroll 6 Bulan + Tren Kehadiran + Komposisi Jabatan -->
	<div class="row">
		<div class="col-xl-6 mb-4">
			<div class="card h-100">
				<div class="card-header d-flex align-items-center justify-content-between">
					<div>
						<h6 class="m-0 font-weight-bold text-gray-800">
							<i class="fas fa-chart-column mr-1" aria-hidden="true"></i> Tren Beban Penggajian 6 Bulan
						</h6>
						<small class="text-muted">Perbandingan THP bersih, lembur, dan potongan</small>
					</div>
					<a href="<?php echo base_url('admin/laporan_gaji'); ?>" class="btn btn-sm btn-light border">Arsip</a>
				</div>
				<div class="card-body">
					<div style="height: 280px; position: relative;">
						<canvas id="payrollExpenseChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 mb-4">
			<div class="card h-100">
				<div class="card-header d-flex flex-wrap align-items-center justify-content-between" style="gap: 0.5rem;">
					<div>
						<h6 class="m-0 font-weight-bold text-gray-800">
							<i class="fas fa-chart-area mr-1" aria-hidden="true"></i> Tren Kehadiran 6 Bulan
						</h6>
						<small class="text-muted">Statistik hadir, sakit/izin, dan alpha</small>
					</div>
					<div class="d-flex flex-wrap" style="gap: 0.3rem;">
						<span class="badge badge-light border text-success">Hadir</span>
						<span class="badge badge-light border text-warning">Sakit/Izin</span>
						<span class="badge badge-light border text-danger">Alpha</span>
					</div>
				</div>
				<div class="card-body">
					<div style="height: 280px; position: relative;">
						<canvas id="trendKehadiranChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 3: Komposisi Jabatan + Kalender Libur + Antrean HRD + Audit Trail Terbaru -->
	<div class="row">
		<div class="col-xl-4 col-lg-6 mb-4">
			<div class="card h-100">
				<div class="card-header">
					<h6 class="m-0 font-weight-bold text-gray-800">
						<i class="fas fa-chart-pie mr-1" aria-hidden="true"></i> Komposisi Jabatan
					</h6>
					<small class="text-muted">Sebaran tenaga medis &amp; operasional</small>
				</div>
				<div class="card-body d-flex flex-column justify-content-center">
					<div style="height: 245px; position: relative;">
						<canvas id="distribusiJabatanChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-6 mb-4">
			<div class="card h-100">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-gray-800">
						<i class="fas fa-bell mr-1" aria-hidden="true"></i> Antrean &amp; Kalender Libur
					</h6>
					<?php if ($total_pending > 0) : ?>
						<span class="badge badge-warning text-dark"><?php echo (int)$total_pending; ?> Menunggu</span>
					<?php else : ?>
						<span class="badge badge-success">0 Menunggu</span>
					<?php endif; ?>
				</div>
				<div class="card-body d-flex flex-column justify-content-between">
					<div class="list-group list-group-flush mb-3">
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
							<div>
								<div class="font-weight-bold small text-gray-800">Cuti &amp; Izin Pegawai</div>
								<small class="text-muted"><?php echo (int)$pending_cuti; ?> pengajuan aktif</small>
							</div>
							<a href="<?php echo base_url('admin/data_cuti'); ?>" class="btn btn-sm btn-light border">Buka</a>
						</div>
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
							<div>
								<div class="font-weight-bold small text-gray-800">Verifikasi Lembur</div>
								<small class="text-muted"><?php echo (int)$pending_lembur; ?> pengajuan aktif</small>
							</div>
							<a href="<?php echo base_url('admin/data_lembur'); ?>" class="btn btn-sm btn-light border">Buka</a>
						</div>
						<div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
							<div>
								<div class="font-weight-bold small text-gray-800">Permohonan Pinjaman</div>
								<small class="text-muted"><?php echo (int)$pending_pinjaman; ?> pengajuan aktif</small>
							</div>
							<a href="<?php echo base_url('admin/pinjaman'); ?>" class="btn btn-sm btn-light border">Buka</a>
						</div>
					</div>

					<div class="pt-2 border-top">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<span class="small font-weight-bold text-gray-800">Hari Libur Terdekat</span>
							<a href="<?php echo base_url('admin/hari_libur'); ?>" class="small font-weight-bold">Kelola</a>
						</div>
						<?php if (empty($hari_libur)) : ?>
							<p class="small text-muted mb-0">Tidak ada jadwal hari libur terdekat.</p>
						<?php else : ?>
							<?php foreach (array_slice($hari_libur, 0, 2) as $hl) : ?>
								<div class="d-flex justify-content-between align-items-center small py-1">
									<span class="text-truncate mr-2"><?php echo htmlspecialchars($hl->keterangan, ENT_QUOTES, 'UTF-8'); ?></span>
									<span class="badge badge-danger flex-shrink-0"><?php echo date('d M', strtotime($hl->tanggal)); ?></span>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-lg-12 mb-4">
			<div class="card h-100">
				<div class="card-header d-flex align-items-center justify-content-between">
					<div>
						<h6 class="m-0 font-weight-bold text-gray-800">
							<i class="fas fa-clipboard-list mr-1" aria-hidden="true"></i> Audit Log Terbaru
						</h6>
						<small class="text-muted">Aktivitas keamanan &amp; persetujuan terakhir</small>
					</div>
					<a href="<?php echo base_url('admin/log_aktivitas'); ?>" class="btn btn-sm btn-light border">Semua</a>
				</div>
				<div class="card-body">
					<?php if (empty($recent_logs)) : ?>
						<div class="text-center py-4 text-muted small">
							Belum ada catatan aktivitas terbaru.
						</div>
					<?php else : ?>
						<div class="list-group list-group-flush">
							<?php foreach ($recent_logs as $log) : ?>
								<div class="list-group-item px-0 py-2">
									<div class="d-flex justify-content-between align-items-center mb-1">
										<span class="badge badge-light border text-uppercase" style="font-size: 0.68rem;">
											<?php echo htmlspecialchars($log->modul . ' / ' . $log->aksi, ENT_QUOTES, 'UTF-8'); ?>
										</span>
										<small class="text-muted tabular-nums" style="font-size: 0.72rem;">
											<?php echo date('d/m H:i', strtotime($log->created_at)); ?>
										</small>
									</div>
									<div class="small font-weight-bold text-gray-800 text-truncate" title="<?php echo htmlspecialchars($log->ringkasan, ENT_QUOTES, 'UTF-8'); ?>">
										<?php echo htmlspecialchars($log->ringkasan, ENT_QUOTES, 'UTF-8'); ?>
									</div>
									<small class="text-muted" style="font-size: 0.73rem;">
										Oleh: <?php echo htmlspecialchars($log->aktor_nama, ENT_QUOTES, 'UTF-8'); ?>
									</small>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
	var isDark = document.documentElement.classList.contains('dark-mode') || document.body.classList.contains('dark-mode');
	var tickColor = isDark ? '#A4B0BD' : '#525E6B';
	var gridColor = isDark ? 'rgba(164, 176, 189, 0.16)' : 'rgba(82, 94, 107, 0.15)';
	var borderSlice = isDark ? '#171F2A' : '#FFFDF9';

	var ctxPayroll = document.getElementById("payrollExpenseChart");
	if (ctxPayroll) {
		new Chart(ctxPayroll, {
			type: 'bar',
			data: {
				labels: <?php echo $payroll_labels; ?>,
				datasets: [
					{
						label: 'Gaji Bersih (THP)',
						data: <?php echo $payroll_bersih; ?>,
						backgroundColor: isDark ? '#3B82F6' : '#18293D',
						borderRadius: 4
					},
					{
						label: 'Uang Lembur',
						data: <?php echo $payroll_lembur; ?>,
						backgroundColor: '#10B981',
						borderRadius: 4
					},
					{
						label: 'Total Potongan',
						data: <?php echo $payroll_potongan; ?>,
						backgroundColor: '#D97706',
						borderRadius: 4
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						position: 'bottom',
						labels: { color: tickColor, boxWidth: 10, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } }
					},
					tooltip: {
						callbacks: {
							label: function(ctx) {
								var val = Number(ctx.raw || 0);
								return ' ' + ctx.dataset.label + ': Rp ' + val.toLocaleString('id-ID');
							}
						}
					}
				},
				scales: {
					x: { grid: { display: false }, ticks: { color: tickColor, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } } },
					y: {
						beginAtZero: true,
						grid: { color: gridColor },
						ticks: {
							color: tickColor,
							font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
							callback: function(value) { return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt'; }
						}
					}
				}
			}
		});
	}

	var ctxPie = document.getElementById("distribusiJabatanChart");
	if (ctxPie) {
		new Chart(ctxPie, {
			type: 'doughnut',
			data: {
				labels: <?php echo $label_jabatan; ?>,
				datasets: [{
					data: <?php echo $data_jabatan; ?>,
					backgroundColor: ['#18293D', '#0F5132', '#854D0E', '#1E3A5F', '#B4690E', '#525E6B', '#0284C7'],
					borderWidth: 2,
					borderColor: borderSlice
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '68%',
				plugins: {
					legend: {
						position: 'bottom',
						labels: { color: tickColor, boxWidth: 10, padding: 10, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } }
					},
					tooltip: {
						callbacks: {
							label: function(context) { return ' ' + context.label + ': ' + context.raw + ' Orang'; }
						}
					}
				}
			}
		});
	}

	var ctxLine = document.getElementById("trendKehadiranChart");
	if (ctxLine) {
		new Chart(ctxLine, {
			type: 'line',
			data: {
				labels: <?php echo $label_bulan; ?>,
				datasets: [
					{
						label: "Hadir",
						data: <?php echo $trend_hadir; ?>,
						borderColor: '#10B981',
						backgroundColor: 'rgba(16, 185, 129, 0.14)',
						fill: true,
						tension: 0.35,
						borderWidth: 2.5,
						pointRadius: 3.5
					},
					{
						label: "Sakit/Izin",
						data: <?php echo $trend_sakit; ?>,
						borderColor: '#D97706',
						backgroundColor: 'rgba(217, 119, 6, 0.12)',
						fill: true,
						tension: 0.35,
						borderWidth: 2,
						pointRadius: 3.5
					},
					{
						label: "Alpha",
						data: <?php echo $trend_alpha; ?>,
						borderColor: '#DC2626',
						backgroundColor: 'rgba(220, 38, 38, 0.12)',
						fill: true,
						tension: 0.35,
						borderWidth: 2,
						pointRadius: 3.5
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: { display: false }
				},
				scales: {
					x: { grid: { display: false }, ticks: { color: tickColor, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } } },
					y: {
						beginAtZero: true,
						grid: { color: gridColor },
						ticks: { color: tickColor, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }, stepSize: 5 }
					}
				}
			}
		});
	}
});
</script>
