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
      --navy-deep: #07172b;
      --navy-main: #0c2b4d;
      --navy-light: #123d6c;
      --sky-main: #0284c7;
      --sky-hover: #0369a1;
      --bg-slate: #f8fafc;
      --border-color: #e2e8f0;
      --text-dark: #0f172a;
      --text-muted: #64748b;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: var(--bg-slate);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 1.5rem 1rem;
      color: var(--text-dark);
    }

    .auth-card {
      width: 100%;
      max-width: 940px;
      background: #ffffff;
      border-radius: 16px;
      border: 1px solid var(--border-color);
      box-shadow: 0 20px 40px -10px rgba(12, 43, 77, 0.12);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
    }

    .brand-panel {
      flex: 1.05;
      background: linear-gradient(150deg, var(--navy-deep) 0%, var(--navy-main) 60%, var(--navy-light) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3.5rem 2.5rem;
      color: #ffffff;
      text-align: center;
      position: relative;
    }

    .brand-logo {
      width: 105px;
      height: auto;
      margin-bottom: 1.25rem;
      filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.25));
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      background: rgba(14, 165, 233, 0.16);
      border: 1px solid rgba(56, 189, 248, 0.35);
      color: #7dd3fc;
      padding: 0.3rem 0.85rem;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      margin-bottom: 1rem;
    }

    .brand-panel h1 {
      font-weight: 800;
      color: #ffffff;
      font-size: 1.45rem;
      letter-spacing: -0.02em;
      margin-bottom: 0.5rem;
    }

    .brand-panel p {
      color: #94a3b8;
      font-size: 0.875rem;
      line-height: 1.6;
      max-width: 320px;
      margin: 0 auto 1.75rem auto;
    }

    .brand-features {
      list-style: none;
      padding: 0;
      margin: 0;
      text-align: left;
      width: 100%;
      max-width: 300px;
    }

    .brand-features li {
      display: flex;
      align-items: center;
      font-size: 0.825rem;
      color: #cbd5e1;
      margin-bottom: 0.75rem;
    }

    .brand-features li i {
      width: 22px;
      color: #38bdf8;
      margin-right: 0.5rem;
      font-size: 0.875rem;
    }

    .form-container {
      flex: 1;
      padding: 3.5rem 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #ffffff;
    }

    .form-container h2 {
      font-weight: 800;
      color: var(--navy-main);
      font-size: 1.35rem;
      letter-spacing: -0.02em;
      margin-bottom: 0.25rem;
    }

    .form-container p.subtitle {
      color: var(--text-muted);
      font-size: 0.875rem;
      margin-bottom: 1.75rem;
    }

    .form-label {
      font-size: 0.85rem;
      font-weight: 700;
      color: #334155;
      margin-bottom: 0.35rem;
      display: block;
    }

    .form-control-modern {
      border-radius: 10px;
      padding: 0.75rem 1rem;
      padding-right: 2.75rem;
      border: 1.5px solid var(--border-color);
      background-color: #f8fafc;
      font-size: 0.925rem;
      font-family: var(--font-main);
      transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
      width: 100%;
      outline: none;
      min-height: 46px;
    }

    .form-control-modern:focus {
      border-color: var(--sky-main);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
      background-color: #ffffff;
    }

    .input-icon-modern {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      transition: color 0.2s;
    }

    .input-icon-modern.clickable:hover {
      color: var(--sky-main);
      cursor: pointer;
    }

    .btn-auth-primary {
      background: linear-gradient(135deg, var(--navy-main) 0%, var(--navy-light) 100%);
      color: #ffffff;
      border-radius: 10px;
      padding: 0.85rem 1.5rem;
      font-weight: 700;
      font-size: 0.95rem;
      border: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      box-shadow: 0 4px 12px rgba(12, 43, 77, 0.2);
      min-height: 48px;
      width: 100%;
      cursor: pointer;
    }

    .btn-auth-primary:hover {
      background: linear-gradient(135deg, var(--navy-light) 0%, #1a5c9f 100%);
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(12, 43, 77, 0.28);
      color: #ffffff;
    }

    .btn-auth-primary:focus-visible {
      outline: 2px solid var(--sky-main);
      outline-offset: 3px;
    }

    .demo-accounts-box {
      background-color: #f1f5f9;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      margin-top: 1.25rem;
    }

    .demo-chip {
      background: #ffffff;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      padding: 0.25rem 0.6rem;
      font-size: 0.75rem;
      color: var(--navy-main);
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      transition: all 0.15s;
    }

    .demo-chip:hover {
      border-color: var(--sky-main);
      color: var(--sky-main);
      background: #f0f9ff;
    }

    @media (max-width: 768px) {
      .brand-panel { display: none; }
      .form-container { padding: 2.5rem 1.75rem; }
      .auth-card { border-radius: 14px; margin: 0.5rem; }
    }
  </style>
</head>

<body>
  <main class="container d-flex justify-content-center align-items-center">
    <div class="auth-card">
      
      <!-- Sisi Kiri: Panel Informasi Klinik -->
      <section class="brand-panel" aria-label="Informasi Klinik">
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
        <span class="brand-badge"><i class="fas fa-shield-alt mr-1"></i> PORTAL RESMI HRIS</span>
        <h1>Klinik Pratama</h1>
        <p>
          Sistem Informasi Manajemen Kepegawaian dan Penggajian Terpadu Dr. H.M. Hidayatullah
        </p>
        <ul class="brand-features">
          <li><i class="fas fa-lock"></i> Keamanan Data Kepegawaian</li>
          <li><i class="fas fa-location-dot"></i> Presensi GPS & Radius Klinik</li>
          <li><i class="fas fa-file-invoice-dollar"></i> Payroll & Slip Gaji Terstandar</li>
        </ul>
      </section>

      <!-- Sisi Kanan: Form Autentikasi -->
      <section class="form-container" aria-label="Formulir Masuk">
        <div>
          <h2>Masuk ke Akun Anda</h2>
          <p class="subtitle">Gunakan kredensial resmi kepegawaian Anda untuk mengakses portal.</p>
        </div>
        
        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('login'); ?>" novalidate>
          
          <div class="form-group mb-3">
            <label class="form-label" for="username">Username SSO</label>
            <div class="position-relative">
              <input type="text" class="form-control-modern" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username..." required autofocus autocomplete="username">
              <i class="fas fa-user input-icon-modern" aria-hidden="true"></i>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0" for="password">Kata Sandi</label>
              <a href="<?php echo base_url('lupa_password'); ?>" class="text-primary small font-weight-bold" style="text-decoration: none;">
                Lupa Kata Sandi?
              </a>
            </div>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="password" id="password" placeholder="Masukkan Password..." required autocomplete="current-password">
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <?php echo form_error('password', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          
          <!-- reCAPTCHA Widget -->
          <div class="form-group mb-4 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
          </div>
          
          <button type="submit" class="btn-auth-primary">
            Masuk ke Sistem
          </button>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <!-- Kredensial Cepat untuk Evaluasi & Demo -->
        <div class="demo-accounts-box">
          <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="text-xs font-weight-bold text-muted text-uppercase"><i class="fas fa-key mr-1"></i> Akun Uji Coba:</span>
            <span class="text-xs text-muted">Klik untuk mengisi otomatis</span>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <button type="button" class="demo-chip mr-2 mb-1" onclick="fillDemo('waffa', '12345')">
              <i class="fas fa-user-shield mr-1 text-primary"></i> Admin: waffa
            </button>
            <button type="button" class="demo-chip mb-1" onclick="fillDemo('anya', '12345')">
              <i class="fas fa-user-nurse mr-1 text-success"></i> Pegawai: anya
            </button>
          </div>
        </div>

        <div class="text-center mt-4 pt-3 border-top">
          <small class="text-muted">&copy; <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah</small>
        </div>
      </section>

    </div>
  </main>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
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

    // Isi kredensial otomatis untuk kemudahan uji coba
    function fillDemo(username, passwordVal) {
      const u = document.getElementById('username');
      const p = document.getElementById('password');
      if (u && p) {
        u.value = username;
        p.value = passwordVal;
        p.focus();
      }
    }
  </script>
</body>
</html>