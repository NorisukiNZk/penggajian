<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | HRIS Klinik Pratama Hidayatullah</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Base Stylesheet -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
  <style>
    :root {
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
      --navy-deep: #061528;
      --navy-main: #0c2b4d;
      --navy-light: #164070;
      --sky-main: #0284c7;
      --sky-hover: #0369a1;
      --sky-light: #f0f9ff;
      --slate-bg: #f8fafc;
      --border-color: #e2e8f0;
      --border-focus: #38bdf8;
      --text-dark: #0f172a;
      --text-muted: #64748b;
      --emerald-accent: #10b981;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: var(--slate-bg);
      background-image: 
        radial-gradient(at 0% 0%, rgba(14, 165, 233, 0.08) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(12, 43, 77, 0.08) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 40%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 2rem 1rem;
      color: var(--text-dark);
      -webkit-font-smoothing: antialiased;
    }

    .auth-wrapper {
      width: 100%;
      max-width: 980px;
      margin: auto;
    }

    .auth-card {
      background: #ffffff;
      border-radius: 22px;
      border: 1px solid rgba(226, 232, 240, 0.9);
      box-shadow: 0 25px 60px -15px rgba(12, 43, 77, 0.14), 0 10px 25px -5px rgba(12, 43, 77, 0.04);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
    }

    /* Left Brand Panel */
    .brand-panel {
      flex: 1.05;
      background: linear-gradient(155deg, var(--navy-deep) 0%, var(--navy-main) 55%, var(--navy-light) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 3.5rem 2.75rem;
      color: #ffffff;
      text-align: center;
      position: relative;
    }

    .brand-panel::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 20% 15%, rgba(14, 165, 233, 0.15), transparent 45%),
                  radial-gradient(circle at 80% 85%, rgba(16, 185, 129, 0.1), transparent 45%);
      pointer-events: none;
    }

    .brand-content {
      position: relative;
      z-index: 2;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .brand-logo-wrap {
      width: 96px;
      height: 96px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    .brand-logo {
      width: 64px;
      height: auto;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      background: rgba(14, 165, 233, 0.16);
      border: 1px solid rgba(56, 189, 248, 0.35);
      color: #7dd3fc;
      padding: 0.35rem 0.95rem;
      border-radius: 999px;
      font-size: 0.725rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin-bottom: 1.25rem;
      gap: 0.4rem;
    }

    .status-dot {
      width: 7px;
      height: 7px;
      background-color: var(--emerald-accent);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--emerald-accent);
      display: inline-block;
    }

    .brand-title {
      font-size: 1.55rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.025em;
      line-height: 1.25;
      margin-bottom: 0.65rem;
    }

    .brand-description {
      color: #94a3b8;
      font-size: 0.885rem;
      line-height: 1.6;
      max-width: 320px;
      margin: 0 auto 2rem auto;
    }

    .brand-features-list {
      width: 100%;
      max-width: 330px;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    .brand-feature-item {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 0.75rem 1rem;
      border-radius: 12px;
      text-align: left;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    .feature-icon-box {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: rgba(56, 189, 248, 0.18);
      color: #38bdf8;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      flex-shrink: 0;
    }

    .feature-text-group h4 {
      font-size: 0.825rem;
      font-weight: 700;
      color: #f1f5f9;
      margin: 0 0 2px 0;
    }

    .feature-text-group p {
      font-size: 0.725rem;
      color: #94a3b8;
      margin: 0;
      line-height: 1.35;
    }

    .brand-footer-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.725rem;
      color: #64748b;
      background: rgba(255, 255, 255, 0.04);
      padding: 0.35rem 0.85rem;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Right Form Container */
    .form-container {
      flex: 1;
      padding: 3.5rem 3.25rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #ffffff;
    }

    .form-header-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.725rem;
      font-weight: 700;
      color: var(--sky-main);
      background: var(--sky-light);
      padding: 0.25rem 0.75rem;
      border-radius: 6px;
      margin-bottom: 0.75rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }

    .auth-title {
      font-weight: 800;
      color: var(--navy-main);
      font-size: 1.5rem;
      letter-spacing: -0.025em;
      margin-bottom: 0.35rem;
    }

    .auth-subtitle {
      color: var(--text-muted);
      font-size: 0.885rem;
      margin-bottom: 1.85rem;
      line-height: 1.5;
    }

    .form-label {
      font-size: 0.84rem;
      font-weight: 700;
      color: #334155;
      margin-bottom: 0.45rem;
      display: block;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control-modern {
      border-radius: 12px;
      padding: 0.8rem 1rem 0.8rem 2.85rem;
      border: 1.5px solid var(--border-color);
      background-color: #f8fafc;
      font-size: 0.925rem;
      font-family: var(--font-main);
      color: var(--text-dark);
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
      outline: none;
      min-height: 48px;
    }

    .form-control-modern:hover {
      border-color: #cbd5e1;
      background-color: #ffffff;
    }

    .form-control-modern:focus {
      border-color: var(--sky-main);
      box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.12);
      background-color: #ffffff;
    }

    .input-icon-left {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 0.925rem;
      pointer-events: none;
      transition: color 0.2s;
    }

    .form-control-modern:focus ~ .input-icon-left {
      color: var(--sky-main);
    }

    .password-toggle-btn {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 0.95rem;
      cursor: pointer;
      padding: 4px;
      border-radius: 6px;
      transition: all 0.15s;
    }

    .password-toggle-btn:hover {
      color: var(--sky-main);
      background: #f1f5f9;
    }

    .link-forgot {
      color: var(--sky-main);
      font-size: 0.825rem;
      font-weight: 700;
      text-decoration: none;
      transition: color 0.15s;
    }

    .link-forgot:hover {
      color: var(--sky-hover);
      text-decoration: underline;
    }

    .recaptcha-wrapper {
      display: flex;
      justify-content: center;
      margin-bottom: 1.5rem;
      overflow: hidden;
      border-radius: 6px;
    }

    .btn-auth-primary {
      background: linear-gradient(135deg, var(--navy-main) 0%, #114277 50%, var(--sky-main) 100%);
      color: #ffffff;
      border-radius: 12px;
      padding: 0.85rem 1.5rem;
      font-weight: 700;
      font-size: 0.95rem;
      letter-spacing: -0.01em;
      border: none;
      transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 8px 20px -4px rgba(12, 43, 77, 0.3);
      min-height: 50px;
      width: 100%;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-auth-primary:hover {
      transform: translateY(-1.5px);
      box-shadow: 0 12px 28px -4px rgba(2, 132, 199, 0.4);
      color: #ffffff;
    }

    .btn-auth-primary:active {
      transform: scale(0.985);
    }

    .btn-auth-primary:focus-visible {
      outline: 2px solid var(--sky-main);
      outline-offset: 3px;
    }

    .btn-arrow {
      transition: transform 0.2s ease;
    }

    .btn-auth-primary:hover .btn-arrow {
      transform: translateX(3px);
    }

    .form-footer-copyright {
      text-align: center;
      margin-top: 2rem;
      padding-top: 1.25rem;
      border-top: 1px solid #f1f5f9;
      color: #94a3b8;
      font-size: 0.785rem;
    }

    /* SweetAlert2 Corporate Modal */
    .swal2-container {
      font-family: var(--font-main) !important;
    }
    .swal2-corporate-modal {
      border-radius: 18px !important;
      padding: 1.85rem 1.75rem 1.5rem !important;
      border: 1px solid #e2e8f0 !important;
      box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25) !important;
      width: 400px !important;
      max-width: 90vw !important;
      background: #ffffff !important;
    }

    @media (max-width: 860px) {
      .brand-panel { display: none; }
      .form-container { padding: 2.75rem 2rem; }
      .auth-card { border-radius: 16px; margin: 0.5rem; }
    }
  </style>
</head>

<body>
  <main class="auth-wrapper">
    <div class="auth-card">
      
      <!-- Sisi Kiri: Panel Informasi Klinik -->
      <section class="brand-panel" aria-label="Informasi Klinik">
        <div class="brand-content">
          <div class="brand-logo-wrap">
            <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>
          
          <span class="brand-badge">
            <span class="status-dot"></span> PORTAL RESMI HRIS
          </span>
          
          <h1 class="brand-title">Klinik Pratama Dr. H.M. Hidayatullah</h1>
          <p class="brand-description">
            Sistem Informasi Manajemen Kepegawaian, Presensi GPS, dan Penggajian Terpadu.
          </p>

          <div class="brand-features-list">
            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="feature-text-group">
                <h4>Keamanan Terintegrasi</h4>
                <p>Enkripsi kata sandi BCRYPT & proteksi CSRF</p>
              </div>
            </div>

            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="feature-text-group">
                <h4>Presensi GPS & Geofencing</h4>
                <p>Validasi radius kehadiran pegawai presisi</p>
              </div>
            </div>

            <div class="brand-feature-item">
              <div class="feature-icon-box">
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <div class="feature-text-group">
                <h4>Payroll & Slip Gaji</h4>
                <p>Kalkulasi gaji pokok, tunjangan, & potongan otomatis</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-lock text-info"></i> Sistem Terenkripsi 256-Bit SSL
        </div>
      </section>

      <!-- Sisi Kanan: Form Autentikasi -->
      <section class="form-container" aria-label="Formulir Masuk">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-hospital-user"></i> AUTENTIKASI SINGLE SIGN-ON
          </span>
          <h2 class="auth-title">Masuk ke Akun Anda</h2>
          <p class="auth-subtitle">Gunakan kredensial resmi kepegawaian Anda untuk mengakses portal kerja.</p>
        </div>
        
        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('login'); ?>" novalidate id="formLogin">
          
          <div class="form-group mb-3">
            <label class="form-label" for="username">Username SSO</label>
            <div class="input-wrapper">
              <input type="text" class="form-control-modern" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username SSO..." required autofocus autocomplete="username">
              <i class="fas fa-user input-icon-left" aria-hidden="true"></i>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
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
            <?php echo form_error('password', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          
          <!-- reCAPTCHA Widget -->
          <div class="recaptcha-wrapper">
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
          </div>
          
          <button type="submit" class="btn-auth-primary" id="btnSubmitLogin">
            <span>Masuk ke Sistem</span>
            <i class="fas fa-arrow-right btn-arrow"></i>
          </button>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <div class="form-footer-copyright">
          <small>&copy; <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah &bull; All Rights Reserved</small>
        </div>
      </section>

    </div>
  </main>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
  
  <script>
    // Toggle visibilitas kata sandi
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    function handleTogglePassword() {
      if (!password) return;
      const isPassword = password.getAttribute('type') === 'password';
      password.setAttribute('type', isPassword ? 'text' : 'password');
      togglePassword.classList.toggle('fa-eye-slash');
      togglePassword.setAttribute('title', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
      togglePassword.setAttribute('aria-label', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
    }

    if (togglePassword) {
      togglePassword.addEventListener('click', handleTogglePassword);
      togglePassword.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          handleTogglePassword();
        }
      });
    }

    // Sambutan waktu interaktif saat klik login (Pagi / Siang / Sore / Malam)
    const loginForm = document.getElementById('formLogin');
    if (loginForm) {
      loginForm.addEventListener('submit', function(e) {
        const u = document.getElementById('username');
        const p = document.getElementById('password');
        if (!u || !p || !u.value.trim() || !p.value.trim()) {
          return;
        }

        const hour = new Date().getHours();
        let greeting = 'Selamat Malam';
        let icon = 'fa-moon';
        let iconColor = '#6366f1';

        if (hour >= 4 && hour < 11) {
          greeting = 'Selamat Pagi';
          icon = 'fa-sun';
          iconColor = '#f59e0b';
        } else if (hour >= 11 && hour < 15) {
          greeting = 'Selamat Siang';
          icon = 'fa-sun';
          iconColor = '#0ea5e9';
        } else if (hour >= 15 && hour < 18.5) {
          greeting = 'Selamat Sore';
          icon = 'fa-cloud-sun';
          iconColor = '#f97316';
        }

        Swal.fire({
          html: `
            <div class="py-2 text-center">
              <div class="mb-3 d-inline-flex align-items-center justify-content-center" style="width: 58px; height: 58px; border-radius: 50%; background: rgba(14, 165, 233, 0.1);">
                <i class="fas ${icon}" style="font-size: 1.75rem; color: ${iconColor};"></i>
              </div>
              <h4 class="font-weight-bold text-gray-900 mb-1" style="font-size: 1.25rem; letter-spacing: -0.01em;">
                ${greeting}!
              </h4>
              <p class="text-muted small mb-3">
                Memverifikasi kredensial akun Anda ke sistem...
              </p>
              <div class="spinner-border text-primary" style="width: 2rem; height: 2rem; border-width: 2.5px;" role="status">
                <span class="sr-only">Memuat...</span>
              </div>
            </div>
          `,
          showConfirmButton: false,
          allowOutsideClick: false,
          allowEscapeKey: false,
          customClass: {
            popup: 'swal2-corporate-modal'
          },
          width: 380,
          background: '#ffffff'
        });
      });
    }
  </script>
</body>
</html>