<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pemulihan Akun SSO | HRIS Klinik Pratama Dr. H.M. Hidayatullah</title>
  <meta name="description" content="Verifikasi Identitas Pegawai untuk Pemulihan Kata Sandi HRIS Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">

  <link rel="shortcut icon" href="<?php echo base_url('assets/img/kpmh.png'); ?>" type="image/png">

  <!-- Pre-render Theme Check (Anti-FOUC) -->
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <!-- Typography: Source Serif 4 + Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Unified Auth Portal Stylesheet -->
  <link href="<?php echo base_url('assets/css/auth-portal.css'); ?>?v=20261121" rel="stylesheet">

  <!-- Google reCAPTCHA v2 -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

  <!-- Top Floating Utility Bar -->
  <header class="top-utility-bar" aria-label="Navigasi Akses Cepat">
    <a href="<?php echo base_url('login'); ?>" class="btn-utility-link">
      <i class="fas fa-arrow-left" aria-hidden="true"></i>
      <span>Kembali ke Halaman Login</span>
    </a>

    <div class="top-actions-right">
      <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Beralih Tema Gelap/Terang" aria-label="Beralih Tema">
        <i class="fas fa-moon" id="themeIcon" aria-hidden="true"></i>
      </button>
    </div>
  </header>

  <!-- Main Auth Card -->
  <main class="auth-wrapper">
    <div class="auth-card">

      <!-- Sisi Kiri: Panel Informasi Pemulihan Akun -->
      <section class="brand-panel" aria-label="Informasi Pemulihan Akun">
        <div class="brand-content">
          <div class="brand-logo-pod">
            <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>

          <span class="brand-badge">
            <i class="fas fa-key" aria-hidden="true"></i> PEMULIHAN AKUN RESMI
          </span>

          <h1 class="brand-title">Atur Ulang Kata Sandi</h1>
          <p class="brand-description">
            Verifikasi data identitas resmi kepegawaian Anda untuk memulihkan akses akun dengan aman.
          </p>

          <!-- 3-Step Breadcrumb Stepper -->
          <div class="recovery-steps-list">
            <div class="recovery-step-item is-active">
              <span class="step-number-badge">1</span>
              <div class="step-text-group">
                <h4>Input Identitas Kepegawaian</h4>
                <p>Masukkan Username SSO dan NIK pegawai terdaftar</p>
              </div>
            </div>

            <div class="recovery-step-item">
              <span class="step-number-badge">2</span>
              <div class="step-text-group">
                <h4>Validasi Database Klinik</h4>
                <p>Pencocokan otomatis dengan basis data kepegawaian</p>
              </div>
            </div>

            <div class="recovery-step-item">
              <span class="step-number-badge">3</span>
              <div class="step-text-group">
                <h4>Atur Kata Sandi Baru</h4>
                <p>Buat kata sandi baru minimal 8 karakter terenkripsi BCRYPT</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-shield-halved" aria-hidden="true"></i>
          <span>Validasi Identitas Ganda Terenkripsi</span>
        </div>
      </section>

      <!-- Sisi Kanan: Formulir Verifikasi Identitas -->
      <section class="form-container" aria-label="Formulir Verifikasi Identitas">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-user-shield" aria-hidden="true"></i> TAHAP 1 &bull; VERIFIKASI KEAMANAN
          </span>
          <h2 class="auth-title">Verifikasi Identitas Pegawai</h2>
          <p class="auth-subtitle">Masukkan Username SSO dan NIK yang terdaftar pada sistem klinik.</p>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password'); ?>" novalidate id="formRecovery">

          <!-- Username Input -->
          <div class="form-group mb-3">
            <label class="form-label" for="username">
              <span>Username SSO</span>
            </label>
            <div class="input-wrapper" id="usernameWrapper">
              <input type="text" class="form-control-modern" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username SSO..." required autofocus autocomplete="username">
              <i class="fas fa-user input-icon-left" aria-hidden="true"></i>
              <button type="button" class="input-clear-btn" id="clearUsernameBtn" title="Hapus teks" aria-label="Hapus teks username">
                <i class="fas fa-circle-xmark" aria-hidden="true"></i>
              </button>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- NIK Input -->
          <div class="form-group mb-4">
            <label class="form-label" for="nik">
              <span>Nomor Induk Kependudukan (NIK)</span>
              <span class="label-counter" id="nikCounter">0 / 16 Digit</span>
            </label>
            <div class="input-wrapper" id="nikWrapper">
              <input type="text" class="form-control-modern" id="nik" name="nik" value="<?php echo set_value('nik'); ?>" placeholder="Masukkan 16 digit NIK pegawai..." required autocomplete="off" inputmode="numeric" maxlength="16">
              <i class="fas fa-id-card input-icon-left" aria-hidden="true"></i>
              <button type="button" class="input-clear-btn" id="clearNikBtn" title="Hapus teks" aria-label="Hapus teks NIK">
                <i class="fas fa-circle-xmark" aria-hidden="true"></i>
              </button>
            </div>
            <?php echo form_error('nik', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- reCAPTCHA Widget -->
          <div class="recaptcha-wrapper">
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars((string)$this->config->item('recaptcha_site_key'), ENT_QUOTES, 'UTF-8'); ?>"></div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-auth-primary" id="btnSubmitRecovery">
            <span>Verifikasi Identitas Pegawai</span>
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
          </button>

          <!-- Back Button -->
          <a href="<?php echo base_url('login'); ?>" class="btn-back-outline">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            <span>Kembali ke Halaman Login</span>
          </a>

          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <div class="form-footer-copyright">
          <small>&copy; <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah &bull; Seluruh Hak Dilindungi</small>
        </div>
      </section>

    </div>
  </main>

  <!-- Scripts -->
  <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

  <script>
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');

    function isDarkModeActive() {
      return document.documentElement.classList.contains('dark-mode');
    }

    function syncThemeUI(isDark) {
      if (isDark) {
        document.documentElement.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        if (themeIcon) themeIcon.className = 'fas fa-sun';
      } else {
        document.documentElement.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        if (themeIcon) themeIcon.className = 'fas fa-moon';
      }
    }

    if (localStorage.getItem('darkMode') === 'enabled') {
      syncThemeUI(true);
    }

    if (themeToggleBtn) {
      themeToggleBtn.addEventListener('click', () => {
        syncThemeUI(!isDarkModeActive());
      });
    }

    function swalThemeOptions() {
      return isDarkModeActive()
        ? { background: '#171F2A', color: '#F1EFEA' }
        : { background: '#FFFDF9', color: '#141D26' };
    }

    const usernameInput = document.getElementById('username');
    const usernameWrapper = document.getElementById('usernameWrapper');
    const clearUsernameBtn = document.getElementById('clearUsernameBtn');

    const nikInput = document.getElementById('nik');
    const nikWrapper = document.getElementById('nikWrapper');
    const clearNikBtn = document.getElementById('clearNikBtn');
    const nikCounter = document.getElementById('nikCounter');

    function toggleClearBtn(input, wrapper) {
      if (input && wrapper) {
        wrapper.classList.toggle('has-value', input.value.trim().length > 0);
      }
    }

    function updateNikCounter() {
      if (!nikInput || !nikCounter) return;
      nikInput.value = nikInput.value.replace(/[^0-9]/g, '');
      const len = nikInput.value.length;
      nikCounter.textContent = `${len} / 16 Digit`;
      nikCounter.style.color = (len === 16) ? 'var(--auth-emerald)' : 'var(--auth-muted)';
      toggleClearBtn(nikInput, nikWrapper);
    }

    if (usernameInput) {
      usernameInput.addEventListener('input', () => toggleClearBtn(usernameInput, usernameWrapper));
      toggleClearBtn(usernameInput, usernameWrapper);
    }
    if (clearUsernameBtn && usernameInput) {
      clearUsernameBtn.addEventListener('click', () => {
        usernameInput.value = '';
        toggleClearBtn(usernameInput, usernameWrapper);
        usernameInput.focus();
      });
    }

    if (nikInput) {
      nikInput.addEventListener('input', updateNikCounter);
      updateNikCounter();
    }
    if (clearNikBtn && nikInput) {
      clearNikBtn.addEventListener('click', () => {
        nikInput.value = '';
        updateNikCounter();
        nikInput.focus();
      });
    }

    const formRecovery = document.getElementById('formRecovery');
    if (formRecovery) {
      formRecovery.addEventListener('submit', function(e) {
        const u = document.getElementById('username');
        const nik = document.getElementById('nik');
        const themeOpts = swalThemeOptions();

        if (!u || !u.value.trim()) {
          e.preventDefault();
          if (u) u.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-user-pen"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-user-shield"></i> KREDENSIAL PENGGUNA</span></div>
                <h3 class="swal-title-modern">Username SSO Diperlukan</h3>
                <p class="swal-text-modern">Silakan masukkan Username SSO Anda terlebih dahulu untuk verifikasi pemulihan.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi Username</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        if (!nik || !nik.value.trim()) {
          e.preventDefault();
          if (nik) nik.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-id-card"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-id-badge"></i> IDENTITAS PEGAWAI</span></div>
                <h3 class="swal-title-modern">NIK Pegawai Diperlukan</h3>
                <p class="swal-text-modern">Silakan masukkan Nomor Induk Kependudukan (NIK) terdaftar untuk verifikasi akun.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi NIK</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        const captchaResponse = (typeof grecaptcha !== 'undefined') ? grecaptcha.getResponse() : '';
        if (!captchaResponse) {
          e.preventDefault();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-shield-halved"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-robot"></i> PROTEKSI SISTEM ANTI-BOT</span></div>
                <h3 class="swal-title-modern">Verifikasi reCAPTCHA Wajib</h3>
                <p class="swal-text-modern">Mohon centang kotak verifikasi <strong>"I'm not a robot"</strong> sebelum melanjutkan.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Mengerti</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' },
            didClose: () => {
              const recap = document.querySelector('.recaptcha-wrapper');
              if (recap) {
                recap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                recap.classList.remove('recaptcha-shake');
                void recap.offsetWidth;
                recap.classList.add('recaptcha-shake');
              }
            }
          }));
          return false;
        }

        Swal.fire(Object.assign({}, themeOpts, {
          html: `
            <div class="py-2 text-center">
              <h4 class="swal-title-modern mb-1">Memvalidasi Data...</h4>
              <p class="swal-text-modern mb-3">Memeriksa kecocokan data SSO &amp; NIK di basis data klinik...</p>
              <div class="spinner-border" role="status"><span class="sr-only">Memuat...</span></div>
            </div>
          `,
          showConfirmButton: false,
          allowOutsideClick: false,
          allowEscapeKey: false,
          customClass: { popup: 'swal2-modern-card' },
          width: 360
        }));
      });
    }
  </script>
</body>
</html>
