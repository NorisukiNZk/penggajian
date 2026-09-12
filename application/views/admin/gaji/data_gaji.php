<?php
$daftar_bulan = array(
	'01' => 'Januari',
	'02' => 'Februari',
	'03' => 'Maret',
	'04' => 'April',
	'05' => 'Mei',
	'06' => 'Juni',
	'07' => 'Juli',
	'08' => 'Agustus',
	'09' => 'September',
	'10' => 'Oktober',
	'11' => 'November',
	'12' => 'Desember'
);

$nama_bulan = isset($daftar_bulan[$bulan]) ? $daftar_bulan[$bulan] : $bulan;
$jml_data = count($gaji);

$alpha_rate = 0;
foreach ($potongan as $p) {
	if (strtolower($p->potongan) == 'alpha') {
		$alpha_rate = (int)$p->jml_potongan;
		break;
	}
}
?>

<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div>
			<h1 class="h3 mb-1 text-gray-800 font-weight-bold"><?php echo $title; ?></h1>
			<p class="text-muted small mb-0">Manajemen penggajian bulanan, rincian komponen penerimaan, potongan, dan cetak slip gaji pegawai.</p>
		</div>
		<div class="mt-3 mt-sm-0">
			<span class="badge badge-light border px-3 py-2 text-dark font-weight-bold shadow-xs">
				<i class="fas fa-calendar-alt text-primary mr-1"></i> Periode: <?php echo $nama_bulan . ' ' . $tahun; ?>
			</span>
		</div>
	</div>

	<div class="card shadow mb-4 border-0">
		<div class="card-header bg-modern-blue text-white d-flex flex-row align-items-center justify-content-between" style="border-radius: 10px 10px 0 0;">
			<h6 class="m-0 font-weight-bold"><i class="fas fa-filter mr-2"></i> Filter Periode Penggajian</h6>
		</div>
		<div class="card-body">
			<form method="GET" action="<?php echo base_url('admin/data_penggajian'); ?>" class="form-inline">
				<div class="form-group mb-2 mr-3">
					<label for="bulan" class="font-weight-bold mr-2 text-dark">Bulan:</label>
					<select class="form-control form-control-sm" name="bulan" id="bulan">
						<option value="">-- Pilih Bulan --</option>
						<?php foreach ($daftar_bulan as $k => $v) : ?>
							<option value="<?php echo $k; ?>" <?php echo ($bulan == $k) ? 'selected' : ''; ?>>
								<?php echo $v; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group mb-2 mr-3">
					<label for="tahun" class="font-weight-bold mr-2 text-dark">Tahun:</label>
					<select class="form-control form-control-sm" name="tahun" id="tahun">
						<option value="">-- Pilih Tahun --</option>
						<?php 
						$tahun_sekarang = (int)date('Y');
						for ($i = 2020; $i <= $tahun_sekarang + 3; $i++) : ?>
							<option value="<?php echo $i; ?>" <?php echo ($tahun == $i) ? 'selected' : ''; ?>>
								<?php echo $i; ?>
							</option>
						<?php endfor; ?>
					</select>
				</div>

				<button type="submit" class="btn btn-sm btn-primary mb-2 shadow-sm mr-2">
					<i class="fas fa-search mr-1"></i> Tampilkan Data
				</button>

				<?php if ($jml_data > 0) : ?>
					<a href="<?php echo base_url('admin/data_penggajian/cetak_gaji?bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="btn btn-sm btn-success mb-2 shadow-sm" target="_blank">
						<i class="fas fa-print mr-1"></i> Cetak Daftar Gaji
					</a>
				<?php else : ?>
					<button type="button" class="btn btn-sm btn-outline-secondary mb-2 shadow-sm" disabled>
						<i class="fas fa-print mr-1"></i> Cetak Daftar Gaji
					</button>
				<?php endif; ?>
			</form>
		</div>
	</div>

	<?php if ($jml_data > 0) : ?>
		<div class="row mb-4">
			<div class="col-xl-3 col-md-6 mb-3">
				<div class="card border-left-success shadow-sm h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Take Home Pay</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($kpi['total_thp'], 0, ',', '.'); ?></div>
								<div class="text-xs text-muted mt-1"><?php echo $kpi['total_pegawai_gaji']; ?> Pegawai siap dibayarkan</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-md-6 mb-3">
				<div class="card border-left-primary shadow-sm h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Gaji Pokok & Tunjangan Tetap</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($kpi['total_pokok_tetap'], 0, ',', '.'); ?></div>
								<div class="text-xs text-muted mt-1">Gaji pokok, transport & uang makan</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-wallet fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-md-6 mb-3">
				<div class="card border-left-info shadow-sm h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Upah Lembur & Tunjangan Dinamis</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($kpi['total_variabel'], 0, ',', '.'); ?></div>
								<div class="text-xs text-muted mt-1">Lembur (<?php echo $kpi['total_jam_lembur']; ?> jam) & tunjangan lain</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-clock fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-md-6 mb-3">
				<div class="card border-left-danger shadow-sm h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Potongan Payroll</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($kpi['total_potongan'], 0, ',', '.'); ?></div>
								<div class="text-xs text-muted mt-1">Alpha, potongan dinamis & cicilan kasbon</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card shadow mb-4 border-0">
			<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
				<h6 class="m-0 font-weight-bold text-primary">
					<i class="fas fa-table mr-1"></i> Daftar Gaji Pegawai Periode <?php echo $nama_bulan . ' ' . $tahun; ?>
				</h6>
				<span class="badge badge-primary px-3 py-2">Total <?php echo $jml_data; ?> Pegawai</span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-hover table-striped mb-0 text-sm" id="dataTable" width="100%" cellspacing="0">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" style="width: 40px;">No</th>
								<th>Pegawai</th>
								<th class="text-right">Gaji Pokok</th>
								<th class="text-right">Tj. Transport</th>
								<th class="text-right">Uang Makan</th>
								<th class="text-right">Uang Lembur</th>
								<th class="text-right">Tunjangan Lain</th>
								<th class="text-right">Potongan Alpha</th>
								<th class="text-right">Potongan Lain</th>
								<th class="text-right">Kasbon / Pinjaman</th>
								<th class="text-right">Total Take Home Pay</th>
								<th class="text-center" style="width: 140px;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							foreach ($gaji as $g) : 
								$potongan_alpha = (int)$g->alpha * $alpha_rate;
								$uang_lembur = isset($komponen_per_pegawai[$g->nik]) ? (int)$komponen_per_pegawai[$g->nik]['uang_lembur'] : 0;
								$tj_lain = isset($komponen_per_pegawai[$g->nik]) ? (int)$komponen_per_pegawai[$g->nik]['tunjangan']['total'] : 0;
								$pot_lain = isset($komponen_per_pegawai[$g->nik]) ? (int)$komponen_per_pegawai[$g->nik]['potongan']['total'] : 0;
								$pot_pinjaman = isset($komponen_per_pegawai[$g->nik]) ? (int)$komponen_per_pegawai[$g->nik]['pinjaman']['total'] : 0;
								$total_gaji = (int)$g->gaji_pokok + (int)$g->tj_transport + (int)$g->uang_makan + $uang_lembur + $tj_lain - $potongan_alpha - $pot_lain - $pot_pinjaman;
								
								$photo_url = (!empty($g->photo) && file_exists(FCPATH . 'assets/photo/' . $g->photo)) 
									? base_url('assets/photo/' . $g->photo) 
									: base_url('assets/photo/default.png');
							?>
								<tr>
									<td class="text-center align-middle"><?php echo $no++; ?></td>
									<td class="align-middle">
										<div class="d-flex align-items-center">
											<img src="<?php echo $photo_url; ?>" alt="<?php echo htmlspecialchars($g->nama_pegawai); ?>" class="rounded-circle mr-2 border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;">
											<div>
												<div class="font-weight-bold text-dark"><?php echo htmlspecialchars($g->nama_pegawai); ?></div>
												<div class="text-muted small">
													<span>NIK: <?php echo htmlspecialchars($g->nik); ?></span> | 
													<span class="badge badge-light border"><?php echo htmlspecialchars($g->nama_jabatan); ?></span>
												</div>
											</div>
										</div>
									</td>
									<td class="text-right align-middle font-weight-medium">Rp. <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
									<td class="text-right align-middle text-muted">Rp. <?php echo number_format($g->tj_transport, 0, ',', '.'); ?></td>
									<td class="text-right align-middle text-muted">Rp. <?php echo number_format($g->uang_makan, 0, ',', '.'); ?></td>
									<td class="text-right align-middle">
										<?php if ($uang_lembur > 0) : ?>
											<span class="text-success font-weight-bold">+Rp. <?php echo number_format($uang_lembur, 0, ',', '.'); ?></span>
										<?php else : ?>
											<span class="text-muted">Rp. 0</span>
										<?php endif; ?>
									</td>
									<td class="text-right align-middle">
										<?php if ($tj_lain > 0) : ?>
											<span class="text-success font-weight-bold">+Rp. <?php echo number_format($tj_lain, 0, ',', '.'); ?></span>
										<?php else : ?>
											<span class="text-muted">Rp. 0</span>
										<?php endif; ?>
									</td>
									<td class="text-right align-middle">
										<?php if ($potongan_alpha > 0) : ?>
											<span class="text-danger font-weight-bold">-Rp. <?php echo number_format($potongan_alpha, 0, ',', '.'); ?></span>
											<div class="text-xs text-muted">(<?php echo $g->alpha; ?> hari alpha)</div>
										<?php else : ?>
											<span class="text-muted">Rp. 0</span>
										<?php endif; ?>
									</td>
									<td class="text-right align-middle">
										<?php if ($pot_lain > 0) : ?>
											<span class="text-danger font-weight-bold">-Rp. <?php echo number_format($pot_lain, 0, ',', '.'); ?></span>
										<?php else : ?>
											<span class="text-muted">Rp. 0</span>
										<?php endif; ?>
									</td>
									<td class="text-right align-middle">
										<?php if ($pot_pinjaman > 0) : ?>
											<span class="text-danger font-weight-bold">-Rp. <?php echo number_format($pot_pinjaman, 0, ',', '.'); ?></span>
										<?php else : ?>
											<span class="text-muted">Rp. 0</span>
										<?php endif; ?>
									</td>
									<td class="text-right align-middle font-weight-bold text-success" style="font-size: 0.95rem;">
										Rp. <?php echo number_format($total_gaji, 0, ',', '.'); ?>
									</td>
									<td class="text-center align-middle">
										<div class="btn-group" role="group" aria-label="Aksi Gaji">
											<button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#modalRincian<?php echo $g->nik; ?>" title="Lihat Rincian Gaji">
												<i class="fas fa-list-ul mr-1"></i> Rincian
											</button>
											<a href="<?php echo base_url('admin/slip_gaji/cetak_slip_gaji?nik=' . $g->nik . '&bulan=' . $bulan . '&tahun=' . $tahun); ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Cetak Slip Gaji Pegawai">
												<i class="fas fa-print mr-1"></i> Slip
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<?php foreach ($gaji as $g) : 
			$potongan_alpha = (int)$g->alpha * $alpha_rate;
			$uang_lembur = isset($komponen_per_pegawai[$g->nik]) ? (int)$komponen_per_pegawai[$g->nik]['uang_lembur'] : 0;
			$jam_lembur = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['jam_lembur'] : 0;
			$tj_data = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['tunjangan'] : array('total' => 0, 'detail' => array());
			$pot_data = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['potongan'] : array('total' => 0, 'detail' => array());
			$pinjaman_data = isset($komponen_per_pegawai[$g->nik]) ? $komponen_per_pegawai[$g->nik]['pinjaman'] : array('total' => 0, 'detail' => array());
			
			$subtotal_penerimaan = (int)$g->gaji_pokok + (int)$g->tj_transport + (int)$g->uang_makan + $uang_lembur + (int)$tj_data['total'];
			$subtotal_potongan = $potongan_alpha + (int)$pot_data['total'] + (int)$pinjaman_data['total'];
			$take_home_pay = $subtotal_penerimaan - $subtotal_potongan;
		?>
			<div class="modal fade" id="modalRincian<?php echo $g->nik; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?php echo $g->nik; ?>" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content border-0 shadow-lg">
						<div class="modal-header bg-modern-blue text-white">
							<div>
								<h5 class="modal-title font-weight-bold" id="modalLabel<?php echo $g->nik; ?>">
									<i class="fas fa-receipt mr-2"></i> Rincian Penggajian Pegawai
								</h5>
								<div class="text-xs text-white-50">
									<?php echo htmlspecialchars($g->nama_pegawai); ?> (NIK: <?php echo htmlspecialchars($g->nik); ?>) | Periode: <?php echo $nama_bulan . ' ' . $tahun; ?>
								</div>
							</div>
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body p-4 bg-light">
							<div class="row">
								<div class="col-md-6 mb-3">
									<div class="card border-0 shadow-xs h-100">
										<div class="card-header bg-white font-weight-bold text-success border-bottom py-2">
											<i class="fas fa-plus-circle mr-1"></i> Komponen Penerimaan
										</div>
										<div class="card-body p-3">
											<table class="table table-sm table-borderless mb-0">
												<tbody>
													<tr>
														<td class="text-muted">Gaji Pokok</td>
														<td class="text-right font-weight-medium">Rp. <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
													</tr>
													<tr>
														<td class="text-muted">Tj. Transport</td>
														<td class="text-right font-weight-medium">Rp. <?php echo number_format($g->tj_transport, 0, ',', '.'); ?></td>
													</tr>
													<tr>
														<td class="text-muted">Uang Makan</td>
														<td class="text-right font-weight-medium">Rp. <?php echo number_format($g->uang_makan, 0, ',', '.'); ?></td>
													</tr>
													<tr>
														<td class="text-muted">
															Upah Lembur
															<?php if ($jam_lembur > 0) : ?>
																<span class="badge badge-light border text-xs"><?php echo $jam_lembur; ?> Jam</span>
															<?php endif; ?>
														</td>
														<td class="text-right font-weight-medium">
															<?php if ($uang_lembur > 0) : ?>
																<span class="text-success">+Rp. <?php echo number_format($uang_lembur, 0, ',', '.'); ?></span>
															<?php else : ?>
																<span class="text-muted">Rp. 0</span>
															<?php endif; ?>
														</td>
													</tr>
													<?php if (!empty($tj_data['detail'])) : ?>
														<?php foreach ($tj_data['detail'] as $tj_item) : ?>
															<tr>
																<td class="text-muted">
																	<?php echo htmlspecialchars($tj_item['nama_komponen']); ?>
																	<?php if ($tj_item['is_persentase'] == 1) : ?>
																		<span class="badge badge-light border text-xs">Persentase</span>
																	<?php endif; ?>
																</td>
																<td class="text-right font-weight-medium text-success">
																	+Rp. <?php echo number_format($tj_item['nominal'], 0, ',', '.'); ?>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
												<tfoot class="border-top">
													<tr>
														<th class="font-weight-bold text-dark pt-2">Subtotal Penerimaan</th>
														<th class="text-right font-weight-bold text-success pt-2">
															Rp. <?php echo number_format($subtotal_penerimaan, 0, ',', '.'); ?>
														</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>

								<div class="col-md-6 mb-3">
									<div class="card border-0 shadow-xs h-100">
										<div class="card-header bg-white font-weight-bold text-danger border-bottom py-2">
											<i class="fas fa-minus-circle mr-1"></i> Komponen Potongan
										</div>
										<div class="card-body p-3">
											<table class="table table-sm table-borderless mb-0">
												<tbody>
													<tr>
														<td class="text-muted">
															Potongan Alpha
															<?php if ($g->alpha > 0) : ?>
																<span class="badge badge-light border text-xs"><?php echo $g->alpha; ?> Hari</span>
															<?php endif; ?>
														</td>
														<td class="text-right font-weight-medium">
															<?php if ($potongan_alpha > 0) : ?>
																<span class="text-danger">-Rp. <?php echo number_format($potongan_alpha, 0, ',', '.'); ?></span>
															<?php else : ?>
																<span class="text-muted">Rp. 0</span>
															<?php endif; ?>
														</td>
													</tr>
													<?php if (!empty($pot_data['detail'])) : ?>
														<?php foreach ($pot_data['detail'] as $pot_item) : ?>
															<tr>
																<td class="text-muted">
																	<?php echo htmlspecialchars($pot_item['nama_komponen']); ?>
																	<?php if ($pot_item['is_persentase'] == 1) : ?>
																		<span class="badge badge-light border text-xs">Persentase</span>
																	<?php endif; ?>
																</td>
																<td class="text-right font-weight-medium text-danger">
																	-Rp. <?php echo number_format($pot_item['nominal'], 0, ',', '.'); ?>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
													<?php if (!empty($pinjaman_data['detail'])) : ?>
														<?php foreach ($pinjaman_data['detail'] as $pinjam_item) : ?>
															<tr>
																<td class="text-muted">
																	<?php echo htmlspecialchars($pinjam_item['keterangan']); ?>
																</td>
																<td class="text-right font-weight-medium text-danger">
																	-Rp. <?php echo number_format($pinjam_item['nominal'], 0, ',', '.'); ?>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
													<?php if ($potongan_alpha == 0 && empty($pot_data['detail']) && empty($pinjaman_data['detail'])) : ?>
														<tr>
															<td colspan="2" class="text-muted text-center py-2">Tidak ada potongan pada periode ini.</td>
														</tr>
													<?php endif; ?>
												</tbody>
												<tfoot class="border-top">
													<tr>
														<th class="font-weight-bold text-dark pt-2">Subtotal Potongan</th>
														<th class="text-right font-weight-bold text-danger pt-2">
															-Rp. <?php echo number_format($subtotal_potongan, 0, ',', '.'); ?>
														</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="card border-success bg-white shadow-xs">
								<div class="card-body p-3 d-flex flex-column flex-sm-row justify-content-between align-items-center">
									<div>
										<div class="text-xs font-weight-bold text-success text-uppercase">Take Home Pay (Gaji Bersih)</div>
										<div class="text-muted small">Hak bersih yang ditransfer kepada pegawai</div>
									</div>
									<div class="text-right mt-2 mt-sm-0">
										<div class="h4 font-weight-bold text-success mb-0">Rp. <?php echo number_format($take_home_pay, 0, ',', '.'); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer bg-white border-top">
							<a href="<?php echo base_url('admin/slip_gaji/cetak_slip_gaji?nik=' . $g->nik . '&bulan=' . $bulan . '&tahun=' . $tahun); ?>" target="_blank" class="btn btn-primary shadow-sm">
								<i class="fas fa-print mr-1"></i> Cetak Slip Resmi
							</a>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	<?php else : ?>
		<div class="card shadow-sm border-0 mb-4">
			<div class="card-body text-center py-5">
				<div class="mb-3">
					<div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 80px; height: 80px;">
						<i class="fas fa-calendar-times text-secondary fa-3x"></i>
					</div>
				</div>
				<h5 class="font-weight-bold text-dark mb-2">Data Gaji Periode Ini Belum Tersedia</h5>
				<p class="text-muted mb-4 max-w-lg mx-auto" style="max-width: 520px;">
					Sistem penggajian membutuhkan data absensi pegawai untuk periode <strong><?php echo $nama_bulan . ' ' . $tahun; ?></strong>. Silakan input kehadiran pegawai terlebih dahulu untuk mengaktifkan perhitungan gaji.
				</p>
				<div class="d-flex justify-content-center">
					<a href="<?php echo base_url('admin/data_absensi/input_absensi'); ?>" class="btn btn-primary shadow-sm px-4">
						<i class="fas fa-user-check mr-2"></i> Input Data Kehadiran Pegawai
					</a>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>