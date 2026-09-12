<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<div>
			<h1 class="h3 mb-1 text-gray-800 font-weight-bold"><?php echo $title ?></h1>
			<p class="text-muted small mb-0">Kelola komponen tunjangan remunerasi, potongan rutin, dan tarif denda absensi.</p>
		</div>
	</div>

	<?php echo $this->session->flashdata('pesan') ?>

	<!-- Navigasi Tab Terpadu -->
	<div class="mb-4">
		<ul class="nav nav-pills custom-payroll-tabs" id="payrollTabs" role="tablist">
			<li class="nav-item mr-2" role="presentation">
				<a class="nav-link <?php echo ($active_tab != 'potongan') ? 'active' : ''; ?> px-4 py-2 font-weight-bold" id="tab-komponen-btn" data-toggle="pill" href="#tab-komponen" role="tab" aria-controls="tab-komponen" aria-selected="<?php echo ($active_tab != 'potongan') ? 'true' : 'false'; ?>">
					<i class="fas fa-sliders-h mr-2"></i>Komponen Remunerasi
					<span class="badge badge-light ml-2 font-weight-normal"><?php echo count($komponen); ?></span>
				</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link <?php echo ($active_tab == 'potongan') ? 'active' : ''; ?> px-4 py-2 font-weight-bold" id="tab-potongan-btn" data-toggle="pill" href="#tab-potongan" role="tab" aria-controls="tab-potongan" aria-selected="<?php echo ($active_tab == 'potongan') ? 'true' : 'false'; ?>">
					<i class="fas fa-calendar-times mr-2"></i>Tarif Penalti Absensi
					<span class="badge badge-light ml-2 font-weight-normal"><?php echo count($pot_gaji); ?></span>
				</a>
			</li>
		</ul>
	</div>

	<!-- Konten Tab -->
	<div class="tab-content" id="payrollTabContent">

		<!-- TAB 1: KOMPONEN REMUNERASI -->
		<div class="tab-pane fade <?php echo ($active_tab != 'potongan') ? 'show active' : ''; ?>" id="tab-komponen" role="tabpanel" aria-labelledby="tab-komponen-btn">
			
			<!-- Summary Cards -->
			<div class="row mb-4">
				<div class="col-md-6 mb-3 mb-md-0">
					<div class="card border-left-success shadow-sm h-100">
						<div class="card-body py-3">
							<div class="d-flex align-items-center justify-content-between">
								<div>
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tunjangan Remunerasi Aktif</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
										$total_tunjangan = 0;
										foreach ($komponen as $k) {
											if ($k->tipe == 'tunjangan' && $k->is_aktif == 1) $total_tunjangan++;
										}
										echo $total_tunjangan;
										?> Komponen
									</div>
								</div>
								<div class="rounded-circle p-3 bg-success text-white" style="opacity: 0.85;">
									<i class="fas fa-plus-circle fa-lg"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card border-left-danger shadow-sm h-100">
						<div class="card-body py-3">
							<div class="d-flex align-items-center justify-content-between">
								<div>
									<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Potongan Rutin / BPJS Aktif</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800">
										<?php 
										$total_potongan = 0;
										foreach ($komponen as $k) {
											if ($k->tipe == 'potongan' && $k->is_aktif == 1) $total_potongan++;
										}
										echo $total_potongan;
										?> Komponen
									</div>
								</div>
								<div class="rounded-circle p-3 bg-danger text-white" style="opacity: 0.85;">
									<i class="fas fa-minus-circle fa-lg"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Tabel Komponen Remunerasi -->
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
					<h6 class="m-0 font-weight-bold text-primary">
						<i class="fas fa-list-ul mr-1"></i> Daftar Komponen Tunjangan & Potongan
					</h6>
					<a href="<?php echo base_url('admin/komponen_gaji/tambah') ?>" class="btn btn-sm btn-primary shadow-sm font-weight-bold">
						<i class="fas fa-plus mr-1"></i> Tambah Komponen Baru
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
							<thead class="thead-dark">
								<tr>
									<th class="text-center" width="5%">No</th>
									<th class="text-center">Nama Komponen</th>
									<th class="text-center" width="12%">Tipe</th>
									<th class="text-center" width="16%">Besaran</th>
									<th class="text-center" width="12%">Perhitungan</th>
									<th class="text-center" width="10%">Status</th>
									<th class="text-center" width="20%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($komponen)) : ?>
									<?php $no = 1; foreach ($komponen as $k) : ?>
									<tr>
										<td class="text-center align-middle font-weight-bold"><?php echo $no++ ?></td>
										<td class="align-middle font-weight-bold text-dark"><?php echo htmlspecialchars($k->nama_komponen, ENT_QUOTES, 'UTF-8') ?></td>
										<td class="text-center align-middle">
											<?php if ($k->tipe == 'tunjangan') : ?>
												<span class="badge badge-success px-2 py-1"><i class="fas fa-plus-circle mr-1"></i> Tunjangan</span>
											<?php else : ?>
												<span class="badge badge-danger px-2 py-1"><i class="fas fa-minus-circle mr-1"></i> Potongan</span>
											<?php endif; ?>
										</td>
										<td class="text-center align-middle font-weight-bold">
											<?php if ($k->is_persentase == 1) : ?>
												<span class="text-info"><?php echo $k->nominal ?>% dari Gaji Pokok</span>
											<?php else : ?>
												<span>Rp <?php echo number_format($k->nominal, 0, ',', '.') ?></span>
											<?php endif; ?>
										</td>
										<td class="text-center align-middle">
											<?php if ($k->is_persentase == 1) : ?>
												<span class="badge badge-info">Persentase</span>
											<?php else : ?>
												<span class="badge badge-secondary">Nominal Tetap</span>
											<?php endif; ?>
										</td>
										<td class="text-center align-middle">
											<a href="<?php echo base_url('admin/komponen_gaji/toggle/' . $k->id_komponen) ?>" 
											   class="btn btn-sm <?php echo ($k->is_aktif == 1) ? 'btn-success' : 'btn-secondary' ?>"
											   title="Klik untuk mengubah status aktif">
												<?php echo ($k->is_aktif == 1) ? '<i class="fas fa-check mr-1"></i> Aktif' : '<i class="fas fa-times mr-1"></i> Nonaktif' ?>
											</a>
										</td>
										<td class="text-center align-middle">
											<div class="btn-group btn-group-sm" role="group">
												<a href="<?php echo base_url('admin/komponen_gaji/edit/' . $k->id_komponen) ?>" class="btn btn-warning" title="Edit Komponen">
													<i class="fas fa-edit mr-1"></i> Edit
												</a>
												<a href="<?php echo base_url('admin/komponen_gaji/kelola_pegawai/' . $k->id_komponen) ?>" class="btn btn-info" title="Kelola Penyesuaian per Pegawai">
													<i class="fas fa-users mr-1"></i> Pegawai
												</a>
												<a href="<?php echo base_url('admin/komponen_gaji/hapus/' . $k->id_komponen) ?>" class="btn btn-danger btn-hapus" title="Hapus Komponen" data-nama="<?php echo htmlspecialchars($k->nama_komponen, ENT_QUOTES, 'UTF-8') ?>">
													<i class="fas fa-trash"></i>
												</a>
											</div>
										</td>
									</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="7" class="text-center py-4 text-muted">
											<i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
											Belum ada komponen gaji terdaftar. Klik tombol Tambah Komponen Baru untuk menambahkan.
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- TAB 2: TARIF PENALTI ABSENSI (ALPHA) -->
		<div class="tab-pane fade <?php echo ($active_tab == 'potongan') ? 'show active' : ''; ?>" id="tab-potongan" role="tabpanel" aria-labelledby="tab-potongan-btn">
			
			<!-- Penjelasan Penalti Absensi -->
			<div class="alert alert-info border-left-info shadow-sm mb-4">
				<div class="d-flex align-items-center">
					<i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
					<div>
						<h6 class="font-weight-bold mb-1">Mekanisme Penalti Absensi</h6>
						<p class="mb-0 small">
							Tarif denda di bawah ini secara otomatis memotong gaji bersih pegawai berdasarkan jumlah hari ketidakhadiran <strong>Alpha (Mangkir)</strong> pada rekap presensi bulanan:
							<span class="font-weight-bold ml-1">Potongan = Jumlah Hari Alpha &times; Tarif Denda</span>.
						</p>
					</div>
				</div>
			</div>

			<!-- Tabel Tarif Penalti Absensi -->
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
					<h6 class="m-0 font-weight-bold text-primary">
						<i class="fas fa-calendar-times mr-1"></i> Daftar Tarif Penalti Absensi
					</h6>
					<button class="btn btn-sm btn-primary shadow-sm font-weight-bold" data-toggle="modal" data-target="#tambahModalPotongan">
						<i class="fas fa-plus mr-1"></i> Tambah Tarif Penalti
					</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataTablePotongan" width="100%" cellspacing="0">
							<thead class="thead-dark">
								<tr>
									<th class="text-center" width="8%">No</th>
									<th class="text-center">Nama Potongan / Denda</th>
									<th class="text-center" width="30%">Besaran Potongan per Hari</th>
									<th class="text-center" width="20%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($pot_gaji)) : ?>
									<?php $no = 1; foreach ($pot_gaji as $p) : ?>
									<tr>
										<td class="text-center align-middle font-weight-bold"><?php echo $no++ ?></td>
										<td class="align-middle font-weight-bold text-dark">
											<?php echo htmlspecialchars($p->potongan, ENT_QUOTES, 'UTF-8') ?>
											<?php if (strtolower($p->potongan) == 'alpha') : ?>
												<span class="badge badge-warning ml-2 font-weight-normal"><i class="fas fa-star mr-1"></i>Utama</span>
											<?php endif; ?>
										</td>
										<td class="text-center align-middle font-weight-bold text-danger">
											Rp <?php echo number_format($p->jml_potongan, 0, ',', '.') ?>
										</td>
										<td class="text-center align-middle">
											<div class="btn-group btn-group-sm" role="group">
												<button class="btn btn-warning" data-toggle="modal" data-target="#editModalPotongan<?php echo $p->id ?>" title="Edit Tarif">
													<i class="fas fa-edit mr-1"></i> Edit
												</button>
												<a class="btn btn-danger btn-hapus" href="<?php echo base_url('admin/komponen_gaji/delete_potongan/' . $p->id) ?>" data-nama="<?php echo htmlspecialchars($p->potongan, ENT_QUOTES, 'UTF-8') ?>" title="Hapus Tarif">
													<i class="fas fa-trash"></i>
												</a>
											</div>
										</td>
									</tr>

									<!-- Modal Edit Potongan -->
									<div class="modal fade" id="editModalPotongan<?php echo $p->id ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?php echo $p->id ?>" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title font-weight-bold" id="modalLabel<?php echo $p->id ?>">Update Tarif Penalti Absensi</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?php echo base_url('admin/komponen_gaji/update_potongan_aksi') ?>" method="POST">
													<div class="modal-body">
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
														<input type="hidden" name="id" value="<?php echo $p->id ?>">

														<div class="form-group">
															<label class="font-weight-bold text-dark">Nama Potongan</label>
															<input type="text" name="potongan" class="form-control" value="<?php echo htmlspecialchars($p->potongan) ?>" placeholder="Contoh: Alpha" required>
															<small class="form-text text-muted">Gunakan nama "Alpha" untuk penalti hari mangkir otomatis.</small>
														</div>

														<div class="form-group">
															<label class="font-weight-bold text-dark">Besaran Potongan per Hari (Rp)</label>
															<input type="number" name="jml_potongan" class="form-control" value="<?php echo htmlspecialchars($p->jml_potongan) ?>" placeholder="Contoh: 100000" min="0" required>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
														<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="4" class="text-center py-4 text-muted">
											<i class="fas fa-calendar-times fa-2x mb-2 d-block text-secondary"></i>
											Belum ada data tarif denda absensi. Klik tombol Tambah Tarif Penalti untuk menambahkan.
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Potongan Absensi -->
<div class="modal fade" id="tambahModalPotongan" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-bold" id="modalTambahLabel">Tambah Tarif Penalti Absensi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo base_url('admin/komponen_gaji/tambah_potongan_aksi') ?>" method="POST">
				<div class="modal-body">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

					<div class="form-group">
						<label class="font-weight-bold text-dark">Nama Potongan</label>
						<input type="text" name="potongan" class="form-control" placeholder="Contoh: Alpha" required>
						<small class="form-text text-muted">Gunakan nama "Alpha" untuk memotong otomatis saat pegawai tidak hadir tanpa keterangan.</small>
					</div>

					<div class="form-group">
						<label class="font-weight-bold text-dark">Besaran Potongan per Hari (Rp)</label>
						<input type="number" name="jml_potongan" class="form-control" placeholder="Contoh: 100000" min="0" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan Tarif</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
.custom-payroll-tabs {
	background: rgba(0, 0, 0, 0.04);
	padding: 6px;
	border-radius: 12px;
	display: inline-flex;
	border: 1px solid rgba(0, 0, 0, 0.08);
}
.custom-payroll-tabs .nav-link {
	color: #475569;
	border-radius: 8px;
	transition: all 0.2s ease;
}
.custom-payroll-tabs .nav-link:hover {
	color: #0284c7;
	background: rgba(14, 165, 233, 0.08);
}
.custom-payroll-tabs .nav-link.active {
	color: #ffffff !important;
	background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
	box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
}
.custom-payroll-tabs .nav-link.active .badge {
	background: rgba(255, 255, 255, 0.25);
	color: #ffffff;
}
body.dark-mode .custom-payroll-tabs {
	background: rgba(255, 255, 255, 0.05);
	border-color: rgba(255, 255, 255, 0.1);
}
body.dark-mode .custom-payroll-tabs .nav-link {
	color: #94a3b8;
}
body.dark-mode .custom-payroll-tabs .nav-link:hover {
	color: #38bdf8;
	background: rgba(56, 189, 248, 0.12);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Inisialisasi DataTable untuk tabel kedua jika ada
	if (window.jQuery && jQuery.fn.DataTable) {
		if (jQuery('#dataTablePotongan').length > 0 && !jQuery.fn.DataTable.isDataTable('#dataTablePotongan')) {
			jQuery('#dataTablePotongan').DataTable({
				responsive: true,
				pageLength: 10,
				language: {
					search: "",
					searchPlaceholder: "🔍 Cari data tarif...",
					lengthMenu: "Tampilkan _MENU_ baris",
					info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
					infoEmpty: "Menampilkan 0 entri",
					infoFiltered: "(filter dari _MAX_ total data)",
					zeroRecords: "Data tidak ditemukan",
					paginate: {
						first: '<i class="fas fa-angles-left"></i>',
						previous: '<i class="fas fa-angle-left"></i>',
						next: '<i class="fas fa-angle-right"></i>',
						last: '<i class="fas fa-angles-right"></i>'
					}
				}
			});
		}
	}

	// Sinkronisasi Tab dengan URL
	if (window.jQuery) {
		jQuery('#payrollTabs a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
			var target = jQuery(e.target).attr('href');
			var tabName = (target === '#tab-potongan') ? 'potongan' : 'komponen';
			if (window.history.replaceState) {
				var newUrl = window.location.pathname + '?tab=' + tabName;
				window.history.replaceState({path: newUrl}, '', newUrl);
			}
			// Sesuaikan kalkulasi lebar kolom DataTables saat tab aktif berganti
			if (jQuery.fn.DataTable) {
				jQuery(jQuery.fn.dataTable.tables(true)).DataTable().columns.adjust();
			}
		});

		// Cek hash atau parameter tab saat load
		var urlParams = new URLSearchParams(window.location.search);
		var tabParam = urlParams.get('tab');
		if (tabParam === 'potongan' || window.location.hash === '#potongan') {
			jQuery('#tab-potongan-btn').tab('show');
		}
	}
});
</script>
