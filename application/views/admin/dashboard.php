<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>

		<div id="date" class="font-weight-bold text-primary"></div>
		<script>
			var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth();
			var year = date.getFullYear()

			document.getElementById("date").innerHTML = "<i class='fas fa-calendar-alt'></i> " + day + " " + months[month] + " " + year;
		</script>
	</div>

	<!-- Content Row: Top Cards (Real-Time Absensi) -->
	<div class="row">

		<!-- Total Pegawai Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pegawai Aktif</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_pegawai ?> Orang</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Hadir Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir Tepat Waktu (Hari Ini)</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $hadir_hari_ini ?> Orang</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-check-circle fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Terlambat Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Terlambat (Hari Ini)</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $terlambat_hari_ini ?> Orang</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clock fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Sakit/Izin Hari Ini Card -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sakit / Izin (Hari Ini)</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sakit_izin_hari_ini ?> Orang</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-hospital fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Content Row: Grafik Analytics -->
	<div class="row">

		<!-- Line Chart: Trend Kehadiran -->
		<div class="col-xl-8 col-lg-7">
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-line"></i> Grafik Tren Kehadiran (6 Bulan Terakhir)</h6>
				</div>
				<div class="card-body">
					<div class="chart-area" style="height: 350px;">
						<canvas id="trendKehadiranChart"></canvas>
					</div>
					<hr>
					<div class="text-center small">
						<span class="mr-2">
							<i class="fas fa-circle text-success"></i> Hadir
						</span>
						<span class="mr-2">
							<i class="fas fa-circle text-warning"></i> Sakit/Izin
						</span>
						<span class="mr-2">
							<i class="fas fa-circle text-danger"></i> Alpha
						</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Doughnut Chart: Distribusi Jabatan -->
		<div class="col-xl-4 col-lg-5">
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie"></i> Komposisi Jabatan Pegawai</h6>
				</div>
				<div class="card-body">
					<div class="chart-pie pt-4 pb-2" style="height: 300px;">
						<canvas id="distribusiJabatanChart"></canvas>
					</div>
					<hr>
					<div class="text-center small text-muted">
						Menampilkan sebaran pegawai aktif berdasarkan posisi jabatan.
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Content Row: Widget Tambahan -->
	<div class="row">
		<!-- Kalender Libur Widget -->
		<div class="col-xl-6 col-lg-6 mb-4">
			<div class="card shadow h-100 border-left-danger">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-calendar-times"></i> Kalender Libur Nasional & Cuti Bersama</h6>
				</div>
				<div class="card-body">
					<?php if(empty($hari_libur)) { ?>
						<p class="text-center text-muted my-4">Tidak ada jadwal hari libur terdekat.</p>
					<?php } else { ?>
						<div class="list-group list-group-flush">
							<?php foreach($hari_libur as $hl): ?>
							<div class="list-group-item d-flex justify-content-between align-items-center px-0">
								<div>
									<h6 class="my-0 font-weight-bold text-gray-800"><?php echo $hl->keterangan ?></h6>
									<small class="text-danger font-weight-bold"><i class="fas fa-calendar-day"></i> <?php echo date('d F Y', strtotime($hl->tanggal)) ?></small>
								</div>
								<span class="badge badge-danger badge-pill">Libur</span>
							</div>
							<?php endforeach; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Scripts khusus untuk Chart Dashboard Analytics -->
<!-- Memastikan Chart.js sudah diload dari footer sebelumnya -->
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {

	// 1. Chart: Distribusi Jabatan (Doughnut Chart)
	var ctxPie = document.getElementById("distribusiJabatanChart");
	if (ctxPie) {
		var myPieChart = new Chart(ctxPie, {
			type: 'doughnut',
			data: {
				labels: <?php echo $label_jabatan; ?>,
				datasets: [{
					data: <?php echo $data_jabatan; ?>,
					backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
					hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617', '#60616f'],
					hoverBorderColor: "rgba(234, 236, 244, 1)",
				}],
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					backgroundColor: "rgb(255,255,255)",
					bodyFontColor: "#858796",
					borderColor: '#dddfeb',
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					displayColors: false,
					caretPadding: 10,
				},
				legend: {
					display: true,
					position: 'bottom'
				},
				cutoutPercentage: 70,
			},
		});
	}

	// 2. Chart: Tren Kehadiran 6 Bulan (Line Chart)
	var ctxLine = document.getElementById("trendKehadiranChart");
	if (ctxLine) {
		var myLineChart = new Chart(ctxLine, {
			type: 'line',
			data: {
				labels: <?php echo $label_bulan; ?>,
				datasets: [
					{
						label: "Hadir",
						lineTension: 0.3,
						backgroundColor: "rgba(28, 200, 138, 0.05)",
						borderColor: "rgba(28, 200, 138, 1)",
						pointRadius: 3,
						pointBackgroundColor: "rgba(28, 200, 138, 1)",
						pointBorderColor: "rgba(28, 200, 138, 1)",
						pointHoverRadius: 3,
						pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
						pointHoverBorderColor: "rgba(28, 200, 138, 1)",
						pointHitRadius: 10,
						pointBorderWidth: 2,
						data: <?php echo $trend_hadir; ?>,
					},
					{
						label: "Sakit/Izin",
						lineTension: 0.3,
						backgroundColor: "rgba(246, 194, 62, 0.05)",
						borderColor: "rgba(246, 194, 62, 1)",
						pointRadius: 3,
						pointBackgroundColor: "rgba(246, 194, 62, 1)",
						pointBorderColor: "rgba(246, 194, 62, 1)",
						pointHoverRadius: 3,
						pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
						pointHoverBorderColor: "rgba(246, 194, 62, 1)",
						pointHitRadius: 10,
						pointBorderWidth: 2,
						data: <?php echo $trend_sakit; ?>,
					},
					{
						label: "Alpha",
						lineTension: 0.3,
						backgroundColor: "rgba(231, 74, 59, 0.05)",
						borderColor: "rgba(231, 74, 59, 1)",
						pointRadius: 3,
						pointBackgroundColor: "rgba(231, 74, 59, 1)",
						pointBorderColor: "rgba(231, 74, 59, 1)",
						pointHoverRadius: 3,
						pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
						pointHoverBorderColor: "rgba(231, 74, 59, 1)",
						pointHitRadius: 10,
						pointBorderWidth: 2,
						data: <?php echo $trend_alpha; ?>,
					}
				],
			},
			options: {
				maintainAspectRatio: false,
				layout: {
					padding: {
						left: 10,
						right: 25,
						top: 25,
						bottom: 0
					}
				},
				scales: {
					xAxes: [{
						time: { unit: 'date' },
						gridLines: {
							display: false,
							drawBorder: false
						},
						ticks: { maxTicksLimit: 7 }
					}],
					yAxes: [{
						ticks: {
							maxTicksLimit: 5,
							padding: 10,
						},
						gridLines: {
							color: "rgb(234, 236, 244)",
							zeroLineColor: "rgb(234, 236, 244)",
							drawBorder: false,
							borderDash: [2],
							zeroLineBorderDash: [2]
						}
					}],
				},
				legend: { display: false },
				tooltips: {
					backgroundColor: "rgb(255,255,255)",
					bodyFontColor: "#858796",
					titleMarginBottom: 10,
					titleFontColor: '#6e707e',
					titleFontSize: 14,
					borderColor: '#dddfeb',
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					displayColors: false,
					intersect: false,
					mode: 'index',
					caretPadding: 10,
				}
			}
		});
	}
});
</script>
