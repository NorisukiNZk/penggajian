<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Header & Action Button -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 font-weight-bold text-gray-800">
                <i class="fas fa-hand-holding-dollar text-primary mr-2"></i><?php echo $title; ?>
            </h1>
            <p class="text-muted small mb-0">Kelola fasilitas kasbon & pinjaman resmi pegawai Klinik Pratama Hidayatullah.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="<?php echo base_url('pegawai/pinjaman/tambah'); ?>" class="btn btn-primary btn-sm px-3 py-2 font-weight-bold shadow-sm rounded-pill">
                <i class="fas fa-plus-circle mr-1"></i> Ajukan Pinjaman Baru
            </a>
        </div>
    </div>

    <!-- Flash Message Session -->
    <?php echo $this->session->flashdata('pesan'); ?>

    <!-- 4 Executive KPI Cards -->
    <div class="row mb-4">
        <!-- Total Diajukan -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #0284c7 !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Riwayat</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo isset($kpi_total) ? $kpi_total : count($pinjaman); ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light text-primary">
                                <i class="fas fa-file-invoice-dollar fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi HRD -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #f59e0b !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Review</div>
                            <div class="h4 mb-0 font-weight-bold text-warning"><?php echo isset($kpi_pending) ? $kpi_pending : 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light text-warning">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pinjaman Aktif Berjalan -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #10b981 !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pinjaman Aktif</div>
                            <div class="h4 mb-0 font-weight-bold text-success"><?php echo isset($kpi_aktif) ? $kpi_aktif : 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light text-success">
                                <i class="fas fa-wallet fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pinjaman Lunas -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #6366f1 !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-indigo text-uppercase mb-1" style="color: #6366f1;">Pinjaman Lunas</div>
                            <div class="h4 mb-0 font-weight-bold" style="color: #6366f1;"><?php echo isset($kpi_lunas) ? $kpi_lunas : 0; ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light" style="color: #6366f1;">
                                <i class="fas fa-circle-check fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pinjaman Table Card -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-transparent border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-check mr-2"></i>Daftar Pengajuan Pinjaman & Kasbon Pegawai
            </h6>
            <span class="badge badge-light border text-muted px-2 py-1 small">
                Payroll Deduction System
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 4%;">No</th>
                            <th style="width: 14%;">Tanggal Pengajuan</th>
                            <th style="width: 18%;">Nominal & Tenor</th>
                            <th style="width: 16%;">Skema Cicilan / Bln</th>
                            <th style="width: 18%;">Alasan & Kontak Penjamin</th>
                            <th class="text-center" style="width: 12%;">Status</th>
                            <th class="text-center" style="width: 18%;">Aksi & Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pinjaman)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-hand-holding-dollar fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada riwayat pengajuan pinjaman kasbon.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach($pinjaman as $p) : 
                                $cicilan = ceil($p->jumlah_pinjaman / $p->tenor_bulan);
                            ?>
                            <tr>
                                <td class="text-center font-weight-bold text-muted"><?php echo $no++; ?></td>
                                
                                <!-- Tanggal Pengajuan -->
                                <td>
                                    <div class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-day text-info mr-1"></i>
                                        <?php echo date('d M Y', strtotime($p->tgl_pengajuan)); ?>
                                    </div>
                                    <small class="text-muted">Kode: #PINJ-<?php echo sprintf('%04d', $p->id_pinjaman); ?></small>
                                </td>

                                <!-- Nominal & Tenor -->
                                <td>
                                    <div class="h6 mb-1 font-weight-bold text-primary">
                                        Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?>
                                    </div>
                                    <div>
                                        <span class="badge badge-info px-2 py-1">
                                            <i class="fas fa-clock mr-1"></i>Tenor: <?php echo $p->tenor_bulan; ?> Bulan
                                        </span>
                                    </div>
                                </td>

                                <!-- Cicilan & Sisa -->
                                <td>
                                    <div class="font-weight-bold text-danger mb-1" style="font-size: 0.95rem;">
                                        Rp <?php echo number_format($cicilan, 0, ',', '.'); ?> <span class="small font-weight-normal text-muted">/bln</span>
                                    </div>
                                    <?php if ($p->status == 'Disetujui') : ?>
                                        <div class="small text-muted">
                                            Sisa Tenor: <strong><?php echo isset($p->sisa_tenor) ? $p->sisa_tenor : $p->tenor_bulan; ?> Bln</strong>
                                        </div>
                                    <?php elseif ($p->status == 'Lunas') : ?>
                                        <span class="badge badge-success px-2 py-1 text-uppercase font-weight-bold">
                                            <i class="fas fa-check-double mr-1"></i>Lunas Penuh
                                        </span>
                                    <?php else : ?>
                                        <span class="text-muted small">Belum aktif</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Alasan & Kontak Penjamin -->
                                <td>
                                    <div class="text-dark small mb-1">
                                        <strong>Alasan:</strong> <?php echo htmlspecialchars($p->alasan, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                    <?php if (!empty($p->kontak_darurat_nama)) : ?>
                                        <div class="small bg-light p-1 rounded border">
                                            <i class="fas fa-user-shield text-info mr-1"></i>
                                            <strong>Penjamin:</strong> <?php echo htmlspecialchars($p->kontak_darurat_nama, ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($p->kontak_darurat_hubungan, ENT_QUOTES, 'UTF-8'); ?>)
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    <?php if ($p->status == 'Pending') : ?>
                                        <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em;">
                                            <i class="fas fa-clock mr-1"></i>Pending Review
                                        </span>
                                    <?php elseif ($p->status == 'Disetujui') : ?>
                                        <span class="badge badge-success px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em;">
                                            <i class="fas fa-circle-check mr-1"></i>Aktif / Disetujui
                                        </span>
                                        <?php if (!empty($p->tgl_disetujui)) : ?>
                                            <div class="text-xs text-muted mt-1">Disetujui: <?php echo date('d/m/Y', strtotime($p->tgl_disetujui)); ?></div>
                                        <?php endif; ?>
                                    <?php elseif ($p->status == 'Lunas') : ?>
                                        <span class="badge badge-primary px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em; background-color: #6366f1;">
                                            <i class="fas fa-check-double mr-1"></i>Lunas
                                        </span>
                                    <?php else : ?>
                                        <span class="badge badge-danger px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em;">
                                            <i class="fas fa-circle-xmark mr-1"></i>Ditolak
                                        </span>
                                    <?php endif; ?>

                                    <?php if (!empty($p->pesan_admin)) : ?>
                                        <div class="text-muted small mt-1 font-italic">
                                            "<?php echo htmlspecialchars($p->pesan_admin, ENT_QUOTES, 'UTF-8'); ?>"
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Aksi & Dokumen -->
                                <td class="text-center">
                                    <div class="d-inline-flex flex-column gap-1 w-100">
                                        <?php if ($p->status == 'Pending') : ?>
                                            <a href="<?php echo base_url('pegawai/pinjaman/batal/' . $p->id_pinjaman); ?>" 
                                               class="btn btn-sm btn-outline-danger btn-batal-pinjaman shadow-sm" 
                                               title="Batalkan Pengajuan"
                                               data-nominal="Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?>">
                                                <i class="fas fa-trash-alt mr-1"></i> Batalkan
                                            </a>
                                        <?php elseif ($p->status == 'Disetujui' || $p->status == 'Lunas') : ?>
                                            <a href="<?php echo base_url('pegawai/pinjaman/cetak_sppk/' . $p->id_pinjaman); ?>" 
                                               target="_blank"
                                               class="btn btn-sm btn-outline-success font-weight-bold shadow-sm mb-1" 
                                               title="Cetak Surat Perjanjian Pinjaman Karyawan">
                                                <i class="fas fa-print mr-1"></i> Cetak SPPK
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-sm btn-light border text-muted" disabled>
                                                <i class="fas fa-ban mr-1"></i> Tutup
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- SweetAlert2 Script untuk Pembatalan Mandiri -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on('click', '.btn-batal-pinjaman', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const nominal = $(this).data('nominal') || 'pinjaman ini';
        const isDark = document.body.classList.contains('dark-mode');

        Swal.fire({
            title: 'Batalkan Pengajuan Pinjaman?',
            html: `Apakah Anda yakin ingin membatalkan pengajuan pinjaman sebesar <span class="badge badge-light border text-danger font-weight-bold px-2 py-1 mx-1">${nominal}</span>? Berkas pengajuan akan ditarik dari antrean HRD.`,
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i> Ya, Batalkan!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i> Tutup',
            customClass: {
                popup: 'swal2-modern-popup',
                confirmButton: 'btn btn-danger px-4 py-2 font-weight-bold shadow-sm',
                cancelButton: 'btn btn-light border px-4 py-2 shadow-sm'
            },
            buttonsStyling: false,
            reverseButtons: true,
            background: isDark ? '#1e293b' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });
});
</script>
