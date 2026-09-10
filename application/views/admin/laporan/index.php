<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold" style="letter-spacing: -0.02em;">
                <i class="fas fa-print text-primary mr-2"></i><?php echo $title; ?>
            </h1>
            <p class="text-muted small mb-0">
                Pusat kendali arsip terpadu untuk mengekspor, memfilter, dan mencetak seluruh laporan operasional & penggajian Klinik Pratama Dr. H.M. Hidayatullah.
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light border px-3 py-2 font-weight-bold text-primary shadow-sm" style="border-radius: 10px; font-size: 0.85rem;">
                <i class="fas fa-calendar-alt mr-1"></i> Periode Aktif: <?php echo date('F Y'); ?>
            </span>
        </div>
    </div>

    <!-- Quick Stats Metric Strip -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 14px; border-left: 4px solid #0284c7 !important;">
                <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Staf & Nakes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_pegawai; ?> Pegawai</div>
                        </div>
                        <div class="col-auto">
                            <div class="menu-icon-squircle squircle-primary mb-0">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 14px; border-left: 4px solid #f59e0b !important;">
                <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Cuti Disetujui Bln Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $cuti_bulan_ini; ?> Berkas</div>
                        </div>
                        <div class="col-auto">
                            <div class="menu-icon-squircle squircle-warning mb-0">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 14px; border-left: 4px solid #6366f1 !important;">
                <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Lembur Bln Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $lembur_bulan_ini->jam ?? 0; ?> Jam</div>
                        </div>
                        <div class="col-auto">
                            <div class="menu-icon-squircle squircle-info mb-0">
                                <i class="fas fa-business-time"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 14px; border-left: 4px solid #10b981 !important;">
                <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Saldo Kasbon Berjalan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($pinjaman_aktif->sisa ?? 0, 0, ',', '.'); ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="menu-icon-squircle squircle-success mb-0">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KLUSTER 1: PENGGAJIAN & FINANSIAL -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <div class="mr-2 text-primary"><i class="fas fa-coins fa-lg"></i></div>
            <h5 class="font-weight-bold text-gray-800 mb-0">1. Laporan Penggajian & Finansial</h5>
            <span class="badge badge-primary-subtle ml-3 px-2 py-1 small font-weight-bold text-primary" style="background: rgba(14, 165, 233, 0.12);">Payroll & Accounting</span>
        </div>

        <div class="row">
            <!-- Laporan Gaji Bulanan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-primary" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-primary">Bulanan</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Gaji Bulanan</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Rekapitulasi total gaji pokok, uang makan, transport, lembur, dan potongan take home pay seluruh staf.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_gaji'); ?>" class="btn btn-outline-primary btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>

            <!-- Laporan Gaji Tahunan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-info" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-info">Tahunan</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Gaji Tahunan</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Akumulasi pengeluaran gaji selama 1 tahun penuh per individu pegawai untuk keperluan audit dan pajak.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_tahunan'); ?>" class="btn btn-outline-info btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cetak Slip Gaji -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-success" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-success">Per Pegawai</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Cetak Slip Gaji</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Cetak lembaran slip gaji resmi individu ber-barcode untuk diserahkan ke pegawai klinik bersangkutan.
                        </p>
                        <a href="<?php echo base_url('admin/slip_gaji'); ?>" class="btn btn-outline-success btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-user-tag mr-1"></i> Pilih Pegawai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Laporan Potongan Gaji -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-danger" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-percent"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-danger">Potongan</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Potongan Gaji</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Rincian pemotongan upah karena ketidakhadiran (alpha), sanksi disiplin, dan iuran wajib klinik.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_potongan'); ?>" class="btn btn-outline-danger btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KLUSTER 2: KEHADIRAN & OPERASIONAL -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <div class="mr-2 text-warning"><i class="fas fa-clipboard-check fa-lg"></i></div>
            <h5 class="font-weight-bold text-gray-800 mb-0">2. Laporan Kehadiran, Cuti & Operasional</h5>
            <span class="badge badge-warning-subtle ml-3 px-2 py-1 small font-weight-bold text-warning" style="background: rgba(245, 158, 11, 0.12);">HR Operations</span>
        </div>

        <div class="row">
            <!-- Laporan Absensi -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-primary" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-primary">Presensi</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Presensi Staf</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Rekapitulasi tingkat kehadiran pegawai, sakit, izin, dan persentase disiplin kerja bulanan.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_absensi'); ?>" class="btn btn-outline-primary btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>

            <!-- Laporan Cuti Pegawai -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-warning" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-calendar-minus"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-warning">Cuti & Izin</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Cuti Pegawai</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Daftar permohonan cuti resmi, pendelegasian tugas jaga klinik, serta pengawasan saldo kuota.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_cuti'); ?>" class="btn btn-outline-warning btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>

            <!-- Laporan Lembur -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-info" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-business-time"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-info">Overtime</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Laporan Lembur Pegawai</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Akumulasi jam lembur pelayanan ekstra pasien dan perhitungan nominal kompensasi upah lembur.
                        </p>
                        <a href="<?php echo base_url('admin/laporan_lembur'); ?>" class="btn btn-outline-info btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-filter mr-1"></i> Filter & Cetak
                        </a>
                    </div>
                </div>
            </div>

            <!-- Laporan Kasbon & Pinjaman -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="menu-icon-squircle squircle-success" style="width: 46px; height: 46px; font-size: 1.2rem;">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <span class="badge badge-light border font-weight-bold small text-success">Kasbon</span>
                        </div>
                        <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1rem;">Pinjaman & Kasbon Staf</h6>
                        <p class="text-muted small flex-grow-1" style="line-height: 1.45;">
                            Monitoring sisa pokok pinjaman, tenor cicilan, serta cetak SPPK (Surat Persetujuan Pinjaman Karyawan).
                        </p>
                        <a href="<?php echo base_url('admin/pinjaman'); ?>" class="btn btn-outline-success btn-sm btn-block font-weight-bold py-2 mt-2" style="border-radius: 10px;">
                            <i class="fas fa-tasks mr-1"></i> Kelola & Cetak SPPK
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KLUSTER 3: MASTER DATA & ORGANISASI -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <div class="mr-2 text-info"><i class="fas fa-sitemap fa-lg"></i></div>
            <h5 class="font-weight-bold text-gray-800 mb-0">3. Laporan Data Induk & Standar Jabatan</h5>
            <span class="badge badge-info-subtle ml-3 px-2 py-1 small font-weight-bold text-info" style="background: rgba(99, 102, 241, 0.12);">Master Data</span>
        </div>

        <div class="row">
            <!-- Data Master Pegawai -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="menu-icon-squircle squircle-primary mr-3" style="width: 54px; height: 54px; font-size: 1.4rem;">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="font-weight-bold text-gray-800 mb-0" style="font-size: 1.05rem;">Data Master Pegawai</h6>
                                <span class="badge badge-light border font-weight-bold small text-primary">Master SDM</span>
                            </div>
                            <p class="text-muted small mb-2" style="line-height: 1.4;">
                                Cetak seluruh data pokok pegawai aktif klinik, NIK, jabatan fungsional medis, dan tanggal mulai bergabung.
                            </p>
                            <a href="<?php echo base_url('admin/laporan_pegawai'); ?>" class="btn btn-sm btn-primary font-weight-bold px-3 py-1 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-filter mr-1"></i> Filter Divisi & Cetak
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Standar Jabatan -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 16px; transition: all 0.25s ease;">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="menu-icon-squircle squircle-info mr-3" style="width: 54px; height: 54px; font-size: 1.4rem;">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="font-weight-bold text-gray-800 mb-0" style="font-size: 1.05rem;">Struktur Standar Gaji Jabatan</h6>
                                <span class="badge badge-light border font-weight-bold small text-info">Struktur Upah</span>
                            </div>
                            <p class="text-muted small mb-2" style="line-height: 1.4;">
                                Lembar standar plafon gaji pokok, uang transport, dan uang makan resmi per tingkatan jabatan di klinik.
                            </p>
                            <a href="<?php echo base_url('admin/data_jabatan/cetak_data_jabatan'); ?>" target="_blank" class="btn btn-sm btn-info font-weight-bold px-3 py-1 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-print mr-1"></i> Cetak Langsung Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<style>
.hover-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.12) !important;
}
</style>
