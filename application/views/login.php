<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Single Sign-On | HRIS Klinik Pratama Dr. H.M. Hidayatullah</title>
  <meta name="description" content="Portal Masuk Resmi Sistem Informasi Kepegawaian & Penggajian Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">

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
    <a href="<?php echo base_url('landing_page'); ?>" class="btn-utility-link">
      <i class="fas fa-arrow-left" aria-hidden="true"></i>
      <span>Kembali ke Beranda</span>
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

      <!-- Sisi Kiri: Panel Informasi Klinik -->
      <section class="brand-panel" aria-label="Informasi Klinik">
        <div class="brand-content">
          <div class="brand-logo-pod">
            <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>

          <span class="brand-badge">
            <i class="fas fa-shield-halved" aria-hidden="true"></i> PORTAL RESMI HRIS
          </span>

          <h1 class="brand-title">Klinik Pratama Dr. H.M. Hidayatullah</h1>
          <p class="brand-description">
            Sistem Informasi Manajemen Kepegawaian, Presensi Shift Real-Time, dan Penggajian Terpadu.
          </p>

          <div class="brand-features-list">
            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-shield-virus" aria-hidden="true"></i>
              </div>
              <div class="feature-text-group">
                <h4>Keamanan Terintegrasi</h4>
                <p>Enkripsi kata sandi BCRYPT, pembatasan percobaan masuk, dan proteksi CSRF</p>
              </div>
            </div>

            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-business-time" aria-hidden="true"></i>
              </div>
              <div class="feature-text-group">
                <h4>Presensi Shift Real-Time</h4>
                <p>Gerbang jam masuk, toleransi keterlambatan, dan pencatatan jam pulang</p>
              </div>
            </div>

            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
              </div>
              <div class="feature-text-group">
                <h4>Payroll &amp; E-Slip Resmi</h4>
                <p>Kalkulasi gaji pokok, tunjangan, potongan, dan verifikasi dokumen QR</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-clock" aria-hidden="true"></i>
          <span id="liveClockDisplay">Waktu Server Memuat...</span>
        </div>
      </section>

      <!-- Sisi Kanan: Form Autentikasi -->
      <section class="form-container" aria-label="Formulir Masuk">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-hospital-user" aria-hidden="true"></i> AUTENTIKASI SINGLE SIGN-ON
          </span>
          <h2 class="auth-title">Masuk ke Akun Anda</h2>
          <p class="auth-subtitle">Gunakan kredensial resmi kepegawaian Anda untuk mengakses portal kerja.</p>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('login'); ?>" novalidate id="formLogin">

          <!-- Username Input -->
          <div class="form-group mb-3">
            <label class="form-label" for="username">Username SSO</label>
            <div class="input-wrapper" id="usernameWrapper">
              <input type="text" class="form-control-modern" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username SSO..." required autofocus autocomplete="username">
              <i class="fas fa-user input-icon-left" aria-hidden="true"></i>
              <button type="button" class="input-clear-btn" id="clearUsernameBtn" title="Hapus teks" aria-label="Hapus teks username">
                <i class="fas fa-circle-xmark" aria-hidden="true"></i>
              </button>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- Password Input -->
          <div class="form-group mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0" for="password">Kata Sandi</label>
              <a href="<?php echo base_url('lupa_password'); ?>" class="link-forgot">
                Lupa Kata Sandi?
              </a>
            </div>
            <div class="input-wrapper">
              <input type="password" class="form-control-modern" name="password" id="password" placeholder="Masukkan Kata Sandi..." required autocomplete="current-password">
              <i class="fas fa-lock input-icon-left" aria-hidden="true"></i>
              <i class="fas fa-eye password-toggle-btn" id="togglePassword" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <div class="caps-lock-warning" id="capsLockWarning">
              <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
              <span>Peringatan: <strong>Caps Lock</strong> sedang aktif</span>
            </div>
            <?php echo form_error('password', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- Remember Username -->
          <div class="form-options-row">
            <label class="custom-checkbox-wrap" for="rememberMeCheckbox">
              <input type="checkbox" id="rememberMeCheckbox">
              <span>Ingat Username di Perangkat Ini</span>
            </label>
          </div>

          <!-- Quick Demo Chips (Development Only) -->
          <?php if ($this->config->item('show_demo_chips')) : ?>
          <div class="demo-chips-container">
            <span class="demo-chip-title">
              <i class="fas fa-sliders" aria-hidden="true"></i> Demo Pengembangan:
            </span>
            <button type="button" class="demo-chip-btn" id="demoAdminBtn" title="Gunakan Kredensial Administrator">
              <i class="fas fa-user-shield" aria-hidden="true"></i> Admin
            </button>
            <button type="button" class="demo-chip-btn" id="demoStaffBtn" title="Gunakan Kredensial Pegawai">
              <i class="fas fa-user" aria-hidden="true"></i> Pegawai
            </button>
            <button type="button" class="demo-chip-btn" id="demoPimpinanBtn" title="Gunakan Kredensial Pimpinan">
              <i class="fas fa-user-tie" aria-hidden="true"></i> Pimpinan
            </button>
          </div>
          <?php endif; ?>

          <!-- reCAPTCHA Widget -->
          <div class="recaptcha-wrapper">
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars((string)$this->config->item('recaptcha_site_key'), ENT_QUOTES, 'UTF-8'); ?>"></div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-auth-primary" id="btnSubmitLogin">
            <span>Masuk ke Sistem</span>
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
          </button>

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

    function updateLiveClock() {
      const clockEl = document.getElementById('liveClockDisplay');
      if (!clockEl) return;
      const now = new Date();
      const options = {
        weekday: 'short',
        day: 'numeric',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZone: 'Asia/Makassar'
      };
      clockEl.textContent = now.toLocaleString('id-ID', options) + ' WITA';
    }
    setInterval(updateLiveClock, 1000);
    updateLiveClock();

    const usernameInput = document.getElementById('username');
    const usernameWrapper = document.getElementById('usernameWrapper');
    const clearUsernameBtn = document.getElementById('clearUsernameBtn');
    const rememberMeCheckbox = document.getElementById('rememberMeCheckbox');

    function toggleClearBtn() {
      if (usernameInput && usernameWrapper) {
        if (usernameInput.value.trim().length > 0) {
          usernameWrapper.classList.add('has-value');
        } else {
          usernameWrapper.classList.remove('has-value');
        }
      }
    }

    if (usernameInput) {
      const savedUser = localStorage.getItem('saved_sso_username');
      if (savedUser && !usernameInput.value) {
        usernameInput.value = savedUser;
        if (rememberMeCheckbox) rememberMeCheckbox.checked = true;
      }
      usernameInput.addEventListener('input', toggleClearBtn);
      toggleClearBtn();
    }

    if (clearUsernameBtn && usernameInput) {
      clearUsernameBtn.addEventListener('click', () => {
        usernameInput.value = '';
        toggleClearBtn();
        usernameInput.focus();
      });
    }

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const capsLockWarning = document.getElementById('capsLockWarning');

    function handleTogglePassword() {
      if (!passwordInput) return;
      const isPassword = passwordInput.getAttribute('type') === 'password';
      passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
      togglePassword.classList.toggle('fa-eye-slash');
      togglePassword.setAttribute('title', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
      togglePassword.setAttribute('aria-label', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
    }

    if (togglePassword) {
      togglePassword.addEventListener('click', handleTogglePassword);
      togglePassword.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          handleTogglePassword();
        }
      });
    }

    if (passwordInput && capsLockWarning) {
      passwordInput.addEventListener('keyup', (e) => {
        capsLockWarning.style.display = (e.getModifierState && e.getModifierState('CapsLock')) ? 'inline-flex' : 'none';
      });
      passwordInput.addEventListener('blur', () => {
        capsLockWarning.style.display = 'none';
      });
    }

    const demoAdminBtn = document.getElementById('demoAdminBtn');
    const demoStaffBtn = document.getElementById('demoStaffBtn');
    const demoPimpinanBtn = document.getElementById('demoPimpinanBtn');

    if (demoAdminBtn && usernameInput && passwordInput) {
      demoAdminBtn.addEventListener('click', () => {
        usernameInput.value = 'waffa';
        passwordInput.value = '12345';
        toggleClearBtn();
      });
    }
    if (demoStaffBtn && usernameInput && passwordInput) {
      demoStaffBtn.addEventListener('click', () => {
        usernameInput.value = 'anya';
        passwordInput.value = '12345';
        toggleClearBtn();
      });
    }
    if (demoPimpinanBtn && usernameInput && passwordInput) {
      demoPimpinanBtn.addEventListener('click', () => {
        usernameInput.value = 'pimpinan';
        passwordInput.value = 'pimpinan123';
        toggleClearBtn();
      });
    }

    function swalThemeOptions() {
      return isDarkModeActive()
        ? { background: '#171F2A', color: '#F1EFEA' }
        : { background: '#FFFDF9', color: '#141D26' };
    }

    const loginForm = document.getElementById('formLogin');
    if (loginForm) {
      loginForm.addEventListener('submit', function(e) {
        const u = document.getElementById('username');
        const p = document.getElementById('password');
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
                <p class="swal-text-modern">Silakan masukkan Username Single Sign-On resmi Anda terlebih dahulu untuk melanjutkan autentikasi.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi Username</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        if (!p || !p.value.trim()) {
          e.preventDefault();
          if (p) p.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-key"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-lock"></i> KATA SANDI AKUN</span></div>
                <h3 class="swal-title-modern">Kata Sandi Diperlukan</h3>
                <p class="swal-text-modern">Silakan masukkan kata sandi akun kepegawaian Anda terlebih dahulu untuk memverifikasi identitas.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi Kata Sandi</span><i class="fas fa-arrow-right"></i>',
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
                <p class="swal-text-modern">Mohon centang kotak verifikasi <strong>"I'm not a robot"</strong> sebelum masuk ke sistem.</p>
                <div class="swal-hint-box">
                  <i class="fas fa-arrow-pointer swal-hint-icon"></i>
                  <div><strong>Panduan Cepat:</strong> Centang kotak reCAPTCHA tepat di atas tombol <em>Masuk ke Sistem</em>.</div>
                </div>
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

        if (rememberMeCheckbox && rememberMeCheckbox.checked && u.value.trim()) {
          localStorage.setItem('saved_sso_username', u.value.trim());
        } else {
          localStorage.removeItem('saved_sso_username');
        }

        const hour = new Date().getHours();
        let greeting = 'Selamat Malam';
        if (hour >= 4 && hour < 11) greeting = 'Selamat Pagi';
        else if (hour >= 11 && hour < 15) greeting = 'Selamat Siang';
        else if (hour >= 15 && hour < 19) greeting = 'Selamat Sore';

        Swal.fire(Object.assign({}, themeOpts, {
          html: `
            <div class="py-2 text-center">
              <h4 class="swal-title-modern mb-1">${greeting}!</h4>
              <p class="swal-text-modern mb-3">Memverifikasi kredensial akun Anda ke sistem...</p>
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
