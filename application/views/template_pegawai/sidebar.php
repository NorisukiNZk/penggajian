<?php
  $seg2 = strtolower((string)$this->uri->segment(2));
  $seg3 = strtolower((string)$this->uri->segment(3));

  $is_dashboard = ($seg2 === 'dashboard' || $seg2 === '');
  $is_absensi   = ($seg2 === 'absensi' && $seg3 !== 'riwayat');
  $is_riwayat   = ($seg2 === 'absensi' && $seg3 === 'riwayat');
  $is_cuti      = ($seg2 === 'cuti');
  $is_lembur    = ($seg2 === 'lembur');
  $is_pinjaman  = ($seg2 === 'pinjaman');
  $is_gaji      = ($seg2 === 'data_gaji');
  $is_pengajuan = ($is_cuti || $is_lembur || $is_pinjaman);

  $nik_user   = $this->session->userdata('nik');
  $nama_user  = $this->session->userdata('nama_pegawai') ?: 'Pegawai';
  $jabatan_u  = $this->session->userdata('jabatan') ?: 'Staf Klinik';
  $photo_user = $this->session->userdata('photo') ?: 'kpmh.jpg';

  $notif_cuti_user     = $this->db->query("SELECT * FROM data_cuti WHERE nik = ? ORDER BY id_cuti DESC LIMIT 2", array($nik_user))->result();
  $notif_pinjaman_user = $this->db->query("SELECT * FROM data_pinjaman WHERE nik = ? ORDER BY id_pinjaman DESC LIMIT 2", array($nik_user))->result();
  $total_notif_user    = count($notif_cuti_user) + count($notif_pinjaman_user);
?>
<body id="page-top">
  <a class="skip-link" href="#emp-main">Lewati ke konten utama</a>

  <!-- Top Navigation Header (Desktop Horizontal Nav + Tablet Drawer + Mobile Compact Header) -->
  <header class="emp-topbar" role="banner">
    <div class="emp-topbar-inner">
      <!-- Brand Identity -->
      <a class="emp-brand" href="<?php echo base_url('pegawai/dashboard'); ?>">
        <img class="emp-brand-logo" src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Hidayatullah">
        <div>
          <div class="emp-brand-name">Portal Pegawai</div>
          <div class="emp-brand-sub">Klinik Pratama Hidayatullah</div>
        </div>
      </a>

      <!-- Desktop Horizontal Primary Nav -->
      <nav aria-label="Navigasi utama pegawai">
        <ul class="emp-nav-links">
          <li>
            <a class="emp-nav-link <?php echo $is_dashboard ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/dashboard'); ?>">
              <i class="fas fa-house"></i> Beranda
            </a>
          </li>
          <li>
            <a class="emp-nav-link <?php echo $is_absensi ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/absensi'); ?>">
              <i class="fas fa-fingerprint"></i> Absensi
            </a>
          </li>
          <li class="dropdown">
            <button type="button" class="emp-nav-link dropdown-toggle <?php echo $is_pengajuan ? 'active' : ''; ?>" id="pengajuanMenuBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-signature"></i> Pengajuan
            </button>
            <div class="dropdown-menu emp-dropdown-menu" aria-labelledby="pengajuanMenuBtn">
              <a class="emp-dropdown-item <?php echo $is_cuti ? 'text-primary' : ''; ?>" href="<?php echo base_url('pegawai/cuti'); ?>">
                <i class="fas fa-calendar-minus fa-fw"></i> Cuti & Izin
              </a>
              <a class="emp-dropdown-item <?php echo $is_lembur ? 'text-primary' : ''; ?>" href="<?php echo base_url('pegawai/lembur'); ?>">
                <i class="fas fa-business-time fa-fw"></i> Lembur
              </a>
              <a class="emp-dropdown-item <?php echo $is_pinjaman ? 'text-primary' : ''; ?>" href="<?php echo base_url('pegawai/pinjaman'); ?>">
                <i class="fas fa-hand-holding-dollar fa-fw"></i> Pinjaman (Kasbon)
              </a>
            </div>
          </li>
          <li>
            <a class="emp-nav-link <?php echo $is_gaji ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/data_gaji'); ?>">
              <i class="fas fa-receipt"></i> Slip Gaji
            </a>
          </li>
          <li>
            <a class="emp-nav-link <?php echo $is_riwayat ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/absensi/riwayat'); ?>">
              <i class="fas fa-calendar-check"></i> Riwayat
            </a>
          </li>
        </ul>
      </nav>

      <!-- Utility Actions -->
      <div class="emp-topbar-actions">
        <div class="emp-clock-pill" id="live-clock" aria-live="off">
          <i class="fas fa-clock"></i> <span>--:--:--</span>
        </div>

        <!-- Tablet Menu Button (Explicitly Labeled) -->
        <button type="button" class="emp-tablet-menu-btn" id="tabletMenuToggle" aria-expanded="false" aria-controls="tabletDrawer">
          <i class="fas fa-bars"></i> <span>Menu</span>
        </button>

        <!-- Theme Toggle -->
        <button type="button" class="emp-icon-btn" id="darkModeToggle" aria-label="Ubah tema terang atau gelap" title="Ubah tema">
          <i class="fas fa-moon" id="darkModeIcon"></i>
        </button>

        <!-- Notification Dropdown -->
        <div class="dropdown">
          <button type="button" class="emp-icon-btn" id="notifDropdownPegawai" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Status pengajuan terbaru">
            <i class="fas fa-bell"></i>
            <?php if ($total_notif_user > 0) : ?>
              <span class="emp-notif-count"><?php echo $total_notif_user; ?></span>
            <?php endif; ?>
          </button>
          <div class="dropdown-menu dropdown-menu-right emp-dropdown-menu" aria-labelledby="notifDropdownPegawai" style="min-width: 300px;">
            <div class="px-2 py-2 border-bottom d-flex justify-content-between align-items-center">
              <span class="font-weight-bold small">Status Pengajuan Terkini</span>
              <span class="small text-muted"><?php echo $total_notif_user; ?> item</span>
            </div>
            <div class="py-1">
              <?php if (!empty($notif_cuti_user)) : ?>
                <?php foreach ($notif_cuti_user as $nc) : ?>
                  <a class="emp-dropdown-item" href="<?php echo base_url('pegawai/cuti'); ?>">
                    <i class="fas fa-calendar-minus fa-fw text-primary"></i>
                    <div class="flex-grow-1">
                      <div class="small font-weight-bold">Cuti <?php echo htmlspecialchars($nc->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></div>
                      <div class="small text-muted"><?php echo date('d M Y', strtotime($nc->tanggal_mulai)); ?> &middot; <?php echo htmlspecialchars($nc->status_cuti, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
              <?php if (!empty($notif_pinjaman_user)) : ?>
                <?php foreach ($notif_pinjaman_user as $np) : ?>
                  <a class="emp-dropdown-item" href="<?php echo base_url('pegawai/pinjaman'); ?>">
                    <i class="fas fa-hand-holding-dollar fa-fw text-primary"></i>
                    <div class="flex-grow-1">
                      <div class="small font-weight-bold">Kasbon Rp <?php echo number_format($np->jumlah_pinjaman, 0, ',', '.'); ?></div>
                      <div class="small text-muted">Status: <?php echo htmlspecialchars($np->status, ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
              <?php if ($total_notif_user === 0) : ?>
                <div class="p-3 text-center small text-muted">
                  Belum ada pengajuan cuti atau kasbon tercatat.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- User Account Dropdown -->
        <div class="dropdown">
          <button type="button" class="emp-user-btn" id="userDropdownPegawai" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="emp-user-avatar" src="<?php echo base_url('photo/' . $photo_user); ?>" alt="<?php echo htmlspecialchars($nama_user, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="emp-user-meta">
              <div class="emp-user-name"><?php echo htmlspecialchars($nama_user, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="emp-user-role"><?php echo htmlspecialchars($jabatan_u, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <i class="fas fa-chevron-down small text-muted d-none d-md-inline"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right emp-dropdown-menu" aria-labelledby="userDropdownPegawai">
            <div class="px-2 py-2 border-bottom">
              <div class="font-weight-bold small"><?php echo htmlspecialchars($nama_user, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small text-muted">NIK: <?php echo htmlspecialchars((string)$nik_user, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <a class="emp-dropdown-item" href="<?php echo base_url('pegawai/dashboard'); ?>">
              <i class="fas fa-id-badge fa-fw"></i> Profil & Beranda
            </a>
            <a class="emp-dropdown-item" href="<?php echo base_url('pegawai/ganti_password'); ?>">
              <i class="fas fa-shield-halved fa-fw"></i> Keamanan & Password
            </a>
            <div class="emp-dropdown-divider"></div>
            <a class="emp-dropdown-item text-danger btn-logout-swal" href="<?php echo base_url('login/logout'); ?>" data-user="<?php echo htmlspecialchars($nama_user, ENT_QUOTES, 'UTF-8'); ?>" data-role="Pegawai">
              <i class="fas fa-power-off fa-fw"></i> Keluar Aplikasi
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Tablet Drawer Navigation (640px - 991px) -->
  <nav id="tabletDrawer" class="emp-tablet-drawer" aria-label="Menu navigasi tablet">
    <div class="emp-tablet-drawer-grid">
      <a class="emp-nav-link <?php echo $is_dashboard ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/dashboard'); ?>"><i class="fas fa-house"></i> Beranda</a>
      <a class="emp-nav-link <?php echo $is_absensi ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/absensi'); ?>"><i class="fas fa-fingerprint"></i> Absensi</a>
      <a class="emp-nav-link <?php echo $is_riwayat ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/absensi/riwayat'); ?>"><i class="fas fa-calendar-check"></i> Riwayat Absensi</a>
      <a class="emp-nav-link <?php echo $is_cuti ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/cuti'); ?>"><i class="fas fa-calendar-minus"></i> Cuti & Izin</a>
      <a class="emp-nav-link <?php echo $is_lembur ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/lembur'); ?>"><i class="fas fa-business-time"></i> Lembur</a>
      <a class="emp-nav-link <?php echo $is_gaji ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/data_gaji'); ?>"><i class="fas fa-receipt"></i> Slip Gaji</a>
      <a class="emp-nav-link <?php echo $is_pinjaman ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/pinjaman'); ?>"><i class="fas fa-hand-holding-dollar"></i> Pinjaman</a>
      <a class="emp-nav-link" href="<?php echo base_url('pegawai/ganti_password'); ?>"><i class="fas fa-shield-halved"></i> Ganti Password</a>
    </div>
  </nav>

  <!-- Mobile Bottom Navigation Bar (< 640px) -->
  <nav class="emp-bottom-nav" aria-label="Navigasi bawah ponsel">
    <a class="emp-bottom-item <?php echo $is_dashboard ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/dashboard'); ?>">
      <i class="fas fa-house"></i>
      <span>Beranda</span>
    </a>
    <a class="emp-bottom-item <?php echo $is_absensi ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/absensi'); ?>">
      <i class="fas fa-fingerprint"></i>
      <span>Absen</span>
    </a>
    <a class="emp-bottom-item <?php echo $is_cuti ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/cuti'); ?>">
      <i class="fas fa-calendar-minus"></i>
      <span>Cuti</span>
    </a>
    <a class="emp-bottom-item <?php echo $is_gaji ? 'active' : ''; ?>" href="<?php echo base_url('pegawai/data_gaji'); ?>">
      <i class="fas fa-receipt"></i>
      <span>Gaji</span>
    </a>
    <button type="button" class="emp-bottom-item <?php echo ($is_riwayat || $is_lembur || $is_pinjaman) ? 'active' : ''; ?>" id="mobileSheetToggle" aria-expanded="false" aria-controls="mobileSheet">
      <i class="fas fa-bars"></i>
      <span>Lainnya</span>
    </button>
  </nav>

  <!-- Mobile Sheet for Secondary Destinations -->
  <div class="emp-sheet-backdrop" id="mobileSheetBackdrop"></div>
  <div class="emp-sheet" id="mobileSheet" role="dialog" aria-modal="true" aria-labelledby="mobileSheetTitle">
    <div class="emp-sheet-header">
      <h6 class="m-0 font-weight-bold" id="mobileSheetTitle">Menu Lainnya</h6>
      <button type="button" class="emp-icon-btn" id="mobileSheetClose" aria-label="Tutup menu">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="emp-sheet-grid">
      <a class="emp-sheet-link" href="<?php echo base_url('pegawai/absensi/riwayat'); ?>">
        <i class="fas fa-calendar-check text-primary"></i> Riwayat Absensi
      </a>
      <a class="emp-sheet-link" href="<?php echo base_url('pegawai/lembur'); ?>">
        <i class="fas fa-business-time text-primary"></i> Lembur
      </a>
      <a class="emp-sheet-link" href="<?php echo base_url('pegawai/pinjaman'); ?>">
        <i class="fas fa-hand-holding-dollar text-primary"></i> Pinjaman
      </a>
      <a class="emp-sheet-link" href="<?php echo base_url('pegawai/ganti_password'); ?>">
        <i class="fas fa-shield-halved text-primary"></i> Ganti Password
      </a>
    </div>
    <div class="mt-3">
      <a class="btn btn-outline-danger btn-block btn-logout-swal" href="<?php echo base_url('login/logout'); ?>" data-user="<?php echo htmlspecialchars($nama_user, ENT_QUOTES, 'UTF-8'); ?>" data-role="Pegawai">
        <i class="fas fa-power-off"></i> Keluar dari Portal Pegawai
      </a>
    </div>
  </div>

  <!-- Main Workspace Content Container -->
  <main id="emp-main" class="emp-shell" role="main">
