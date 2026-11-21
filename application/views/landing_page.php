<!DOCTYPE html>
<html lang="id">
<head>
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistem Informasi Kepegawaian dan Penggajian Terpadu dengan tiga portal peran berbeda untuk Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">
  <meta name="author" content="Klinik Pratama Dr. H.M. Hidayatullah">
  <title>HRIS & Penggajian | Klinik Pratama Dr. H.M. Hidayatullah</title>

  <link rel="shortcut icon" href="<?php echo base_url('assets/img/kpmh.png'); ?>" type="image/png">

  <!-- Typography: Source Serif 4 + Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Dedicated Landing Stylesheet -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/landing-page.css'); ?>?v=20261121">
</head>
<body>
  <a class="skip-link" href="#konten-utama">Lewati ke konten utama</a>

  <!-- Header & Navigation -->
  <header class="lp-header" role="banner">
    <div class="lp-nav-inner">
      <a class="lp-brand" href="#beranda">
        <img class="lp-brand-logo" src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Pratama Dr. H.M. Hidayatullah">
        <div>
          <div class="lp-brand-title">HRIS Klinik Hidayatullah</div>
          <div class="lp-brand-sub">Banjarbaru, Kalimantan Selatan</div>
        </div>
      </a>

      <nav aria-label="Navigasi utama">
        <ul class="lp-nav-list">
          <li><a class="lp-nav-link" href="#peran">Arsitektur 3 Peran</a></li>
          <li><a class="lp-nav-link" href="#alur">Alur Kerja</a></li>
          <li><a class="lp-nav-link" href="<?php echo base_url('verifikasi'); ?>">Verifikasi Dokumen</a></li>
          <li><a class="lp-nav-link" href="#faq">Tanya Jawab</a></li>
        </ul>
      </nav>

      <div class="lp-nav-actions">
        <button type="button" class="lp-icon-btn" id="landingDarkToggle" aria-label="Ubah tema terang atau gelap" title="Ubah tema">
          <i class="fas fa-moon" id="landingDarkIcon"></i>
        </button>

        <button type="button" class="lp-menu-btn" id="mobileMenuBtn" aria-expanded="false" aria-controls="mobileMenuDrawer">
          <i class="fas fa-bars"></i> <span>Menu</span>
        </button>

        <a class="lp-btn-primary lp-nav-login" href="<?php echo base_url('login'); ?>" style="min-height: 44px; padding: 0.55rem 1.05rem;">
          <i class="fas fa-right-to-bracket"></i> <span>Masuk Portal</span>
        </a>
      </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div class="lp-mobile-drawer" id="mobileMenuDrawer">
      <div class="lp-mobile-drawer-links">
        <a class="lp-nav-link" href="#peran">Arsitektur 3 Peran</a>
        <a class="lp-nav-link" href="#alur">Alur Kerja</a>
        <a class="lp-nav-link" href="<?php echo base_url('verifikasi'); ?>">Verifikasi Dokumen QR</a>
        <a class="lp-nav-link" href="#faq">Tanya Jawab</a>
        <a class="lp-nav-link" href="<?php echo base_url('lupa_password'); ?>">Pemulihan Kata Sandi</a>
        <a class="lp-btn-primary mt-2" href="<?php echo base_url('login'); ?>" style="width: 100%;">
          <i class="fas fa-right-to-bracket"></i> <span>Masuk ke Portal Login</span>
        </a>
      </div>
    </div>
  </header>

  <main id="konten-utama">
    <!-- BAND 1: HERO ASIMETRIS -->
    <section class="lp-hero" id="beranda">
      <div class="lp-wrap">
        <div class="lp-hero-grid">
          <div>
            <h1 class="lp-hero-title">Satu Sistem Kepegawaian, Tiga Ruang Kerja Sesuai Peran.</h1>
            <p class="lp-hero-lead">
              Sistem informasi kepegawaian, presensi shift, dan penggajian untuk <strong>Klinik Pratama Dr. H.M. Hidayatullah</strong>. Dirancang terpisah bagi Admin HRD, Pegawai medis maupun staf, serta Pimpinan klinik agar tiap peran langsung bekerja tanpa terganggu menu yang tidak relevan.
            </p>

            <div class="lp-hero-cta">
              <a class="lp-btn-primary" href="<?php echo base_url('login'); ?>">
                <i class="fas fa-right-to-bracket"></i> Masuk ke Portal Login
              </a>
              <a class="lp-btn-outline" href="#peran">
                Lihat Perbedaan 3 Portal
              </a>
            </div>

            <div class="lp-security-note">
              <span><i class="fas fa-lock mr-1"></i> Enkripsi sandi BCRYPT</span>
              <span><i class="fas fa-shield-halved mr-1"></i> Proteksi Google reCAPTCHA v2 & CSRF</span>
              <span><i class="fas fa-qrcode mr-1"></i> Validasi QR Code HMAC-SHA256</span>
            </div>
          </div>

          <!-- Architectural Role Index Card + Payroll Illustration -->
          <aside class="lp-role-index" aria-label="Ringkasan tiga portal peran">
            <div class="lp-illus-frame" style="margin-bottom: 1.15rem;">
              <img src="<?php echo base_url('assets/img/payroll.svg'); ?>" alt="Ilustrasi sistem penggajian dan manajemen kepegawaian Klinik Pratama Hidayatullah" style="max-height: 185px;">
            </div>

            <div class="lp-role-index-head">
              <strong class="lp-serif" style="font-size: 1.1rem;">Tiga Portal Aktif</strong>
              <span style="font-size: 0.78rem; color: var(--lp-muted);">Terisolasi per Hak Akses</span>
            </div>

            <div class="lp-role-row">
              <span class="lp-role-swatch" style="background: #0C2B4D;"></span>
              <div>
                <div class="lp-role-row-title">Admin / HRD</div>
                <div class="lp-role-row-desc">Panel operasional SB Admin dengan sidebar lengkap untuk master data, komponen gaji, dan proses payroll.</div>
              </div>
              <span class="lp-role-tag">Role 1</span>
            </div>

            <div class="lp-role-row">
              <span class="lp-role-swatch" style="background: #0F5132;"></span>
              <div>
                <div class="lp-role-row-title">Pegawai Klinik</div>
                <div class="lp-role-row-desc">Antarmuka mobile-first (Top-Nav + Bottom Bar) berpusat pada absen cepat, slip gaji, cuti, lembur, dan kasbon.</div>
              </div>
              <span class="lp-role-tag">Role 2</span>
            </div>

            <div class="lp-role-row">
              <span class="lp-role-swatch" style="background: #854D0E;"></span>
              <div>
                <div class="lp-role-row-title">Pimpinan / Direktur</div>
                <div class="lp-role-row-desc">Ringkasan eksekutif editorial tanpa sidebar untuk meja persetujuan, tren kehadiran, beban payroll, dan cetak/ekspor laporan.</div>
              </div>
              <span class="lp-role-tag">Role 3</span>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <!-- BAND 2: PITA DATA NYATA DARI DATABASE -->
    <section class="lp-ledger-band" id="metrik" aria-label="Statistik aktual sistem">
      <div class="lp-wrap">
        <div class="lp-ledger">
          <div class="lp-ledger-cell">
            <div class="lp-ledger-num"><?php echo isset($total_pegawai) ? (int)$total_pegawai : 0; ?></div>
            <div class="lp-ledger-label">Personel Terdaftar</div>
            <div class="lp-ledger-note">Tenaga kesehatan, staf administrasi, dan direksi aktif di basis data.</div>
          </div>
          <div class="lp-ledger-cell">
            <div class="lp-ledger-num"><?php echo isset($total_jabatan) ? (int)$total_jabatan : 0; ?></div>
            <div class="lp-ledger-label">Struktur Jabatan</div>
            <div class="lp-ledger-note">Skala gaji pokok, tunjangan transport, dan uang makan terstandar.</div>
          </div>
          <div class="lp-ledger-cell">
            <div class="lp-ledger-num"><?php echo isset($total_peran) ? (int)$total_peran : 3; ?></div>
            <div class="lp-ledger-label">Antarmuka Berbasis Peran</div>
            <div class="lp-ledger-note">Layout dan navigasi terpisah antara Admin, Pegawai, dan Pimpinan.</div>
          </div>
          <div class="lp-ledger-cell">
            <div class="lp-ledger-num"><?php echo isset($total_laporan) ? (int)$total_laporan : 9; ?></div>
            <div class="lp-ledger-label">Laporan & Dokumen Resmi</div>
            <div class="lp-ledger-note">Dilengkapi kop klinik, nomor surat, watermark, dan QR Code verifikasi.</div>
          </div>
        </div>
      </div>
    </section>

    <!-- BAND 3: SHOWCASE INTERAKTIF 3 PORTAL -->
    <section class="lp-showcase" id="peran">
      <div class="lp-wrap">
        <div class="lp-section-head">
          <div class="lp-section-kicker">Arsitektur Pengalaman Pengguna</div>
          <h2 class="lp-section-title">Antarmuka dibangun mengikuti cara kerja tiap peran</h2>
          <p class="lp-section-desc">
            Klik masing-masing peran di bawah ini untuk melihat perbedaan struktur navigasi, karakter visual, dan tugas utama yang ditangani pada setiap portal.
          </p>
        </div>

        <div class="lp-showcase-grid">
          <div class="lp-role-tabs" role="tablist" aria-label="Pilih peran untuk melihat pratinjau portal">
            <button type="button" class="lp-role-tab active" role="tab" id="tab-admin" aria-selected="true" aria-controls="panel-admin" data-role-tab="admin">
              <div class="lp-tab-num">Peran 01</div>
              <div class="lp-tab-title">Portal Admin / HRD</div>
              <div class="lp-tab-sub">Kontrol penuh master data, presensi, dan penggajian bulanan</div>
            </button>

            <button type="button" class="lp-role-tab" role="tab" id="tab-pegawai" aria-selected="false" aria-controls="panel-pegawai" data-role-tab="pegawai">
              <div class="lp-tab-num">Peran 02</div>
              <div class="lp-tab-title">Portal Mandiri Pegawai</div>
              <div class="lp-tab-sub">Mobile-first untuk absen shift cepat, cuti, lembur, dan slip gaji</div>
            </button>

            <button type="button" class="lp-role-tab" role="tab" id="tab-pimpinan" aria-selected="false" aria-controls="panel-pimpinan" data-role-tab="pimpinan">
              <div class="lp-tab-num">Peran 03</div>
              <div class="lp-tab-title">Portal Eksekutif Pimpinan</div>
              <div class="lp-tab-sub">Briefing harian, pengesahan akhir, grafik payroll, dan ekspor laporan</div>
            </button>
          </div>

          <div class="lp-role-stage">
            <!-- Panel Admin -->
            <div class="lp-stage-panel active" id="panel-admin" role="tabpanel" aria-labelledby="tab-admin">
              <div class="lp-stage-top">
                <div class="lp-wireframe">
                  <div class="lp-wf-bar" style="background: #0C2B4D; color: #FFFFFF;">
                    <span>PANEL ADMIN (SB ADMIN)</span>
                    <span>Sidebar</span>
                  </div>
                  <div class="lp-wf-body" style="display: grid; grid-template-columns: 96px 1fr; gap: 0.75rem;">
                    <div style="background: #0C2B4D; color: #DCE5EE; border-radius: 4px; padding: 0.6rem; font-size: 0.72rem;">
                      <div style="font-weight: 700; margin-bottom: 0.35rem;">Navigasi</div>
                      <div>Dashboard</div>
                      <div>Master Data</div>
                      <div>Transaksi</div>
                      <div>Laporan</div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.45rem;">
                      <div style="font-weight: 700;">Ruang Kerja Operasional HRD</div>
                      <div style="color: var(--lp-muted);">Mengelola database pegawai, struktur jabatan, pengaturan jam kerja, validasi lembur, komponen tunjangan/potongan, serta penerbitan payroll.</div>
                    </div>
                  </div>
                </div>
                <div class="lp-illus-frame">
                  <img src="<?php echo base_url('assets/img/administrator.svg'); ?>" alt="Ilustrasi pengelolaan administrasi HRD dan master data" style="max-height: 155px;">
                </div>
              </div>

              <h3 class="lp-serif" style="margin: 0 0 0.4rem 0; font-size: 1.3rem;">Kendali Operasional & Komputasi Payroll</h3>
              <p style="margin: 0; font-size: 0.9rem; color: var(--lp-muted);">
                Perhitungan kasbon memakai logika stateless agar pencetakan slip berulang tidak memotong saldo dua kali, disertai validasi silang jam pulang terhadap klaim lembur.
              </p>
              <ul class="lp-cap-list">
                <li><i class="fas fa-check"></i> CRUD pegawai, jabatan, hak akses, & hari libur</li>
                <li><i class="fas fa-check"></i> Sinkronisasi otomatis absensi harian ke payroll</li>
                <li><i class="fas fa-check"></i> Komponen tunjangan & potongan dinamis</li>
                <li><i class="fas fa-check"></i> Telaah awal berkas cuti sebelum ke Direktur</li>
              </ul>
            </div>

            <!-- Panel Pegawai -->
            <div class="lp-stage-panel" id="panel-pegawai" role="tabpanel" aria-labelledby="tab-pegawai">
              <div class="lp-stage-top">
                <div class="lp-wireframe">
                  <div class="lp-wf-bar" style="background: #134E4A; color: #FFFFFF;">
                    <span>PORTAL PEGAWAI</span>
                    <span>Mobile-First</span>
                  </div>
                  <div class="lp-wf-body">
                    <div style="display: flex; gap: 0.45rem; margin-bottom: 0.65rem; flex-wrap: wrap;">
                      <span style="padding: 0.2rem 0.5rem; border-radius: 4px; background: var(--lp-emerald-bg); color: var(--lp-emerald); font-weight: 700; font-size: 0.72rem;">Beranda</span>
                      <span style="padding: 0.2rem 0.5rem; border-radius: 4px; background: var(--lp-surface-alt); font-size: 0.72rem;">Absensi</span>
                      <span style="padding: 0.2rem 0.5rem; border-radius: 4px; background: var(--lp-surface-alt); font-size: 0.72rem;">Pengajuan</span>
                      <span style="padding: 0.2rem 0.5rem; border-radius: 4px; background: var(--lp-surface-alt); font-size: 0.72rem;">Slip Gaji</span>
                    </div>
                    <div style="background: #134E4A; color: #FFFFFF; border-radius: 6px; padding: 0.7rem;">
                      <div style="font-size: 0.7rem; opacity: 0.85;">FOKUS UTAMA LAYAR</div>
                      <div style="font-weight: 700;">Presensi Satu Ketukan + Layanan Mandiri</div>
                    </div>
                  </div>
                </div>
                <div class="lp-illus-frame">
                  <img src="<?php echo base_url('assets/img/others-fitur.svg'); ?>" alt="Ilustrasi kolaborasi shift dan layanan mandiri pegawai" style="max-height: 155px;">
                </div>
              </div>

              <h3 class="lp-serif" style="margin: 0 0 0.4rem 0; font-size: 1.3rem;">Layanan Mandiri Staf Tanpa Sidebar Ramai</h3>
              <p style="margin: 0; font-size: 0.9rem; color: var(--lp-muted);">
                Dirancang nyaman diakses tenaga medis dari ponsel saat pergantian shift maupun dari komputer meja, dengan navigasi bawah khusus ponsel dan target sentuh lega.
              </p>
              <ul class="lp-cap-list">
                <li><i class="fas fa-check"></i> Absen masuk/pulang sesuai gerbang waktu klinik</li>
                <li><i class="fas fa-check"></i> Ajukan cuti lengkap dengan rekan pengganti shift</li>
                <li><i class="fas fa-check"></i> Kalkulator durasi cuti & simulasi cicilan DSR</li>
                <li><i class="fas fa-check"></i> Cetak slip gaji, SK cuti, SPPK, & ganti foto mandiri</li>
              </ul>
            </div>

            <!-- Panel Pimpinan -->
            <div class="lp-stage-panel" id="panel-pimpinan" role="tabpanel" aria-labelledby="tab-pimpinan">
              <div class="lp-stage-top">
                <div class="lp-wireframe">
                  <div class="lp-wf-bar" style="background: #18293D; color: #FFFFFF;">
                    <span>PORTAL PIMPINAN</span>
                    <span>Editorial</span>
                  </div>
                  <div class="lp-wf-body">
                    <div style="display: flex; gap: 0.65rem; border-bottom: 1px solid var(--lp-border); padding-bottom: 0.45rem; margin-bottom: 0.6rem; font-size: 0.72rem; font-weight: 700; flex-wrap: wrap;">
                      <span style="border-bottom: 2px solid #854D0E; padding-bottom: 0.15rem;">Ringkasan</span>
                      <span style="color: var(--lp-muted);">Persetujuan</span>
                      <span style="color: var(--lp-muted);">Monitoring</span>
                      <span style="color: var(--lp-muted);">Laporan</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                      <div style="background: var(--lp-surface-alt); padding: 0.55rem; border-radius: 4px;">
                        <div style="font-size: 0.68rem; color: var(--lp-muted);">PAYROLL & SDM</div>
                        <div style="font-weight: 700; font-size: 0.78rem;">Tren 6 Bulan</div>
                      </div>
                      <div style="background: var(--lp-accent-bg); padding: 0.55rem; border-radius: 4px;">
                        <div style="font-size: 0.68rem; color: var(--lp-accent); font-weight: 700;">KEPUTUSAN</div>
                        <div style="font-weight: 700; font-size: 0.78rem;">Pengesahan Akhir</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="lp-illus-frame">
                  <img src="<?php echo base_url('assets/img/payroll.svg'); ?>" alt="Ilustrasi pemantauan laporan keuangan dan payroll pimpinan" style="max-height: 155px;">
                </div>
              </div>

              <h3 class="lp-serif" style="margin: 0 0 0.4rem 0; font-size: 1.3rem;">Pengawasan Strategis & Pengesahan Direktur</h3>
              <p style="margin: 0; font-size: 0.9rem; color: var(--lp-muted);">
                Menyajikan ringkasan kehadiran hari ini, tren pengeluaran gaji bulanan, serta meja persetujuan satu tempat agar keputusan pimpinan tercatat cepat dan transparan.
              </p>
              <ul class="lp-cap-list">
                <li><i class="fas fa-check"></i> Pengesahan akhir cuti, lembur, dan pinjaman</li>
                <li><i class="fas fa-check"></i> Grafik tren kehadiran & pengeluaran payroll 6 bulan</li>
                <li><i class="fas fa-check"></i> Monitoring presensi harian & direktori staf</li>
                <li><i class="fas fa-check"></i> Cetak 9 laporan resmi + unduh CSV untuk Excel</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- BAND 4: ALUR KERJA 4 TAHAP BERBASIS PERAN -->
    <section class="lp-workflow" id="alur">
      <div class="lp-wrap">
        <div class="lp-section-head">
          <div class="lp-section-kicker">Alur Operasional</div>
          <h2 class="lp-section-title">Dari presensi shift hingga dokumen sah terverifikasi</h2>
          <p class="lp-section-desc">Setiap tahapan menghubungkan Pegawai, Admin HRD, dan Pimpinan dalam satu sumber data yang sama.</p>
        </div>

        <div class="lp-flow-list">
          <div class="lp-flow-step">
            <div class="lp-flow-num">01</div>
            <div class="lp-flow-actor">Pegawai Klinik</div>
            <h3 class="lp-flow-title">Presensi & Pengajuan</h3>
            <p class="lp-flow-desc">Staf mencatat jam masuk/pulang harian serta mengajukan cuti (beserta pengganti shift), lembur, atau kasbon langsung dari Portal Pegawai.</p>
          </div>
          <div class="lp-flow-step">
            <div class="lp-flow-num">02</div>
            <div class="lp-flow-actor">Admin / HRD</div>
            <h3 class="lp-flow-title">Verifikasi & Komputasi</h3>
            <p class="lp-flow-desc">HRD menelaah kelengkapan berkas, melakukan validasi silang jam lembur terhadap waktu pulang aktual, dan memproses komponen payroll bulanan.</p>
          </div>
          <div class="lp-flow-step">
            <div class="lp-flow-num">03</div>
            <div class="lp-flow-actor">Pimpinan Klinik</div>
            <h3 class="lp-flow-title">Pengesahan & Audit</h3>
            <p class="lp-flow-desc">Direktur mengesahkan pengajuan cuti, lembur, dan pinjaman dari Meja Persetujuan sekaligus memantau tren kehadiran serta komitmen gaji bulanan.</p>
          </div>
          <div class="lp-flow-step">
            <div class="lp-flow-num">04</div>
            <div class="lp-flow-actor">Dokumen Digital</div>
            <h3 class="lp-flow-title">Cetak & Validasi QR</h3>
            <p class="lp-flow-desc">Slip gaji, SK cuti, SPPK, dan laporan resmi terbit lengkap dengan QR Code bertanda tangan HMAC-SHA256 yang dapat dicek keasliannya.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- BAND 5: VERIFIKASI DOKUMEN QR -->
    <section class="lp-verify-band" id="verifikasi-dokumen">
      <div class="lp-wrap">
        <div class="lp-verify-box">
          <div>
            <h2 class="lp-verify-title">Perlu memastikan keaslian slip gaji atau surat resmi klinik?</h2>
            <p class="lp-verify-text">
              Setiap dokumen cetak yang diterbitkan sistem HRIS Klinik Pratama Dr. H.M. Hidayatullah memiliki QR Code verifikasi digital. Pindai kode pada dokumen cetak atau buka halaman verifikasi untuk mencocokkannya dengan basis data resmi.
            </p>
          </div>
          <div>
            <a class="lp-btn-light" href="<?php echo base_url('verifikasi'); ?>">
              <i class="fas fa-qrcode"></i> Buka Verifikasi Dokumen
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- BAND 6: FAQ 2 KOLOM -->
    <section class="lp-faq" id="faq">
      <div class="lp-wrap">
        <div class="lp-faq-grid">
          <div>
            <div class="lp-section-kicker">Pertanyaan Teknis</div>
            <h2 class="lp-section-title">Hal yang sering ditanyakan</h2>
            <p class="lp-section-desc" style="margin-bottom: 1.5rem;">
              Penjelasan ringkas mengenai keamanan akun, perhitungan cicilan kasbon, validasi lembur, dan verifikasi dokumen resmi.
            </p>
            <a class="lp-btn-outline" href="<?php echo base_url('lupa_password'); ?>" style="min-height: 44px; padding: 0.55rem 1.05rem;">
              <i class="fas fa-key"></i> Pemulihan Akun (Lupa Password)
            </a>

            <div class="lp-illus-frame lp-faq-visual">
              <img src="<?php echo base_url('assets/img/others-fitur.svg'); ?>" alt="Ilustrasi integrasi modul kepegawaian, kolaborasi shift, dan keamanan sistem" style="max-height: 190px;">
            </div>
          </div>

          <div id="faqList">
            <div class="lp-faq-item">
              <button type="button" class="lp-faq-trigger" aria-expanded="true" aria-controls="faq-a1">
                <span>Mengapa tampilan Admin, Pegawai, dan Pimpinan dibuat berbeda?</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="lp-faq-answer" id="faq-a1">
                Setiap peran memiliki pola kerja berbeda. Admin HRD memerlukan sidebar bertingkat untuk mengelola banyak tabel master dan transaksi, Pegawai membutuhkan antarmuka ringkas yang cepat dijangkau ibu jari dari ponsel saat shift, sementara Pimpinan membutuhkan ringkasan eksekutif, meja persetujuan, dan akses laporan tanpa menu teknis operasional.
              </div>
            </div>

            <div class="lp-faq-item">
              <button type="button" class="lp-faq-trigger" aria-expanded="false" aria-controls="faq-a2">
                <span>Bagaimana sistem mencegah pemotongan kasbon ganda saat slip dicetak ulang?</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="lp-faq-answer" id="faq-a2" hidden>
                Perhitungan cicilan pinjaman berjalan secara stateless. Sistem menghitung bulan angsuran secara deterministik dari tanggal persetujuan dan tenor, bukan mengurangi saldo di database setiap kali halaman slip dibuka atau dicetak ulang.
              </div>
            </div>

            <div class="lp-faq-item">
              <button type="button" class="lp-faq-trigger" aria-expanded="false" aria-controls="faq-a3">
                <span>Bagaimana cara memvalidasi klaim jam lembur dan keaslian dokumen cetak?</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="lp-faq-answer" id="faq-a3" hidden>
                Klaim lembur divalidasi silang terhadap jam pulang aktual pegawai di tabel absensi harian. Sementara itu, setiap slip gaji, surat cuti, SPPK, dan laporan resmi memuat QR Code bertanda tangan HMAC-SHA256 yang merujuk langsung ke halaman verifikasi dokumen klinik.
              </div>
            </div>

            <div class="lp-faq-item">
              <button type="button" class="lp-faq-trigger" aria-expanded="false" aria-controls="faq-a4">
                <span>Bagaimana jika pegawai, admin, atau pimpinan lupa kata sandi?</span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="lp-faq-answer" id="faq-a4" hidden>
                Buka menu Lupa Password dari halaman login, lalu masukkan Username dan NIK resmi yang terdaftar beserta verifikasi Google reCAPTCHA. Setelah cocok, sesi reset sementara dibuka agar pengguna dapat menetapkan kata sandi baru berenkripsi BCRYPT.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer Klinik -->
  <footer class="lp-footer" id="kontak">
    <div class="lp-wrap">
      <div class="lp-footer-grid">
        <div>
          <div style="display: flex; align-items: center; gap: 0.7rem; margin-bottom: 0.85rem;">
            <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik" width="34" height="34" style="background: #FFFFFF; border-radius: 6px; padding: 2px;">
            <strong class="lp-serif" style="color: #FFFFFF; font-size: 1.05rem;">Klinik Pratama Dr. H.M. Hidayatullah</strong>
          </div>
          <p style="margin: 0; font-size: 0.88rem; max-width: 44ch;">
            Jl. A. Yani KM 23 Liang Anggang, Kota Banjarbaru, Kalimantan Selatan.<br>
            Telp: (0511) 4705000 &middot; Email: hrd@klinikhidayatullah.com
          </p>
        </div>

        <div>
          <h3 class="lp-footer-heading">Navigasi</h3>
          <ul class="lp-footer-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#peran">Arsitektur 3 Peran</a></li>
            <li><a href="#alur">Alur Kerja</a></li>
            <li><a href="#faq">Tanya Jawab</a></li>
          </ul>
        </div>

        <div>
          <h3 class="lp-footer-heading">Akses Layanan</h3>
          <ul class="lp-footer-links">
            <li><a href="<?php echo base_url('login'); ?>">Portal Login (Admin, Pegawai, Pimpinan)</a></li>
            <li><a href="<?php echo base_url('verifikasi'); ?>">Verifikasi Dokumen QR Code</a></li>
            <li><a href="<?php echo base_url('lupa_password'); ?>">Pemulihan Akun (Lupa Password)</a></li>
          </ul>
        </div>
      </div>

      <div class="lp-footer-bottom">
        <span>&copy; <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah.</span>
        <span>Sistem Informasi Kepegawaian & Penggajian Berbasis Peran.</span>
      </div>
    </div>
  </footer>

  <script>
  (function() {
    // 1. Theme Toggle
    var toggleBtn  = document.getElementById('landingDarkToggle');
    var toggleIcon = document.getElementById('landingDarkIcon');

    function syncTheme(isDark) {
      document.documentElement.classList.toggle('dark-mode', isDark);
      document.body.classList.toggle('dark-mode', isDark);
      localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
      if (toggleIcon) {
        toggleIcon.classList.toggle('fa-sun', isDark);
        toggleIcon.classList.toggle('fa-moon', !isDark);
      }
    }

    syncTheme(localStorage.getItem('darkMode') === 'enabled');

    if (toggleBtn) {
      toggleBtn.addEventListener('click', function() {
        syncTheme(!document.documentElement.classList.contains('dark-mode'));
      });
    }

    // 2. Mobile Menu Drawer (Explicit Labeled Menu + Escape Close)
    var menuBtn    = document.getElementById('mobileMenuBtn');
    var menuDrawer = document.getElementById('mobileMenuDrawer');
    if (menuBtn && menuDrawer) {
      menuBtn.addEventListener('click', function() {
        var open = menuDrawer.classList.toggle('open');
        menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      menuDrawer.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
          menuDrawer.classList.remove('open');
          menuBtn.setAttribute('aria-expanded', 'false');
        });
      });
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && menuDrawer.classList.contains('open')) {
          menuDrawer.classList.remove('open');
          menuBtn.setAttribute('aria-expanded', 'false');
          menuBtn.focus();
        }
      });
    }

    // 3. Interactive 3-Role Portal Showcase Tabs
    var roleTabs   = document.querySelectorAll('[data-role-tab]');
    var rolePanels = document.querySelectorAll('.lp-stage-panel');

    roleTabs.forEach(function(tab) {
      tab.addEventListener('click', function() {
        var key = this.getAttribute('data-role-tab');
        roleTabs.forEach(function(t) {
          var isSelected = (t === tab);
          t.classList.toggle('active', isSelected);
          t.setAttribute('aria-selected', isSelected ? 'true' : 'false');
        });
        rolePanels.forEach(function(panel) {
          panel.classList.toggle('active', panel.id === 'panel-' + key);
        });
      });
    });

    // 4. Accessible FAQ Accordion
    document.querySelectorAll('.lp-faq-trigger').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var expanded = this.getAttribute('aria-expanded') === 'true';
        var panelId  = this.getAttribute('aria-controls');
        var panel    = document.getElementById(panelId);
        this.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if (panel) panel.hidden = expanded;
      });
    });
  })();
  </script>
</body>
</html>
