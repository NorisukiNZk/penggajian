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
            <a class="collapse-item" href="<?php echo base_url('admin/data_pegawai/akumulasi') ?>">Laporan Pegawai</a>
            <a class="collapse-item" href="<?php echo base_url('admin/data_pegawai/rekapitulasi') ?>">Rekapitulasi Libur</a>
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

          <h4 class="font-weight-bold text-white mb-0">KLINIK PRATAMA DR. HIDAYATULLAH</h4>

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
              // Query untuk mengambil jumlah cuti yang menunggu persetujuan
              $notif_cuti = $this->db->query("SELECT * FROM data_cuti WHERE status_cuti='Menunggu'")->num_rows();
            ?>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php if($notif_cuti > 0) { ?>
                  <span class="badge badge-danger badge-counter"><?php echo $notif_cuti ?></span>
                <?php } ?>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Pusat Notifikasi
                </h6>
                <?php if($notif_cuti > 0) { ?>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('admin/data_cuti') ?>">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-file-alt text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500"><?php echo date('d M Y') ?></div>
                      <span class="font-weight-bold">Ada <?php echo $notif_cuti ?> pengajuan cuti/izin baru yang menunggu persetujuan!</span>
                    </div>
                  </a>
                <?php } else { ?>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Tidak ada notifikasi baru</a>
                <?php } ?>
                <a class="dropdown-item text-center small text-gray-500" href="<?php echo base_url('admin/data_cuti') ?>">Lihat Semua Pengajuan</a>
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