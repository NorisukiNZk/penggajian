<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 font-weight-bold text-gray-800">
                <i class="fas fa-hand-holding-dollar text-primary mr-2"></i><?php echo $title; ?>
            </h1>
            <p class="text-muted small mb-0">Verifikasi, analisis kelayakan kredit kasbon, dan pemantauan cicilan payroll pegawai.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <span class="badge badge-light border text-muted px-3 py-2 font-weight-bold shadow-sm">
                <i class="fas fa-shield-alt text-success mr-1"></i> Sistem Mitigasi Risiko Kredit
            </span>
        </div>
    </div>

    <!-- Flash Message Session -->
    <?php echo $this->session->flashdata('pesan'); ?>

    <!-- 4 Executive KPI Cards -->
    <div class="row mb-4">
        <!-- Total Dana Diberikan -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #0284c7 !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Dana Kasbon</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($kpi_total_dana, 0, ',', '.'); ?></div>
                            <small class="text-muted"><?php echo $kpi_total; ?> total pengajuan</small>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light text-primary">
                                <i class="fas fa-sack-dollar fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi (Pending) -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #f59e0b !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Review</div>
                            <div class="h4 mb-0 font-weight-bold text-warning"><?php echo isset($kpi_pending) ? $kpi_pending : 0; ?></div>
                            <small class="text-muted">Perlu tindakan HRD</small>
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

        <!-- Pinjaman Berjalan (Aktif) -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-lg" style="border-left: 4px solid #10b981 !important; background: var(--card-bg, #ffffff);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pinjaman Aktif</div>
                            <div class="h4 mb-0 font-weight-bold text-success"><?php echo isset($kpi_aktif) ? $kpi_aktif : 0; ?></div>
                            <small class="text-muted">Sedang dipotong payroll</small>
                        </div>
                        <div class="col-auto">
                            <div class="p-2 rounded-circle bg-light text-success">
                                <i class="fas fa-arrows-spin fa-lg"></i>
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
                            <small class="text-muted">Kewajiban selesai</small>
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
                Prioritas Antrean Pending
            </span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 4%;">No</th>
                            <th style="width: 18%;">Pegawai & Masa Kerja</th>
                            <th style="width: 15%;">Detail Kasbon</th>
                            <th style="width: 15%;">Cicilan & Beban Gaji</th>
                            <th style="width: 18%;">Berkas & Penjamin</th>
                            <th class="text-center" style="width: 12%;">Status</th>
                            <th class="text-center" style="width: 18%;">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pinjaman)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                    Belum ada data pengajuan pinjaman karyawan.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach($pinjaman as $p) : 
                                $cicilan = ceil($p->jumlah_pinjaman / $p->tenor_bulan);
                                $total_gaji = floatval($p->gaji_pokok) + floatval($p->tj_transport) + floatval($p->uang_makan);
                                $dsr = $total_gaji > 0 ? round(($cicilan / $total_gaji) * 100, 1) : 0;

                                // Hitung masa kerja
                                $tgl_masuk = new DateTime($p->tanggal_masuk);
                                $diff = $tgl_masuk->diff(new DateTime());
                            ?>
                            <tr class="<?php echo ($p->status == 'Pending') ? 'table-warning-light' : ''; ?>">
                                <!-- No -->
                                <td class="text-center font-weight-bold text-muted"><?php echo $no++; ?></td>
                                
                                <!-- Pegawai & Masa Kerja -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <?php if (!empty($p->photo) && file_exists(FCPATH . 'photo/' . $p->photo)) : ?>
                                                <img src="<?php echo base_url('photo/' . $p->photo); ?>" alt="Photo" style="width: 42px; height: 42px; object-fit: cover; border-radius: 50%;" class="border">
                                            <?php else : ?>
                                                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center border" style="width: 42px; height: 42px; font-weight: bold;">
                                                    <?php echo strtoupper(substr($p->nama_pegawai, 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong class="text-gray-900 d-block" style="font-size: 0.95rem;"><?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong>
                                            <span class="badge badge-light border text-primary small">NIK: <?php echo htmlspecialchars($p->nik, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <small class="text-muted d-block"><?php echo htmlspecialchars($p->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></small>
                                            <span class="badge badge-pill badge-light border text-muted small mt-1">
                                                <i class="fas fa-history mr-1"></i><?php echo $diff->y; ?> Thn <?php echo $diff->m; ?> Bln
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Detail Kasbon -->
                                <td>
                                    <div class="h6 mb-1 font-weight-bold text-primary">
                                        Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?>
                                    </div>
                                    <div>
                                        <span class="badge badge-info px-2 py-1">
                                            <i class="fas fa-clock mr-1"></i>Tenor: <?php echo $p->tenor_bulan; ?> Bln
                                        </span>
                                    </div>
                                    <small class="text-muted d-block mt-1">Diajukan: <?php echo date('d/m/Y', strtotime($p->tgl_pengajuan)); ?></small>
                                </td>

                                <!-- Cicilan & Rasio Beban DSR -->
                                <td>
                                    <div class="font-weight-bold text-danger mb-1">
                                        Rp <?php echo number_format($cicilan, 0, ',', '.'); ?> <span class="small font-weight-normal text-muted">/bln</span>
                                    </div>
                                    <div class="small mb-1">
                                        Rasio Beban: 
                                        <?php if ($dsr <= 25) : ?>
                                            <span class="badge badge-success"><?php echo $dsr; ?>% (Aman)</span>
                                        <?php elseif ($dsr <= 40) : ?>
                                            <span class="badge badge-warning text-dark"><?php echo $dsr; ?>% (Wajar)</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger"><?php echo $dsr; ?>% (Tinggi)</span>
                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted">Gaji: Rp <?php echo number_format($p->gaji_pokok, 0, ',', '.'); ?></small>
                                </td>

                                <!-- Berkas Identitas & Penjamin -->
                                <td>
                                    <div class="mb-2">
                                        <!-- Pratinjau KTP -->
                                        <?php if (!empty($p->file_ktp)) : ?>
                                            <a href="<?php echo base_url('uploads/pinjaman/' . $p->file_ktp); ?>" target="_blank" class="btn btn-xs btn-outline-primary py-1 px-2 mb-1" style="font-size: 0.78rem;">
                                                <i class="fas fa-id-card mr-1"></i> Foto KTP
                                            </a>
                                        <?php else : ?>
                                            <span class="badge badge-light border text-muted small">No KTP</span>
                                        <?php endif; ?>

                                        <!-- Pratinjau Dokumen Jaminan -->
                                        <?php if (!empty($p->file_jaminan)) : ?>
                                            <a href="<?php echo base_url('uploads/pinjaman/' . $p->file_jaminan); ?>" target="_blank" class="btn btn-xs btn-outline-warning text-dark py-1 px-2 mb-1" style="font-size: 0.78rem;">
                                                <i class="fas fa-award mr-1"></i> Jaminan/Ijazah
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Kontak Darurat -->
                                    <?php if (!empty($p->kontak_darurat_nama)) : ?>
                                        <div class="small p-1 bg-light rounded border text-muted" style="line-height: 1.3;">
                                            <i class="fas fa-user-shield text-info mr-1"></i>
                                            <strong><?php echo htmlspecialchars($p->kontak_darurat_nama, ENT_QUOTES, 'UTF-8'); ?></strong> (<?php echo htmlspecialchars($p->kontak_darurat_hubungan, ENT_QUOTES, 'UTF-8'); ?>)<br>
                                            <i class="fas fa-phone mr-1"></i><?php echo htmlspecialchars($p->kontak_darurat_hp, ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    <?php if ($p->status == 'Pending') : ?>
                                        <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em;">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    <?php elseif ($p->status == 'Disetujui') : ?>
                                        <span class="badge badge-success px-2 py-1 font-weight-bold shadow-sm" style="font-size: 0.85em;">
                                            <i class="fas fa-circle-check mr-1"></i>Disetujui
                                        </span>
                                        <div class="text-xs text-muted mt-1">Sisa: <?php echo isset($p->sisa_tenor) ? $p->sisa_tenor : $p->tenor_bulan; ?> Bln</div>
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

                                <!-- Aksi HRD (SweetAlert2 Modals) -->
                                <td class="text-center">
                                    <div class="d-inline-flex flex-column gap-1 w-100">
                                        <?php if ($p->status == 'Pending') : ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-success btn-approve-pinjaman btn-block font-weight-bold mb-1 shadow-sm"
                                                    data-id="<?php echo $p->id_pinjaman; ?>"
                                                    data-nama="<?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                                                    data-nominal="Rp <?php echo number_format($p->jumlah_pinjaman, 0, ',', '.'); ?>"
                                                    data-tenor="<?php echo $p->tenor_bulan; ?> Bulan"
                                                    data-cicilan="Rp <?php echo number_format($cicilan, 0, ',', '.'); ?> /bln"
                                                    data-dsr="<?php echo $dsr; ?>%">
                                                <i class="fas fa-check mr-1"></i> Setujui Kasbon
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger btn-reject-pinjaman btn-block font-weight-bold shadow-sm"
                                                    data-id="<?php echo $p->id_pinjaman; ?>"
                                                    data-nama="<?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>">
                                                <i class="fas fa-times mr-1"></i> Tolak
                                            </button>
                                        <?php elseif ($p->status == 'Disetujui') : ?>
                                            <a href="<?php echo base_url('admin/pinjaman/cetak_sppk/' . $p->id_pinjaman); ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary btn-block py-1 mb-1 font-weight-bold shadow-sm"
                                               title="Cetak Surat Perjanjian Pinjaman Karyawan">
                                                <i class="fas fa-print mr-1"></i> Cetak SPPK
                                            </a>
                                            <a href="<?php echo base_url('admin/pinjaman/lunas/' . $p->id_pinjaman); ?>" 
                                               class="btn btn-sm btn-outline-success btn-lunas-pinjaman btn-block py-1"
                                               data-nama="<?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                                               title="Tandai Pinjaman Lunas Penuh">
                                                <i class="fas fa-check-double mr-1"></i> Tandai Lunas
                                            </a>
                                        <?php else : ?>
                                            <?php if ($p->status == 'Lunas') : ?>
                                                <a href="<?php echo base_url('admin/pinjaman/cetak_sppk/' . $p->id_pinjaman); ?>" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary btn-block py-1 mb-1 font-weight-bold shadow-sm"
                                                   title="Cetak Arsip SPPK">
                                                    <i class="fas fa-print mr-1"></i> Cetak SPPK
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo base_url('admin/pinjaman/hapus/' . $p->id_pinjaman); ?>" 
                                               class="btn btn-sm btn-outline-danger btn-hapus btn-block py-1"
                                               data-nama="Pinjaman <?php echo htmlspecialchars($p->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>"
                                               title="Hapus Rekap Pinjaman">
                                                <i class="fas fa-trash-can mr-1"></i> Hapus
                                            </a>
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

<!-- SweetAlert2 Interactive Modals Script for Admin Pinjaman -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = () => document.body.classList.contains('dark-mode');

    // 1. Interactive Approval Dialog with Risk Summary
    $(document).on('click', '.btn-approve-pinjaman', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const nominal = $(this).data('nominal');
        const tenor = $(this).data('tenor');
        const cicilan = $(this).data('cicilan');
        const dsr = $(this).data('dsr');

        Swal.fire({
            title: 'Setujui Pengajuan Kasbon?',
            html: `
                <div class="text-left mb-2">
                    <div class="alert alert-info py-2 px-3 mb-3" style="font-size: 0.88rem; border-radius: 10px;">
                        <i class="fas fa-info-circle mr-1"></i> Pemotongan cicilan akan otomatis disuntikkan ke slip gaji bulanan pegawai.
                    </div>
                    <p class="mb-1 font-weight-bold" style="font-size: 1rem;">Pegawai: ${nama}</p>
                    <p class="small mb-1 text-muted">Nominal: <strong class="text-primary">${nominal}</strong> &bull; Tenor: <b>${tenor}</b></p>
                    <p class="small mb-3 text-muted">Cicilan: <strong class="text-danger">${cicilan}</strong> &bull; Beban Gaji: <b>${dsr}</b></p>
                    <label class="font-weight-bold small mb-1">Catatan HRD / Pimpinan (Opsional):</label>
                    <textarea id="swal_pesan_admin" class="form-control" rows="2" placeholder="Misal: Disetujui sesuai plafon. Pemotongan cicilan aktif mulai payroll bulan ini."></textarea>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Setujui Kasbon',
            cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
            background: isDark() ? '#1e293b' : '#ffffff',
            color: isDark() ? '#f8fafc' : '#0f172a',
            preConfirm: () => {
                return document.getElementById('swal_pesan_admin').value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo base_url("admin/pinjaman/setujui/"); ?>' + id;

                const inputPesan = document.createElement('input');
                inputPesan.type = 'hidden';
                inputPesan.name = 'pesan_admin';
                inputPesan.value = result.value || '';
                form.appendChild(inputPesan);

                const inputCsrf = document.createElement('input');
                inputCsrf.type = 'hidden';
                inputCsrf.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                inputCsrf.value = '<?php echo $this->security->get_csrf_hash(); ?>';
                form.appendChild(inputCsrf);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // 2. Interactive Rejection Dialog
    $(document).on('click', '.btn-reject-pinjaman', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nama = $(this).data('nama');

        Swal.fire({
            title: 'Tolak Pinjaman Pegawai?',
            html: `
                <div class="text-left mb-2">
                    <p class="mb-2">Anda akan menolak pengajuan pinjaman pegawai: <b>${nama}</b>.</p>
                    <label class="font-weight-bold small mb-1">Alasan Penolakan <span class="text-danger">*</span>:</label>
                    <textarea id="swal_alasan_tolak" class="form-control" rows="3" placeholder="Tuliskan alasan penolakan secara jelas (misal: Rasio beban kredit melebihi batas anggaran)..."></textarea>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-times mr-1"></i> Ya, Tolak Pengajuan',
            cancelButtonText: '<i class="fas fa-ban mr-1"></i> Batal',
            background: isDark() ? '#1e293b' : '#ffffff',
            color: isDark() ? '#f8fafc' : '#0f172a',
            preConfirm: () => {
                const alasan = document.getElementById('swal_alasan_tolak').value;
                if (!alasan || !alasan.trim()) {
                    Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                    return false;
                }
                return alasan.trim();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo base_url("admin/pinjaman/tolak/"); ?>' + id;

                const inputPesan = document.createElement('input');
                inputPesan.type = 'hidden';
                inputPesan.name = 'pesan_admin';
                inputPesan.value = result.value;
                form.appendChild(inputPesan);

                const inputCsrf = document.createElement('input');
                inputCsrf.type = 'hidden';
                inputCsrf.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                inputCsrf.value = '<?php echo $this->security->get_csrf_hash(); ?>';
                form.appendChild(inputCsrf);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // 3. Interactive Mark as Paid (Lunas)
    $(document).on('click', '.btn-lunas-pinjaman', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const nama = $(this).data('nama');

        Swal.fire({
            title: 'Tandai Pinjaman Lunas?',
            html: `Apakah Anda yakin ingin menandai pinjaman pegawai <strong>${nama}</strong> telah <strong>LUNAS PENUH</strong>? Tindakan ini akan menghentikan pemotongan otomatis pada payroll berikutnya.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-check-double mr-1"></i> Ya, Tandai Lunas',
            cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
            background: isDark() ? '#1e293b' : '#ffffff',
            color: isDark() ? '#f8fafc' : '#0f172a'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });
});
</script>
