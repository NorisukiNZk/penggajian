<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
		<div>
			<h1 class="h3 mb-1 font-weight-bold text-gray-800" style="letter-spacing: -0.02em;"><?php echo $title ?></h1>
			<p class="text-muted small mb-0">Rekapitulasi log absensi harian seluruh pegawai per periode bulan dan tahun.</p>
		</div>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Filter Bulan & Tahun -->
	<div class="card mb-3">
		<div class="card-header bg-info text-white">
			<i class="fas fa-filter"></i> Filter Periode
		</div>
		<div class="card-body">
			<form class="form-inline" method="GET" action="<?php echo base_url('admin/absensi_harian/rekap') ?>">
				<div class="form-group mb-2">
					<label>Bulan</label>
					<select class="form-control ml-3" name="bulan">
						<?php
						$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
						foreach ($nama_bulan as $key => $val) : ?>
							<option value="<?php echo $key ?>" <?php echo ($bulan == $key) ? 'selected' : '' ?>><?php echo $val ?></option>
						<?php endforeach; ?>
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

	<!-- Ringkasan Komposisi Hari Kerja Efektif & Sinkronisasi -->
	<div class="row mb-3">
		<div class="col-xl-3 col-md-6 mb-2">
			<div class="card border-left-info shadow-xs py-2 px-3 h-100">
				<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Hari Kalender</div>
				<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($stat_hari) ? $stat_hari['total_hari'] : date('t', mktime(0,0,0,(int)$bulan,1,(int)$tahun)) ?> Hari</div>
				<small class="text-muted">Bulan <?php echo $nama_bulan[$bulan] . ' ' . $tahun ?></small>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-2">
			<div class="card border-left-secondary shadow-xs py-2 px-3 h-100">
				<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Libur Resmi (Minggu + Libur)</div>
				<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($stat_hari) ? ($stat_hari['jumlah_minggu'] + $stat_hari['jumlah_libur']) : 0 ?> Hari Libur</div>
				<small class="text-muted"><?php echo isset($stat_hari) ? $stat_hari['jumlah_minggu'] : 0 ?> Minggu + <?php echo isset($stat_hari) ? $stat_hari['jumlah_libur'] : 0 ?> Tanggal Merah</small>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-2">
			<div class="card border-left-primary shadow-xs py-2 px-3 h-100">
				<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hari Kerja Efektif Wajib</div>
				<div class="h5 mb-0 font-weight-bold text-primary"><?php echo isset($stat_hari) ? $stat_hari['hari_kerja_efektif'] : 0 ?> Hari Kerja</div>
				<small class="text-muted">Batas maksimal alpha jika nihil absen</small>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 mb-2">
			<div class="card border-left-success shadow-xs py-2 px-3 h-100">
				<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Status Sinkronisasi Gaji</div>
				<div class="h6 mb-0 font-weight-bold text-success"><i class="fas fa-check-circle mr-1"></i> Realtime Otomatis</div>
				<small class="text-muted">Tersinkron langsung ke data penggajian</small>
			</div>
		</div>
	</div>

	<!-- Info Setting & Aturan -->
	<div class="alert alert-light border shadow-xs d-flex align-items-center py-2 px-3 mb-4" style="border-radius: 10px;">
		<i class="fas fa-info-circle text-primary fa-lg mr-3"></i>
		<div class="small">
			<strong>Aturan Evaluasi Kehadiran:</strong> Pegawai yang tidak hadir pada hari kerja efektif dihitung <strong>Alpha</strong>. Terlambat <?php echo $setting->maks_terlambat_jadi_alpha ?>x dalam sebulan dikonversi setara 1 hari Alpha. Hari Minggu dan Tanggal Merah <strong>tidak dihitung Alpha</strong> karena merupakan hak libur resmi.
		</div>
	</div>

	<!-- Tabel Rekap -->
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between align-items-center">
			<h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Kehadiran <?php echo $nama_bulan[$bulan] ?> <?php echo $tahun ?></h6>
			<div class="d-flex align-items-center">
				<span class="badge badge-light border text-success px-3 py-2 mr-2 font-weight-bold shadow-xs">
					<i class="fas fa-bolt text-warning mr-1"></i> Realtime Sync Aktif
				</span>
				<form method="POST" action="<?php echo base_url('admin/absensi_harian/sinkron_gaji') ?>" class="d-inline">
					<input type="hidden" name="bulan" value="<?php echo $bulan ?>">
					<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
					<button type="button" class="btn btn-outline-success btn-sm btn-konfirmasi" data-judul="Sinkronisasi Paksa?" data-pesan="Data absensi harian akan disinkronkan ulang ke Data Kehadiran untuk penggajian. Lanjutkan?" data-tipe="question" data-warna="#1cc88a" data-btn-teks="<i class='fas fa-sync'></i> Ya, Sinkronkan!">
						<i class="fas fa-sync"></i> Refresh Sinkron
					</button>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" style="display: none">
				</form>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center" width="4%">No</th>
							<th class="text-center">NIK</th>
							<th class="text-center">Nama Pegawai</th>
							<th class="text-center">Jabatan</th>
							<th class="text-center" width="7%">Hadir</th>
							<th class="text-center" width="7%">Terlambat</th>
							<th class="text-center" width="7%">Sakit</th>
							<th class="text-center" width="7%">Izin</th>
							<th class="text-center" width="7%">Alpha</th>
							<th class="text-center" width="7%">Alpha (Terlambat)</th>
							<th class="text-center" width="7%">Total Alpha</th>
							<th class="text-center" width="8%">Detail</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($rekap as $r) : ?>
						<tr>
							<td class="text-center"><?php echo $no++ ?></td>
							<td class="text-center"><?php echo $r['nik'] ?></td>
							<td><?php echo $r['nama_pegawai'] ?></td>
							<td class="text-center"><?php echo $r['jabatan'] ?></td>
							<td class="text-center"><span class="badge badge-success"><?php echo $r['hadir'] ?></span></td>
							<td class="text-center"><span class="badge badge-warning"><?php echo $r['terlambat'] ?></span></td>
							<td class="text-center"><span class="badge badge-info"><?php echo $r['sakit'] ?></span></td>
							<td class="text-center"><span class="badge badge-primary"><?php echo $r['izin'] ?></span></td>
							<td class="text-center"><span class="badge badge-danger"><?php echo $r['alpha'] ?></span></td>
							<td class="text-center"><span class="badge badge-dark"><?php echo $r['alpha_dari_terlambat'] ?></span></td>
							<td class="text-center"><span class="badge badge-danger font-weight-bold" style="font-size: 14px;"><?php echo $r['total_alpha'] ?></span></td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/absensi_harian/detail/' . $r['nik'] . '?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-sm btn-primary">
									<i class="fas fa-eye"></i>
								</a>
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
