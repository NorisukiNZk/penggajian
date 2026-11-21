<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Buat Kata Sandi Baru | HRIS Klinik Pratama Dr. H.M. Hidayatullah</title>
  <meta name="description" content="Tahap Pembaruan Kata Sandi Baru Akun Kepegawaian HRIS Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">

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
</head>

<body>

  <!-- Top Floating Utility Bar -->
  <header class="top-utility-bar" aria-label="Navigasi Akses Cepat">
    <a href="<?php echo base_url('lupa_password/batal'); ?>" class="btn-utility-link">
      <i class="fas fa-arrow-left" aria-hidden="true"></i>
      <span>Batal &amp; Kembali ke Login</span>
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

      <!-- Sisi Kiri: Panel Informasi Pengaturan Sandi -->
      <section class="brand-panel" aria-label="Informasi Pembaruan Sandi">
        <div class="brand-content">
          <div class="brand-logo-pod">
            <img src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>

          <span class="brand-badge">
            <i class="fas fa-check-circle" aria-hidden="true"></i> IDENTITAS TERVERIFIKASI
          </span>

          <h1 class="brand-title">Atur Sandi Baru</h1>
          <p class="brand-description">
            Buat kombinasi kata sandi baru minimal 8 karakter untuk melindungi akun dan privasi data kepegawaian Anda.
          </p>

          <!-- 3-Step Breadcrumb Stepper -->
          <div class="recovery-steps-list">
            <div class="recovery-step-item">
              <span class="step-number-badge"><i class="fas fa-check" aria-hidden="true"></i></span>
              <div class="step-text-group">
                <h4>Input Identitas Kepegawaian</h4>
                <p>Identitas SSO dan NIK pegawai cocok</p>
              </div>
            </div>

            <div class="recovery-step-item">
              <span class="step-number-badge"><i class="fas fa-check" aria-hidden="true"></i></span>
              <div class="step-text-group">
                <h4>Validasi Database Klinik</h4>
                <p>Status kepegawaian aktif di sistem</p>
              </div>
            </div>

            <div class="recovery-step-item is-active">
              <span class="step-number-badge">3</span>
              <div class="step-text-group">
                <h4>Atur Kata Sandi Baru</h4>
                <p>Buat kata sandi baru minimal 8 karakter berenkripsi BCRYPT</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-lock" aria-hidden="true"></i>
          <span>Enkripsi Standar BCRYPT Password Hash</span>
        </div>
      </section>

      <!-- Sisi Kanan: Formulir Pembaruan Sandi -->
      <section class="form-container" aria-label="Formulir Buat Kata Sandi Baru">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-shield-halved" aria-hidden="true"></i> TAHAP 3 &bull; PEMBARUAN SANDI
          </span>
          <h2 class="auth-title">Atur Ulang Kata Sandi</h2>
          <p class="auth-subtitle">Identitas pegawai telah diverifikasi. Silakan tentukan kata sandi baru Anda.</p>
        </div>

        <!-- Kartu Identitas Pegawai Terverifikasi -->
        <div class="verified-user-box">
          <?php
          $photo_url = (!empty($photo) && file_exists(FCPATH . 'assets/photo/' . $photo))
            ? base_url('assets/photo/' . $photo)
            : ((!empty($photo) && file_exists(FCPATH . 'photo/' . $photo)) ? base_url('photo/' . $photo) : '');
          ?>
          <?php if (!empty($photo_url)) : ?>
            <img src="<?php echo $photo_url; ?>" alt="<?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>" class="verified-avatar">
          <?php else : ?>
            <div class="verified-avatar-fallback">
              <i class="fas fa-user-check" aria-hidden="true"></i>
            </div>
          <?php endif; ?>
          <div class="verified-meta">
            <h5><?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></h5>
            <p>
              <span class="badge-sso">@<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
              <span>&bull;</span>
              <span><?php echo htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
            </p>
          </div>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password/simpan_password'); ?>" novalidate id="formReset">

          <!-- Kata Sandi Baru Input -->
          <div class="form-group mb-3">
            <label class="form-label" for="password_baru">
              <span>Kata Sandi Baru</span>
              <small class="text-muted">(Minimal 8 Karakter)</small>
            </label>
            <div class="input-wrapper">
              <input type="password" class="form-control-modern" name="password_baru" id="password_baru" placeholder="Minimal 8 karakter..." minlength="8" required autofocus autocomplete="new-password">
              <i class="fas fa-lock input-icon-left" aria-hidden="true"></i>
              <i class="fas fa-eye password-toggle-btn" id="togglePassword1" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>

            <div class="caps-lock-warning" id="capsLockWarning1">
              <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
              <span>Peringatan: <strong>Caps Lock</strong> sedang aktif</span>
            </div>

            <!-- Password Strength Meter -->
            <div class="strength-meter-wrap" id="strengthMeterWrap">
              <div class="strength-bars-track">
                <div class="strength-bar" id="strBar1"></div>
                <div class="strength-bar" id="strBar2"></div>
                <div class="strength-bar" id="strBar3"></div>
              </div>
              <div class="strength-label-text">
                <span id="strengthText">Kekuatan Sandi</span>
                <span id="strengthAdvice">Gunakan variasi karakter</span>
              </div>
            </div>

            <?php echo form_error('password_baru', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- Konfirmasi Kata Sandi Baru Input -->
          <div class="form-group mb-4">
            <label class="form-label" for="konfirmasi_password">
              <span>Konfirmasi Kata Sandi Baru</span>
              <span class="match-status-badge" id="matchBadge">
                <i class="fas fa-circle-check" aria-hidden="true"></i> <span>Cocok</span>
              </span>
            </label>
            <div class="input-wrapper">
              <input type="password" class="form-control-modern" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi kata sandi baru..." minlength="8" required autocomplete="new-password">
              <i class="fas fa-shield-alt input-icon-left" aria-hidden="true"></i>
              <i class="fas fa-eye password-toggle-btn" id="togglePassword2" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>

            <div class="caps-lock-warning" id="capsLockWarning2">
              <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
              <span>Peringatan: <strong>Caps Lock</strong> sedang aktif</span>
            </div>

            <?php echo form_error('konfirmasi_password', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-auth-primary" id="btnSubmitReset">
            <span>Simpan Kata Sandi Baru</span>
            <i class="fas fa-check" aria-hidden="true"></i>
          </button>

          <!-- Back / Cancel Button -->
          <a href="<?php echo base_url('lupa_password/batal'); ?>" class="btn-back-outline">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span>Batal dan Kembali ke Login</span>
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

    function setupToggle(buttonId, inputId, warningId) {
      const btn = document.querySelector(buttonId);
      const input = document.querySelector(inputId);
      const warning = document.querySelector(warningId);
      if (!btn || !input) return;

      function toggle() {
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        btn.classList.toggle('fa-eye-slash');
        btn.setAttribute('title', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
        btn.setAttribute('aria-label', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
      }

      btn.addEventListener('click', toggle);
      btn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggle();
        }
      });

      if (warning) {
        input.addEventListener('keyup', (e) => {
          warning.style.display = (e.getModifierState && e.getModifierState('CapsLock')) ? 'inline-flex' : 'none';
        });
        input.addEventListener('blur', () => {
          warning.style.display = 'none';
        });
      }
    }

    setupToggle('#togglePassword1', '#password_baru', '#capsLockWarning1');
    setupToggle('#togglePassword2', '#konfirmasi_password', '#capsLockWarning2');

    const pwd1 = document.getElementById('password_baru');
    const pwd2 = document.getElementById('konfirmasi_password');
    const strengthMeterWrap = document.getElementById('strengthMeterWrap');
    const strBar1 = document.getElementById('strBar1');
    const strBar2 = document.getElementById('strBar2');
    const strBar3 = document.getElementById('strBar3');
    const strengthText = document.getElementById('strengthText');
    const strengthAdvice = document.getElementById('strengthAdvice');
    const matchBadge = document.getElementById('matchBadge');

    function checkStrength(val) {
      if (!val) {
        strengthMeterWrap.style.display = 'none';
        return 0;
      }
      strengthMeterWrap.style.display = 'block';

      let score = 0;
      if (val.length >= 8) score = 1;
      if (val.length >= 8 && (/[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val))) score = 2;
      if (val.length >= 10 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score = 3;

      strBar1.style.background = 'var(--auth-border-strong)';
      strBar2.style.background = 'var(--auth-border-strong)';
      strBar3.style.background = 'var(--auth-border-strong)';

      if (score === 0) {
        strBar1.style.background = 'var(--auth-danger)';
        strengthText.textContent = 'Belum Memenuhi Minimal 8 Karakter';
        strengthText.style.color = 'var(--auth-danger)';
        strengthAdvice.textContent = 'Tambah panjang kata sandi';
      } else if (score === 1) {
        strBar1.style.background = 'var(--auth-accent)';
        strengthText.textContent = 'Kekuatan: Cukup';
        strengthText.style.color = 'var(--auth-accent)';
        strengthAdvice.textContent = 'Tambahkan angka atau simbol';
      } else if (score === 2) {
        strBar1.style.background = 'var(--auth-accent)';
        strBar2.style.background = 'var(--auth-accent)';
        strengthText.textContent = 'Kekuatan: Baik';
        strengthText.style.color = 'var(--auth-accent)';
        strengthAdvice.textContent = 'Kombinasi cukup aman';
      } else {
        strBar1.style.background = 'var(--auth-emerald)';
        strBar2.style.background = 'var(--auth-emerald)';
        strBar3.style.background = 'var(--auth-emerald)';
        strengthText.textContent = 'Kekuatan: Sangat Kuat';
        strengthText.style.color = 'var(--auth-emerald)';
        strengthAdvice.textContent = 'Tingkat keamanan optimal';
      }
      return score;
    }

    function checkMatch() {
      if (!pwd2 || !matchBadge) return;
      const v1 = pwd1.value;
      const v2 = pwd2.value;

      if (!v2) {
        matchBadge.className = 'match-status-badge';
        return;
      }

      if (v1 === v2) {
        matchBadge.className = 'match-status-badge is-match';
        matchBadge.innerHTML = '<i class="fas fa-circle-check"></i> <span>Sandi Cocok</span>';
      } else {
        matchBadge.className = 'match-status-badge is-mismatch';
        matchBadge.innerHTML = '<i class="fas fa-circle-xmark"></i> <span>Belum Cocok</span>';
      }
    }

    if (pwd1) {
      pwd1.addEventListener('input', () => {
        checkStrength(pwd1.value);
        checkMatch();
      });
    }

    if (pwd2) {
      pwd2.addEventListener('input', checkMatch);
    }

    const formReset = document.getElementById('formReset');
    if (formReset) {
      formReset.addEventListener('submit', function(e) {
        const p1 = document.getElementById('password_baru');
        const p2 = document.getElementById('konfirmasi_password');
        const themeOpts = swalThemeOptions();

        if (!p1 || !p1.value.trim()) {
          e.preventDefault();
          if (p1) p1.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-lock"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-key"></i> KATA SANDI BARU</span></div>
                <h3 class="swal-title-modern">Kata Sandi Baru Diperlukan</h3>
                <p class="swal-text-modern">Silakan masukkan kata sandi baru untuk akun Anda terlebih dahulu.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi Sandi</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        if (p1.value.trim().length < 8) {
          e.preventDefault();
          p1.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-triangle-exclamation"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-shield"></i> PERSYARATAN MINIMAL</span></div>
                <h3 class="swal-title-modern">Panjang Sandi Kurang</h3>
                <p class="swal-text-modern">Kata sandi baru minimal harus terdiri dari <strong>8 karakter</strong>.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Perbaiki Sandi</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        if (!p2 || !p2.value.trim() || p1.value !== p2.value) {
          e.preventDefault();
          if (p2) p2.focus();
          Swal.fire(Object.assign({}, themeOpts, {
            html: `
              <div class="text-center py-2">
                <div class="swal-icon-shield"><i class="fas fa-circle-xmark"></i></div>
                <div><span class="swal-badge-security"><i class="fas fa-shield-virus"></i> KONFIRMASI TIDAK COCOK</span></div>
                <h3 class="swal-title-modern">Kata Sandi Tidak Cocok</h3>
                <p class="swal-text-modern">Pastikan kolom konfirmasi kata sandi diisi sama persis dengan kata sandi baru Anda.</p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Periksa Ulang</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: { popup: 'swal2-modern-card', actions: 'swal2-modern-actions', confirmButton: 'btn-swal-confirm' }
          }));
          return false;
        }

        Swal.fire(Object.assign({}, themeOpts, {
          html: `
            <div class="py-2 text-center">
              <h4 class="swal-title-modern mb-1">Mengenkripsi Kata Sandi...</h4>
              <p class="swal-text-modern mb-3">Menyimpan pembaruan kata sandi berenkripsi BCRYPT ke sistem...</p>
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
