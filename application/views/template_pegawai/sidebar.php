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
                    <span class="small text-white-50">Staff Pegawai</span>
                </div>
                
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center py-2 rounded" href="#">
                    <div class="icon-circle bg-primary-light mr-3">
                      <i class="fas fa-user text-primary"></i>
                    </div>
                    <span class="text-gray-800 font-weight-bold">Profil Saya</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center py-2 rounded" href="<?php echo base_url('pegawai/ganti_password') ?>">
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