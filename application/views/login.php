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
      --primary-navy: #0c2b4d;
      --primary-hover: #123d6c;
      --accent-sky: #0284c7;
      --accent-hover: #0369a1;
      --bg-slate: #f1f5f9;
      --border-color: #e2e8f0;
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
      background-image: 
        radial-gradient(at 15% 15%, rgba(14, 165, 233, 0.12) 0px, transparent 55%),
        radial-gradient(at 85% 85%, rgba(12, 43, 77, 0.08) 0px, transparent 50%);
    }

    .login-container {
      width: 100%;
      max-width: 920px;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 20px 40px -10px rgba(12, 43, 77, 0.12), 0 0 0 1px rgba(226, 232, 240, 0.9);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
    }

    .login-brand-panel {
      flex: 1.1;
      background: linear-gradient(150deg, #091e36 0%, #0c2b4d 60%, #0f3763 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3.5rem 2.5rem;
      color: #ffffff;
      text-align: center;
      position: relative;
    }

    .login-brand-panel::before {
      content: '';
      position: absolute;
      width: 220px;
      height: 220px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
      top: 10%;
      right: -10%;
      pointer-events: none;
    }

    .login-brand-logo {
      width: 110px;
      height: auto;
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.25));
    }

    .portal-tag {
      display: inline-flex;
      align-items: center;
      background: rgba(14, 165, 233, 0.18);
      border: 1px solid rgba(56, 189, 248, 0.35);
      color: #7dd3fc;
      padding: 0.3rem 0.85rem;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      margin-bottom: 1.25rem;
    }

    .login-brand-panel h3 {
      font-weight: 800;
      color: #ffffff;
      font-size: 1.5rem;
      letter-spacing: -0.02em;
      margin-bottom: 0.5rem;
    }

    .login-brand-panel p {
      color: #94a3b8;
      font-size: 0.875rem;
      line-height: 1.6;
      max-width: 320px;
      margin: 0;
    }

    .login-form-container {
      flex: 1;
      padding: 3.5rem 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #ffffff;
    }

    .login-form-container h2 {
      font-weight: 800;
      color: var(--primary-navy);
      letter-spacing: -0.02em;
    }

    .form-control-modern {
      border-radius: 10px;
      padding: 0.8rem 1rem;
      padding-right: 2.75rem;
      border: 1.5px solid var(--border-color);
      background-color: #f8fafc;
      font-size: 0.95rem;
      font-family: var(--font-main);
      transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
      width: 100%;
      outline: none;
    }

    .form-control-modern:focus {
      border-color: var(--accent-sky);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
      background-color: #ffffff;
    }

    .btn-login-modern {
      background: linear-gradient(135deg, #0c2b4d 0%, #164e87 100%);
      color: #ffffff;
      border-radius: 10px;
      padding: 0.85rem 1.5rem;
      font-weight: 700;
      font-size: 0.95rem;
      letter-spacing: 0.03em;
      border: none;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      box-shadow: 0 4px 12px rgba(12, 43, 77, 0.2);
      min-height: 48px;
    }

    .btn-login-modern:hover {
      background: linear-gradient(135deg, #123d6c 0%, #1a5c9f 100%);
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(12, 43, 77, 0.28);
      color: #ffffff;
    }

    .btn-login-modern:focus-visible {
      outline: 2px solid var(--accent-sky);
      outline-offset: 3px;
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
      color: var(--accent-sky);
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .login-brand-panel { display: none; }
      .login-form-container { padding: 2.5rem 1.75rem; }
      .login-container { border-radius: 14px; margin: 0.5rem; }
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="login-container">
      
      <!-- Sisi Kiri: Informasi Klinik -->
      <div class="login-brand-panel">
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="login-brand-logo">
        <span class="portal-tag"><i class="fas fa-shield-alt mr-1"></i> PORTAL RESMI HRIS</span>
        <h3>Klinik Pratama</h3>
        <p>
          Sistem Informasi Manajemen Kepegawaian dan Penggajian Terpadu Dr. H.M. Hidayatullah
        </p>
      </div>

      <!-- Sisi Kanan: Form Autentikasi -->
      <div class="login-form-container">
        <div class="mb-4">
          <h2 class="h4 mb-1">Masuk ke Akun Anda</h2>
          <p class="text-muted small mb-0">Silakan masukkan kredensial resmi untuk mengakses sistem.</p>
        </div>
        
        <?php echo $this->session->flashdata('pesan') ?>

        <form method="POST" action="<?php echo base_url('login') ?>">
          
          <div class="form-group mb-3">
            <label class="font-weight-bold text-gray-700 small mb-1" for="username">Username SSO</label>
            <div class="position-relative">
              <input type="text" class="form-control-modern" id="username" name="username" placeholder="Masukkan Username..." required autofocus>
              <i class="fas fa-user input-icon-modern"></i>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>

          <div class="form-group mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="font-weight-bold text-gray-700 small mb-0" for="password">Kata Sandi</label>
              <a href="<?php echo base_url('lupa_password'); ?>" class="text-primary small font-weight-bold">
                Lupa Kata Sandi?
              </a>
            </div>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="password" id="password" placeholder="Masukkan Password..." required>
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi"></i>
            </div>
            <?php echo form_error('password', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>
          
          <!-- reCAPTCHA Widget -->
          <div class="form-group mb-4 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
          </div>
          
          <button type="submit" class="btn btn-login-modern btn-block font-weight-bold">
            MASUK KE SISTEM <i class="fas fa-arrow-right ml-2"></i>
          </button>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <div class="text-center mt-4 pt-3 border-top">
          <small class="text-muted">&copy; <?php echo date('Y') ?> Klinik Pratama Dr. H.M. Hidayatullah</small>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Logika Toggle Password Visibility
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
      togglePassword.addEventListener('click', function () {
        const isPassword = password.getAttribute('type') === 'password';
        const newType = isPassword ? 'text' : 'password';
        password.setAttribute('type', newType);
        this.classList.toggle('fa-eye-slash');
        this.setAttribute('title', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
        this.setAttribute('aria-label', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
      });
    }
  </script>
</body>
</html>