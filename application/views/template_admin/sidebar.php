<style>
/* Modernized Blue Sidebar Theme */
.bg-modern-blue {
    background-color: #0c2b4d; 
    background-image: linear-gradient(180deg, #0c2b4d 10%, #1a4270 100%); 
    background-size: cover;
}
/* Utility classes for modern dropdown icons */
.bg-primary-light { background-color: rgba(78, 115, 223, 0.1); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
.bg-warning-light { background-color: rgba(246, 194, 62, 0.1); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
.bg-danger-light { background-color: rgba(231, 74, 59, 0.1); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
.sidebar-dark .nav-item .nav-link {
    transition: all 0.3s ease;
}
.sidebar-dark .nav-item .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
    border-radius: 8px;
    margin: 0 10px;
    width: auto;
}
.sidebar-brand {
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 800;
}
.sidebar-brand-text {
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
</style>
<body id="page-top" class="page-fade-in">

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="preloader-text">MEMUAT...</div>
        </div>
    </div>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-modern-blue sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3"> Penggajian </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-fw fa-database"></i>
          <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('admin/data_pegawai') ?>">Data Pegawai</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_jabatan') ?>">Data Jabatan</a>
            <a class="collapse-item" href="<?php echo base_url('admin/hari_libur') ?>">Hari Libur Nasional</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-money-check-alt"></i>
          <span>Transaksi</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Absensi:</h6>
            <a class="collapse-item" href="<?php echo base_url('admin/absensi_harian') ?>">Monitoring Hari Ini</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_cuti') ?>">Pengajuan Cuti/Izin</a>
            <a class="collapse-item" href="<?php echo base_url('admin/absensi_harian/rekap') ?>">Rekap Absensi</a>
            <a class="collapse-item" href="<?php echo base_url('admin/absensi_harian/setting') ?>">Setting Absensi</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_absensi') ?>">Data Absensi (Lama)</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_lembur') ?>">Data Lembur</a>
            <h6 class="collapse-header">Gaji:</h6>
            <a class="collapse-item" href="<?php echo base_url('admin/potongan_gaji') ?>">Setting Potongan Gaji</a>
            <a class="collapse-item" href="<?php echo base_url('admin/komponen_gaji') ?>">Komponen Gaji</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_penggajian') ?>">Data Gaji</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-copy"></i>
          <span>Laporan</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('admin/laporan_gaji') ?>">Laporan Gaji</a>
            <a class="collapse-item" href="<?php echo base_url('admin/laporan_absensi') ?>">Laporan Absensi</a>
            <a class="collapse-item" href="<?php echo base_url('admin/laporan_pegawai') ?>">Laporan Pegawai</a>
            <a class="collapse-item" href="<?php echo base_url('admin/laporan_cuti') ?>">Laporan Cuti Pegawai</a>
            <a class="collapse-item" href="<?php echo base_url('admin/slip_gaji') ?>">Slip Gaji</a>
          </div>
        </div>
      </li>

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

            <!-- Nav Item - Alerts -->
            <?php 
              // Query untuk mengambil jumlah cuti & lembur yang menunggu persetujuan
              $notif_cuti = $this->db->query("SELECT * FROM data_cuti WHERE status_cuti='Menunggu'")->num_rows();
              $notif_lembur = $this->db->query("SELECT * FROM data_lembur WHERE status='Pending'")->num_rows();
              $total_notif = $notif_cuti + $notif_lembur;
            ?>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php if($total_notif > 0) { ?>
                  <span class="badge badge-danger badge-counter"><?php echo $total_notif ?></span>
                <?php } ?>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in p-0 border-0" aria-labelledby="alertsDropdown" style="border-radius: 12px; overflow: hidden; min-width: 320px;">
                <div class="dropdown-header bg-modern-blue text-white d-flex align-items-center justify-content-between" style="padding: 1rem; font-size: 0.9rem; letter-spacing: 1px;">
                  <span><i class="fas fa-bell mr-2"></i> PUSAT NOTIFIKASI</span>
                  <?php if($total_notif > 0) { ?>
                      <span class="badge badge-danger badge-pill shadow-sm"><?php echo $total_notif ?> Baru</span>
                  <?php } ?>
                </div>
                <div class="p-2">
                  <?php if($notif_cuti > 0) { ?>
                    <a class="dropdown-item d-flex align-items-center py-3 rounded mb-1" href="<?php echo base_url('admin/data_cuti') ?>" style="transition: all 0.2s; background-color: #f8f9fc;">
                      <div class="mr-3">
                        <div class="icon-circle bg-warning-light">
                          <i class="fas fa-file-signature text-warning"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-primary font-weight-bold mb-1"><i class="fas fa-calendar-day mr-1"></i> <?php echo date('d M Y') ?></div>
                        <span class="font-weight-bold text-gray-800 d-block" style="font-size: 0.95rem;">Pengajuan Cuti / Izin</span>
                        <span class="small text-muted"><?php echo $notif_cuti ?> pengajuan menunggu persetujuan Anda.</span>
                      </div>
                    </a>
                  <?php } ?>

                  <?php if($notif_lembur > 0) { ?>
                    <a class="dropdown-item d-flex align-items-center py-3 rounded mb-1" href="<?php echo base_url('admin/data_lembur') ?>" style="transition: all 0.2s; background-color: #f8f9fc;">
                      <div class="mr-3">
                        <div class="icon-circle bg-info-light" style="background-color: rgba(54, 185, 204, 0.1); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                          <i class="fas fa-clock text-info"></i>
                        </div>
                      </div>
                      <div>
                        <div class="small text-primary font-weight-bold mb-1"><i class="fas fa-calendar-day mr-1"></i> <?php echo date('d M Y') ?></div>
                        <span class="font-weight-bold text-gray-800 d-block" style="font-size: 0.95rem;">Pengajuan Lembur</span>
                        <span class="small text-muted"><?php echo $notif_lembur ?> pengajuan lembur menunggu di-approve.</span>
                      </div>
                    </a>
                  <?php } ?>

                  <?php if($total_notif == 0) { ?>
                    <div class="text-center py-4">
                      <div class="icon-circle bg-light mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
                      </div>
                      <span class="text-gray-500 font-weight-bold d-block">Semua Terkendali!</span>
                      <span class="small text-muted">Tidak ada notifikasi baru saat ini.</span>
                    </div>
                  <?php } ?>
                </div>
                <div class="dropdown-divider my-0"></div>
                <a class="dropdown-item text-center small text-primary font-weight-bold py-3 bg-light" href="<?php echo base_url('admin/dashboard') ?>" style="border-radius: 0 0 12px 12px;">Tutup Panel <i class="fas fa-times ml-1"></i></a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-light small font-weight-bold"><?php echo $this->session->userdata('nama_pegawai')?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url('photo/').$this->session->userdata('photo') ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-0 border-0" aria-labelledby="userDropdown" style="border-radius: 12px; overflow: hidden; min-width: 220px;">
                <!-- User Profile Header -->
                <div class="bg-modern-blue p-4 d-flex flex-column align-items-center justify-content-center text-center">
                    <img class="img-profile rounded-circle mb-2 shadow-sm" src="<?php echo base_url('photo/').$this->session->userdata('photo') ?>" style="width: 70px; height: 70px; border: 3px solid rgba(255,255,255,0.2);">
                    <h6 class="mb-0 font-weight-bold text-white"><?php echo $this->session->userdata('nama_pegawai')?></h6>
                    <span class="small text-white-50">Administrator</span>
                </div>
                
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center py-2 rounded" href="#">
                    <div class="icon-circle bg-primary-light mr-3">
                      <i class="fas fa-user text-primary"></i>
                    </div>
                    <span class="text-gray-800 font-weight-bold">Profil Saya</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center py-2 rounded" href="<?php echo base_url('ganti_password') ?>">
                    <div class="icon-circle bg-warning-light mr-3">
                      <i class="fas fa-key text-warning"></i>
                    </div>
                    <span class="text-gray-800 font-weight-bold">Ubah Password</span>
                  </a>
                  <div class="dropdown-divider my-2"></div>
                  <a class="dropdown-item d-flex align-items-center py-2 rounded" href="#" data-toggle="modal" data-target="#logoutModal">
                    <div class="icon-circle bg-danger-light mr-3">
                      <i class="fas fa-power-off text-danger"></i>
                    </div>
                    <span class="text-danger font-weight-bold">Logout Aplikasi</span>
                  </a>
                </div>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->