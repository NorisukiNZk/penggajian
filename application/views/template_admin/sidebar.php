<body id="page-top" class="page-fade-in">

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="preloader-text">MEMUAT HRIS...</div>
        </div>
    </div>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php 
      // Query untuk mengambil jumlah cuti, lembur, dan pinjaman yang menunggu persetujuan (Optimized COUNT)
      $q_cuti = $this->db->query("SELECT COUNT(*) AS total FROM data_cuti WHERE status_cuti='Menunggu'")->row();
      $notif_cuti = $q_cuti ? (int)$q_cuti->total : 0;
      
      $q_lembur = $this->db->query("SELECT COUNT(*) AS total FROM data_lembur WHERE status='Pending'")->row();
      $notif_lembur = $q_lembur ? (int)$q_lembur->total : 0;
      
      $q_pinjaman = $this->db->query("SELECT COUNT(*) AS total FROM data_pinjaman WHERE status='Menunggu'")->row();
      $notif_pinjaman = $q_pinjaman ? (int)$q_pinjaman->total : 0;
      
      $total_notif = $notif_cuti + $notif_lembur + $notif_pinjaman;

      // Active menu detection
      $seg2 = strtolower((string)$this->uri->segment(2));
      $seg3 = strtolower((string)$this->uri->segment(3));
      $is_dashboard = ($seg2 == 'dashboard' || empty($seg2));
      $is_master = in_array($seg2, array('data_pegawai', 'data_jabatan', 'hari_libur'));
      $is_transaksi = in_array($seg2, array('absensi_harian', 'data_cuti', 'data_lembur', 'data_absensi', 'data_penggajian', 'pinjaman', 'komponen_gaji', 'potongan_gaji'));
      $is_laporan = in_array($seg2, array('laporan', 'laporan_gaji', 'laporan_absensi', 'laporan_cuti', 'laporan_lembur', 'laporan_potongan', 'laporan_tahunan', 'slip_gaji', 'laporan_pegawai'));
    ?>

    <!-- Sidebar -->
    <ul class="navbar-nav bg-modern-blue sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center" href="<?php echo base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-heartbeat text-info"></i>
        </div>
        <div class="sidebar-brand-text text-white font-weight-bold">
          <div>HRIS <span class="text-info font-weight-light">KLINIK</span></div>
          <div class="text-white-50" style="font-size: 0.65rem; font-weight: 400; text-transform: none; letter-spacing: 0.02em;">Pratama Hidayatullah</div>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" style="border-top-color: rgba(255,255,255,0.06);">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php echo $is_dashboard ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
          <i class="fas fa-fw fa-gauge-high"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Master Data Collapse Menu -->
      <li class="nav-item <?php echo $is_master ? 'active' : '' ?>">
        <a class="nav-link <?php echo $is_master ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="<?php echo $is_master ? 'true' : 'false' ?>" aria-controls="collapseTwo">
          <i class="fa fa-fw fa-database"></i>
          <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse <?php echo $is_master ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="collapse-inner">
            <h6 class="collapse-header">Database Entitas:</h6>
            <a class="collapse-item <?php echo ($seg2 == 'data_pegawai') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_pegawai') ?>">
              <i class="fas fa-users-cog mr-2 text-primary"></i> Data Pegawai
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'data_jabatan') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_jabatan') ?>">
              <i class="fas fa-sitemap mr-2 text-info"></i> Data Jabatan
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'hari_libur') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/hari_libur') ?>">
              <i class="fas fa-calendar-day mr-2 text-warning"></i> Hari Libur Nasional
            </a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Transaksi Collapse Menu -->
      <li class="nav-item <?php echo $is_transaksi ? 'active' : '' ?>">
        <a class="nav-link <?php echo $is_transaksi ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="<?php echo $is_transaksi ? 'true' : 'false' ?>" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-money-bill-transfer"></i>
          <span>Transaksi</span>
        </a>
        <div id="collapseUtilities" class="collapse <?php echo $is_transaksi ? 'show' : '' ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="collapse-inner">
            <h6 class="collapse-header">Presensi & Kehadiran:</h6>
            <a class="collapse-item <?php echo ($seg2 == 'absensi_harian' && $seg3 != 'rekap' && $seg3 != 'setting') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/absensi_harian') ?>">
              <i class="fas fa-desktop mr-2 text-primary"></i> Monitoring Hari Ini
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'absensi_harian' && $seg3 == 'rekap') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/absensi_harian/rekap') ?>">
              <i class="fas fa-clipboard-check mr-2 text-info"></i> Rekap Absensi
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'data_cuti' && $seg3 != 'setting') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_cuti') ?>">
              <i class="fas fa-calendar-check mr-2 text-warning"></i> Pengajuan Cuti / Izin
              <?php if($notif_cuti > 0) { ?>
                <span class="badge badge-warning ml-auto px-1 font-weight-bold" style="font-size: 0.65rem; border-radius: 4px;"><?php echo $notif_cuti ?></span>
              <?php } ?>
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'data_cuti' && $seg3 == 'setting') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_cuti/setting') ?>">
              <i class="fas fa-sliders-h mr-2 text-secondary"></i> Setting Kuota Cuti
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'data_lembur') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_lembur') ?>">
              <i class="fas fa-business-time mr-2 text-success"></i> Data Lembur
              <?php if($notif_lembur > 0) { ?>
                <span class="badge badge-info ml-auto px-1 font-weight-bold" style="font-size: 0.65rem; border-radius: 4px;"><?php echo $notif_lembur ?></span>
              <?php } ?>
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'absensi_harian' && $seg3 == 'setting') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/absensi_harian/setting') ?>">
              <i class="fas fa-map-marker-alt mr-2 text-danger"></i> Setting Absensi & GPS
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'data_absensi') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_absensi') ?>">
              <i class="fas fa-history mr-2 text-muted"></i> Data Absensi (Lama)
            </a>

            <div class="dropdown-divider my-1"></div>

            <h6 class="collapse-header">Penggajian & Keuangan:</h6>
            <a class="collapse-item <?php echo ($seg2 == 'data_penggajian') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/data_penggajian') ?>">
              <i class="fas fa-money-check-alt mr-2 text-success"></i> Data Gaji Pegawai
            </a>
            <a class="collapse-item <?php echo ($seg2 == 'pinjaman') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/pinjaman') ?>">
              <i class="fas fa-hand-holding-usd mr-2 text-danger"></i> Pinjaman Karyawan
              <?php if($notif_pinjaman > 0) { ?>
                <span class="badge badge-danger ml-auto px-1 font-weight-bold" style="font-size: 0.65rem; border-radius: 4px;"><?php echo $notif_pinjaman ?></span>
              <?php } ?>
            </a>
            <a class="collapse-item <?php echo in_array($seg2, array('komponen_gaji', 'potongan_gaji')) ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/komponen_gaji') ?>">
              <i class="fas fa-sliders-h mr-2 text-primary"></i> Komponen & Potongan
            </a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php echo $is_laporan ? 'active' : '' ?>">
        <a class="nav-link <?php echo $is_laporan ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="<?php echo $is_laporan ? 'true' : 'false' ?>" aria-controls="collapsePages">
          <i class="fas fa-fw fa-chart-pie"></i>
          <span>Laporan</span>
        </a>
        <div id="collapsePages" class="collapse <?php echo $is_laporan ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="collapse-inner">
            <a class="collapse-item font-weight-bold text-primary mb-1 <?php echo ($seg2 == 'laporan') ? 'active' : '' ?>" href="<?php echo base_url('admin/laporan') ?>" style="background: rgba(14, 165, 233, 0.08); border-radius: 8px;">
              <i class="fas fa-th-large mr-2 text-primary"></i> Pusat Laporan Terpadu
            </a>
            <div class="dropdown-divider my-1"></div>

            <h6 class="collapse-header">Laporan Transaksi:</h6>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_gaji') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_gaji') ?>"><i class="fas fa-file-invoice-dollar mr-2 text-primary"></i> Gaji Bulanan</a>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_absensi') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_absensi') ?>"><i class="fas fa-user-check mr-2 text-info"></i> Presensi / Absensi</a>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_cuti') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_cuti') ?>"><i class="fas fa-calendar-minus mr-2 text-warning"></i> Cuti & Izin</a>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_lembur') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_lembur') ?>"><i class="fas fa-business-time mr-2 text-secondary"></i> Lembur Karyawan</a>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_potongan') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_potongan') ?>"><i class="fas fa-percent mr-2 text-danger"></i> Potongan Gaji</a>
            
            <h6 class="collapse-header">Laporan Master & Rekap:</h6>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_tahunan') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_tahunan') ?>"><i class="fas fa-chart-line mr-2 text-success"></i> Gaji Tahunan</a>
            <a class="collapse-item <?php echo ($seg2 == 'slip_gaji') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/slip_gaji') ?>"><i class="fas fa-receipt mr-2 text-dark"></i> Cetak Slip Gaji</a>
            <a class="collapse-item <?php echo ($seg2 == 'laporan_pegawai') ? 'active font-weight-bold' : '' ?>" href="<?php echo base_url('admin/laporan_pegawai') ?>"><i class="fas fa-address-book mr-2 text-primary"></i> Master Pegawai</a>
            <a class="collapse-item" target="_blank" href="<?php echo base_url('admin/data_jabatan/cetak_data_jabatan') ?>"><i class="fas fa-network-wired mr-2 text-info"></i> Standar Jabatan</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline mt-3 mb-4">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-dark bg-modern-blue topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div class="d-none d-lg-block ml-3">
              <h5 class="font-weight-bold text-white mb-0" style="letter-spacing: 1px;">KLINIK PRATAMA <span class="text-info">HIDAYATULLAH</span></h5>
              <div class="text-white-50 small mt-1 font-weight-bold" id="live-clock"><i class="fas fa-clock"></i> Memuat Jam...</div>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Dark Mode Toggle -->
            <li class="nav-item mx-1">
              <a class="nav-link" href="javascript:void(0);" id="darkModeToggle" role="button">
                <i class="fas fa-moon fa-fw text-light" id="darkModeIcon" style="font-size: 1.2rem;"></i>
              </a>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="position-relative">
                  <i class="fas fa-bell fa-fw text-light" style="font-size: 1.15rem;"></i>
                  <?php if($total_notif > 0) { ?>
                    <span class="badge badge-danger badge-counter shadow-sm" style="font-size: 0.68rem; top: -6px; right: -8px; border: 1.5px solid #0c2b4d;"><?php echo $total_notif ?></span>
                  <?php } ?>
                </div>
              </a>
              <!-- Modern Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow-lg topbar-dropdown-menu animated--grow-in p-0 border-0" aria-labelledby="alertsDropdown" style="min-width: 340px !important;">
                <div class="topbar-dropdown-header d-flex align-items-center justify-content-between text-left py-3 px-3">
                  <div>
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-bell mr-2"></i> PUSAT NOTIFIKASI</h6>
                    <span class="small text-white-50">Antrean persetujuan staf klinik</span>
                  </div>
                  <?php if($total_notif > 0) { ?>
                    <span class="badge badge-danger px-2 py-1 font-weight-bold shadow-sm"><?php echo $total_notif ?> Menunggu</span>
                  <?php } else { ?>
                    <span class="badge badge-success px-2 py-1 font-weight-bold">Semua Beres</span>
                  <?php } ?>
                </div>

                <div class="topbar-dropdown-body p-2">
                  <?php if($notif_cuti > 0) { ?>
                    <a class="topbar-dropdown-item" href="<?php echo base_url('admin/data_cuti') ?>">
                      <div class="menu-icon-squircle squircle-warning">
                        <i class="fas fa-calendar-minus"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold item-title" style="font-size: 0.88rem;">Permohonan Cuti & Izin</span>
                          <span class="badge badge-warning px-2 font-weight-bold"><?php echo $notif_cuti ?> Baru</span>
                        </div>
                        <div class="small text-muted" style="font-size: 0.74rem;">Staf klinik mengajukan cuti / izin kerja.</div>
                      </div>
                    </a>
                  <?php } ?>

                  <?php if($notif_lembur > 0) { ?>
                    <a class="topbar-dropdown-item" href="<?php echo base_url('admin/data_lembur') ?>">
                      <div class="menu-icon-squircle squircle-info">
                        <i class="fas fa-business-time"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold item-title" style="font-size: 0.88rem;">Pengajuan Lembur</span>
                          <span class="badge badge-info px-2 font-weight-bold"><?php echo $notif_lembur ?> Baru</span>
                        </div>
                        <div class="small text-muted" style="font-size: 0.74rem;">Pengajuan jam lembur menunggu verifikasi.</div>
                      </div>
                    </a>
                  <?php } ?>

                  <?php if($notif_pinjaman > 0) { ?>
                    <a class="topbar-dropdown-item" href="<?php echo base_url('admin/pinjaman') ?>">
                      <div class="menu-icon-squircle squircle-success">
                        <i class="fas fa-hand-holding-usd"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold item-title" style="font-size: 0.88rem;">Pengajuan Pinjaman</span>
                          <span class="badge badge-success px-2 font-weight-bold"><?php echo $notif_pinjaman ?> Baru</span>
                        </div>
                        <div class="small text-muted" style="font-size: 0.74rem;">Kasbon pegawai menunggu persetujuan HRD.</div>
                      </div>
                    </a>
                  <?php } ?>

                  <?php if($total_notif == 0) { ?>
                    <div class="text-center py-4 px-3">
                      <div class="menu-icon-squircle squircle-success mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        <i class="fas fa-check-circle"></i>
                      </div>
                      <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 0.92rem;">Semua Terkendali!</h6>
                      <p class="small text-muted mb-0">Tidak ada antrean yang menunggu persetujuan.</p>
                    </div>
                  <?php } ?>
                </div>

                <div class="topbar-dropdown-footer d-flex justify-content-between align-items-center px-3 py-2">
                  <a href="<?php echo base_url('admin/data_cuti') ?>" class="text-primary font-weight-bold small text-decoration-none"><i class="fas fa-tasks mr-1"></i> Buka Antrean HRD</a>
                  <span class="small text-muted"><?php echo date('d M Y'); ?></span>
                </div>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle topbar-user-trigger" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="topbar-avatar-wrapper mr-2">
                  <img class="topbar-avatar-img" src="<?php echo base_url('photo/').$this->session->userdata('photo') ?>" alt="Avatar">
                  <span class="online-indicator-dot"></span>
                </div>
                <div class="d-none d-lg-block text-left mr-2">
                  <div class="text-white font-weight-bold" style="font-size: 0.85rem; line-height: 1.2;"><?php echo $this->session->userdata('nama_pegawai')?></div>
                  <div class="text-white-50 small" style="font-size: 0.72rem;">Administrator</div>
                </div>
                <i class="fas fa-chevron-down fa-xs text-white-50 d-none d-lg-inline ml-1"></i>
              </a>

              <!-- Modern Dropdown Menu -->
              <div class="dropdown-menu dropdown-menu-right shadow-lg topbar-dropdown-menu animated--grow-in p-0 border-0" aria-labelledby="userDropdown">
                <!-- Executive Profile Header -->
                <div class="topbar-dropdown-header">
                  <div class="header-avatar-circle">
                    <img class="header-avatar-img" src="<?php echo base_url('photo/').$this->session->userdata('photo') ?>" alt="User Photo">
                    <span class="header-online-badge"></span>
                  </div>
                  <h6 class="font-weight-bold text-white mb-1" style="font-size: 1rem; letter-spacing: -0.01em;">
                    <?php echo $this->session->userdata('nama_pegawai')?>
                  </h6>
                  <span class="badge badge-pill text-white small px-3 py-1 font-weight-bold" style="background: rgba(14, 165, 233, 0.25); border: 1px solid rgba(14, 165, 233, 0.4);">
                    ADMINISTRATOR
                  </span>
                </div>
                
                <!-- Dropdown Menu Items -->
                <div class="topbar-dropdown-body">
                  <a class="topbar-dropdown-item" href="<?php echo base_url('admin/dashboard') ?>">
                    <div class="menu-icon-squircle squircle-primary">
                      <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Dashboard Admin</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Ringkasan sistem & analitik</div>
                    </div>
                  </a>

                  <a class="topbar-dropdown-item" href="<?php echo base_url('admin/data_cuti/setting') ?>">
                    <div class="menu-icon-squircle squircle-info">
                      <i class="fas fa-sliders-h"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Setting Kuota Cuti</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Konfigurasi kuota klinik</div>
                    </div>
                  </a>

                  <a class="topbar-dropdown-item" href="<?php echo base_url('ganti_password') ?>">
                    <div class="menu-icon-squircle squircle-warning">
                      <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Keamanan & Password</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Perbarui kata sandi login</div>
                    </div>
                  </a>

                  <div class="dropdown-divider my-2 mx-2"></div>

                  <a class="topbar-dropdown-item btn-logout-swal" href="<?php echo base_url('login/logout') ?>" data-user="<?php echo htmlspecialchars($this->session->userdata('nama_pegawai') ?? 'Administrator'); ?>" data-role="Administrator" role="button">
                    <div class="menu-icon-squircle squircle-danger">
                      <i class="fas fa-power-off"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold text-danger item-title" style="font-size: 0.88rem;">Logout Aplikasi</div>
                      <div class="small text-danger opacity-75" style="font-size: 0.73rem;">Keluar dari sesi admin</div>
                    </div>
                  </a>
                </div>

                <!-- Dropdown Footer -->
                <div class="topbar-dropdown-footer">
                  <i class="fas fa-heartbeat text-danger mr-1"></i> Klinik Pratama Dr. H.M. Hidayatullah
                </div>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->