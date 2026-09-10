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

    <!-- Sidebar -->
    <ul class="navbar-nav bg-modern-blue sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center" href="<?php echo base_url('pegawai/dashboard') ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-heartbeat text-info"></i>
        </div>
        <div class="sidebar-brand-text text-white font-weight-bold">
          <div>HRIS <span class="text-info font-weight-light">PEGAWAI</span></div>
          <div class="text-white-50" style="font-size: 0.65rem; font-weight: 400; text-transform: none; letter-spacing: 0.02em;">Portal Mandiri</div>
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" style="border-top-color: rgba(255,255,255,0.06);">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/absensi') ?>">
          <i class="fas fa-fw fa-clock"></i>
          <span>Absensi</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/lembur') ?>">
          <i class="fas fa-fw fa-clock"></i>
          <span>Pengajuan Lembur</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/absensi/riwayat') ?>">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Riwayat Absensi</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/cuti') ?>">
          <i class="fas fa-fw fa-file-signature"></i>
          <span>Pengajuan Cuti</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/data_gaji') ?>">
          <i class="fas fa-fw fa-money-check-alt"></i>
          <span>Data Gaji</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('pegawai/pinjaman') ?>">
          <i class="fas fa-fw fa-hand-holding-usd"></i>
          <span>Pinjaman (Kasbon)</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
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

            <!-- Nav Item - Alerts Pegawai -->
            <?php 
              $nik_user = $this->session->userdata('nik');
              $notif_cuti_user = $this->db->query("SELECT * FROM data_cuti WHERE nik='$nik_user' ORDER BY id_cuti DESC LIMIT 2")->result();
              $notif_pinjaman_user = $this->db->query("SELECT * FROM data_pinjaman WHERE nik='$nik_user' ORDER BY id_pinjaman DESC LIMIT 2")->result();
              $total_notif_user = count($notif_cuti_user) + count($notif_pinjaman_user);
            ?>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdownPegawai" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="position-relative">
                  <i class="fas fa-bell fa-fw text-light" style="font-size: 1.15rem;"></i>
                  <?php if($total_notif_user > 0) { ?>
                    <span class="badge badge-info badge-counter shadow-sm" style="font-size: 0.68rem; top: -6px; right: -8px; border: 1.5px solid #0c2b4d;"><?php echo $total_notif_user ?></span>
                  <?php } ?>
                </div>
              </a>
              <!-- Modern Dropdown - Alerts Pegawai -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow-lg topbar-dropdown-menu animated--grow-in p-0 border-0" aria-labelledby="alertsDropdownPegawai" style="min-width: 330px !important;">
                <div class="topbar-dropdown-header d-flex align-items-center justify-content-between text-left py-3 px-3">
                  <div>
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-bell mr-2"></i> STATUS PENGAJUAN</h6>
                    <span class="small text-white-50">Aktivitas permohonan terkini Anda</span>
                  </div>
                  <span class="badge badge-primary-subtle px-2 py-1 text-white font-weight-bold" style="background: rgba(14, 165, 233, 0.3);">Portal</span>
                </div>

                <div class="topbar-dropdown-body p-2">
                  <?php if(!empty($notif_cuti_user)) { 
                    foreach($notif_cuti_user as $nc) { ?>
                    <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/cuti') ?>">
                      <div class="menu-icon-squircle squircle-warning">
                        <i class="fas fa-calendar-minus"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold item-title" style="font-size: 0.86rem;">Cuti: <?php echo $nc->jenis_cuti; ?></span>
                          <?php if($nc->status_cuti == 'Disetujui') { ?>
                            <span class="badge badge-success px-2">Disetujui</span>
                          <?php } else if($nc->status_cuti == 'Ditolak') { ?>
                            <span class="badge badge-danger px-2">Ditolak</span>
                          <?php } else { ?>
                            <span class="badge badge-warning px-2">Menunggu</span>
                          <?php } ?>
                        </div>
                        <div class="small text-muted" style="font-size: 0.73rem;">Periode: <?php echo date('d/m/Y', strtotime($nc->tanggal_mulai)); ?></div>
                      </div>
                    </a>
                  <?php } } ?>

                  <?php if(!empty($notif_pinjaman_user)) { 
                    foreach($notif_pinjaman_user as $np) { ?>
                    <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/pinjaman') ?>">
                      <div class="menu-icon-squircle squircle-success">
                        <i class="fas fa-hand-holding-usd"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                          <span class="font-weight-bold item-title" style="font-size: 0.86rem;">Kasbon: Rp. <?php echo number_format($np->jumlah_pinjaman, 0, ',', '.'); ?></span>
                          <?php if($np->status == 'Disetujui' || $np->status == 'Lunas') { ?>
                            <span class="badge badge-success px-2"><?php echo $np->status; ?></span>
                          <?php } else if($np->status == 'Ditolak') { ?>
                            <span class="badge badge-danger px-2">Ditolak</span>
                          <?php } else { ?>
                            <span class="badge badge-warning px-2">Menunggu</span>
                          <?php } ?>
                        </div>
                        <div class="small text-muted" style="font-size: 0.73rem;">Status pengajuan pinjaman Anda.</div>
                      </div>
                    </a>
                  <?php } } ?>

                  <?php if(empty($notif_cuti_user) && empty($notif_pinjaman_user)) { ?>
                    <div class="text-center py-4 px-3">
                      <div class="menu-icon-squircle squircle-info mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1.4rem;">
                        <i class="fas fa-info-circle"></i>
                      </div>
                      <h6 class="font-weight-bold text-gray-800 mb-1" style="font-size: 0.92rem;">Belum Ada Pengajuan</h6>
                      <p class="small text-muted mb-0">Ajukan cuti atau pinjaman kapan saja di portal.</p>
                    </div>
                  <?php } ?>
                </div>

                <div class="topbar-dropdown-footer text-center px-3 py-2">
                  <a href="<?php echo base_url('pegawai/cuti') ?>" class="text-primary font-weight-bold small text-decoration-none">Buka Riwayat Permohonan &rarr;</a>
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
                  <div class="text-white-50 small" style="font-size: 0.72rem;"><?php echo $this->session->userdata('jabatan') ?? 'Staff Pegawai'; ?></div>
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
                  <span class="badge badge-pill text-white small px-3 py-1 font-weight-bold" style="background: rgba(16, 185, 129, 0.25); border: 1px solid rgba(16, 185, 129, 0.4);">
                    <?php echo strtoupper($this->session->userdata('jabatan') ?? 'STAFF PEGAWAI'); ?>
                  </span>
                  <div class="small text-white-50 mt-1" style="font-size: 0.75rem;">NIK: <?php echo $this->session->userdata('nik') ?? '-'; ?></div>
                </div>
                
                <!-- Dropdown Menu Items -->
                <div class="topbar-dropdown-body">
                  <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/dashboard') ?>">
                    <div class="menu-icon-squircle squircle-primary">
                      <i class="fas fa-id-badge"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Profil & Dashboard</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Ringkasan akun & presensi</div>
                    </div>
                  </a>

                  <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/cuti') ?>">
                    <div class="menu-icon-squircle squircle-warning">
                      <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Permohonan Cuti Saya</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Jatah saldo & pengajuan cuti</div>
                    </div>
                  </a>

                  <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/pinjaman') ?>">
                    <div class="menu-icon-squircle squircle-success">
                      <i class="fas fa-wallet"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Kasbon & Pinjaman</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Riwayat & cicilan pinjaman</div>
                    </div>
                  </a>

                  <a class="topbar-dropdown-item" href="<?php echo base_url('pegawai/ganti_password') ?>">
                    <div class="menu-icon-squircle squircle-info">
                      <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold item-title" style="font-size: 0.88rem;">Keamanan & Password</div>
                      <div class="small text-muted" style="font-size: 0.73rem;">Perbarui kata sandi login</div>
                    </div>
                  </a>

                  <div class="dropdown-divider my-2 mx-2"></div>

                  <a class="topbar-dropdown-item btn-logout-swal" href="<?php echo base_url('login/logout') ?>" data-user="<?php echo htmlspecialchars($this->session->userdata('nama_pegawai') ?? 'Pegawai'); ?>" data-role="Pegawai" role="button">
                    <div class="menu-icon-squircle squircle-danger">
                      <i class="fas fa-power-off"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="font-weight-bold text-danger item-title" style="font-size: 0.88rem;">Logout Aplikasi</div>
                      <div class="small text-danger opacity-75" style="font-size: 0.73rem;">Keluar dari portal pegawai</div>
                    </div>
                  </a>
                </div>

                <!-- Dropdown Footer -->
                <div class="topbar-dropdown-footer">
                  <i class="fas fa-heartbeat text-success mr-1"></i> Portal Mandiri Pegawai Klinik Hidayatullah
                </div>
              </div>
            </li>  

          </ul>

        </nav>
        <!-- End of Topbar -->