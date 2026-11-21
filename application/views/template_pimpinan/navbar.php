<?php
  $seg2 = strtolower((string)$this->uri->segment(2));
  $is_dash   = ($seg2 === 'dashboard' || $seg2 === '');
  $is_appr   = ($seg2 === 'persetujuan');
  $is_mon    = ($seg2 === 'monitoring');
  $is_lap    = ($seg2 === 'laporan');

  $nama_pimpinan = $this->session->userdata('nama_pegawai') ?: 'Pimpinan Klinik';
  $jabatan_pimp  = $this->session->userdata('jabatan') ?: 'Direktur Utama';
  $photo_pimp    = $this->session->userdata('photo') ?: 'kpmh.jpg';

  // Hitung antrean persetujuan aktual dari database
  $q_c = $this->db->query("SELECT COUNT(*) AS total FROM data_cuti WHERE status_cuti IN ('Menunggu', 'Pending')")->row();
  $q_l = $this->db->query("SELECT COUNT(*) AS total FROM data_lembur WHERE status IN ('Pending', 'Menunggu')")->row();
  $q_p = $this->db->query("SELECT COUNT(*) AS total FROM data_pinjaman WHERE status IN ('Pending', 'Menunggu')")->row();

  $pending_cuti_nav     = $q_c ? (int)$q_c->total : 0;
  $pending_lembur_nav   = $q_l ? (int)$q_l->total : 0;
  $pending_pinjaman_nav = $q_p ? (int)$q_p->total : 0;
  $total_pending_nav    = $pending_cuti_nav + $pending_lembur_nav + $pending_pinjaman_nav;

  $hari_indo  = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
  $bulan_indo = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
  $dateline   = $hari_indo[date('l')] . ', ' . date('d') . ' ' . $bulan_indo[date('m')] . ' ' . date('Y');
?>
<body id="page-top">
  <a class="skip-link" href="#exec-main">Lewati ke konten utama</a>

  <header class="exec-header" role="banner">
    <!-- Top Editorial Masthead -->
    <div class="exec-masthead">
      <a class="exec-brand" href="<?php echo base_url('pimpinan/dashboard'); ?>">
        <img class="exec-brand-logo" src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Hidayatullah">
        <div>
          <div class="exec-brand-kicker">Portal Pimpinan</div>
          <div class="exec-brand-title">Klinik Pratama Dr. H.M. Hidayatullah</div>
        </div>
      </a>

      <div class="exec-masthead-meta">
        <span class="exec-dateline"><?php echo $dateline; ?></span>

        <button type="button" class="exec-icon-btn" id="darkModeToggle" aria-label="Ubah tema terang atau gelap" title="Ubah tema">
          <i class="fas fa-moon" id="darkModeIcon"></i>
        </button>

        <div class="dropdown">
          <button type="button" class="exec-profile-btn" id="execUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="exec-profile-avatar" src="<?php echo base_url('photo/' . $photo_pimp); ?>" alt="<?php echo htmlspecialchars($nama_pimpinan, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="exec-profile-text">
              <div class="font-weight-bold small" style="color: var(--exec-ink);"><?php echo htmlspecialchars($nama_pimpinan, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small text-muted" style="font-size: 0.72rem;"><?php echo htmlspecialchars($jabatan_pimp, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <i class="fas fa-chevron-down small text-muted d-none d-md-inline"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right exec-dropdown" aria-labelledby="execUserMenu">
            <div class="px-2 py-2 border-bottom">
              <div class="font-weight-bold small"><?php echo htmlspecialchars($nama_pimpinan, ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="small text-muted"><?php echo htmlspecialchars($jabatan_pimp, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <a class="exec-dropdown-item" href="<?php echo base_url('pimpinan/dashboard'); ?>">
              <i class="fas fa-newspaper fa-fw"></i> Ringkasan Eksekutif
            </a>
            <a class="exec-dropdown-item" href="<?php echo base_url('pimpinan/ganti_password'); ?>">
              <i class="fas fa-shield-halved fa-fw"></i> Keamanan & Password
            </a>
            <div class="border-top my-1"></div>
            <a class="exec-dropdown-item is-danger btn-logout-swal" href="<?php echo base_url('login/logout'); ?>" data-user="<?php echo htmlspecialchars($nama_pimpinan, ENT_QUOTES, 'UTF-8'); ?>">
              <i class="fas fa-power-off fa-fw"></i> Keluar Aplikasi
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Editorial Category Strip (Zero Sidebar) -->
    <nav class="exec-catnav-wrap" aria-label="Navigasi domain pimpinan">
      <ul class="exec-catnav">
        <li>
          <a class="exec-catlink <?php echo $is_dash ? 'active' : ''; ?>" href="<?php echo base_url('pimpinan/dashboard'); ?>">
            <i class="fas fa-compass"></i> Ringkasan Eksekutif
          </a>
        </li>
        <li>
          <a class="exec-catlink <?php echo $is_appr ? 'active' : ''; ?>" href="<?php echo base_url('pimpinan/persetujuan'); ?>">
            <i class="fas fa-stamp"></i> Persetujuan
            <?php if ($total_pending_nav > 0) : ?>
              <span class="exec-pending-pill" title="<?php echo $total_pending_nav; ?> permohonan menunggu keputusan"><?php echo $total_pending_nav; ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li>
          <a class="exec-catlink <?php echo $is_mon ? 'active' : ''; ?>" href="<?php echo base_url('pimpinan/monitoring'); ?>">
            <i class="fas fa-users-line"></i> Monitoring SDM
          </a>
        </li>
        <li>
          <a class="exec-catlink <?php echo $is_lap ? 'active' : ''; ?>" href="<?php echo base_url('pimpinan/laporan'); ?>">
            <i class="fas fa-file-lines"></i> Pusat Laporan
          </a>
        </li>
      </ul>

      <a class="exec-quick-print" href="<?php echo base_url('pimpinan/laporan'); ?>">
        <i class="fas fa-print"></i> Arsip & Cetak Laporan
      </a>
    </nav>
  </header>

  <main id="exec-main" class="exec-main" role="main">
