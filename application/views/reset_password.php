<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo isset($title) ? $title : 'Atur Ulang Password | HRIS Klinik Pratama Hidayatullah'; ?></title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Base Stylesheet -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
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
      background: rgba(16, 185, 129, 0.16);
      border: 1px solid rgba(16, 185, 129, 0.35);
      color: #6ee7b7;
      padding: 0.35rem 0.95rem;
      border-radius: 999px;
      font-size: 0.725rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin-bottom: 1.25rem;
      gap: 0.4rem;
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

    .security-tips-list {
      width: 100%;
      max-width: 330px;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    .security-tip-item {
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

    .tip-icon-box {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: rgba(16, 185, 129, 0.18);
      color: #6ee7b7;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      flex-shrink: 0;
    }

    .tip-text-group h4 {
      font-size: 0.825rem;
      font-weight: 700;
      color: #f1f5f9;
      margin: 0 0 2px 0;
    }

    .tip-text-group p {
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
      color: #059669;
      background: #ecfdf5;
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
      margin-bottom: 1.5rem;
      line-height: 1.5;
    }

    .verified-user-box {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 0.85rem 1rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.85rem;
    }

    .verified-avatar {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      object-fit: cover;
    }

    .verified-avatar-fallback {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: rgba(14, 165, 233, 0.14);
      color: var(--sky-main);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      flex-shrink: 0;
    }

    .verified-meta h5 {
      font-size: 0.925rem;
      font-weight: 700;
      color: var(--text-dark);
      margin: 0 0 2px 0;
    }

    .verified-meta p {
      font-size: 0.785rem;
      color: var(--text-muted);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.35rem;
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

    .btn-back-outline {
      background: #ffffff;
      color: #475569;
      border: 1.5px solid var(--border-color);
      border-radius: 12px;
      padding: 0.75rem 1.25rem;
      font-weight: 600;
      font-size: 0.9rem;
      width: 100%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.85rem;
      text-decoration: none;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      min-height: 46px;
    }

    .btn-back-outline:hover {
      background: #f8fafc;
      color: var(--navy-main);
      border-color: #cbd5e1;
      text-decoration: none;
      transform: translateY(-1px);
    }

    .form-footer-copyright {
      text-align: center;
      margin-top: 2rem;
      padding-top: 1.25rem;
      border-top: 1px solid #f1f5f9;
      color: #94a3b8;
      font-size: 0.785rem;
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
      
      <!-- Sisi Kiri: Panel Informasi Pengaturan Sandi -->
      <section class="brand-panel" aria-label="Informasi Pembaruan Sandi">
        <div class="brand-content">
          <div class="brand-logo-wrap">
            <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>
          
          <span class="brand-badge">
            <i class="fas fa-check-circle"></i> IDENTITAS TERVERIFIKASI
          </span>
          
          <h1 class="brand-title">Atur Sandi Baru</h1>
          <p class="brand-description">
            Buat kombinasi kata sandi baru yang kuat untuk melindungi akun dan privasi data kepegawaian Anda.
          </p>

          <div class="security-tips-list">
            <div class="security-tip-item">
              <div class="tip-icon-box">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="tip-text-group">
                <h4>Panjang Sandi</h4>
                <p>Gunakan minimal 4 karakter unik</p>
              </div>
            </div>

            <div class="security-tip-item">
              <div class="tip-icon-box">
                <i class="fas fa-key"></i>
              </div>
              <div class="tip-text-group">
                <h4>Kombinasi Karakter</h4>
                <p>Kombinasikan huruf, angka, dan simbol</p>
              </div>
            </div>

            <div class="security-tip-item">
              <div class="tip-icon-box">
                <i class="fas fa-lock"></i>
              </div>
              <div class="tip-text-group">
                <h4>Jaga Kerahasiaan</h4>
                <p>Hindari tanggal lahir atau data publik</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-lock text-info"></i> Sistem Terenkripsi 256-Bit SSL
        </div>
      </section>

      <!-- Sisi Kanan: Formulir Pembaruan Sandi -->
      <section class="form-container" aria-label="Formulir Buat Kata Sandi Baru">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-shield-halved"></i> TAHAP TERAKHIR PEMULIHAN
          </span>
          <h2 class="auth-title">Atur Ulang Kata Sandi</h2>
          <p class="auth-subtitle">Identitas pegawai telah diverifikasi. Silakan masukkan kata sandi baru Anda.</p>
        </div>

        <!-- Kartu Identitas Pegawai Terverifikasi -->
        <div class="verified-user-box">
          <?php 
          $photo_url = (!empty($photo) && file_exists(FCPATH . 'assets/photo/' . $photo))
            ? base_url('assets/photo/' . $photo)
            : ((!empty($photo) && file_exists(FCPATH . 'photo/' . $photo)) ? base_url('photo/' . $photo) : '');
          ?>
          <?php if (!empty($photo_url)) : ?>
            <img src="<?php echo $photo_url; ?>" alt="<?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>" class="verified-avatar border">
          <?php else : ?>
            <div class="verified-avatar-fallback">
              <i class="fas fa-user-check"></i>
            </div>
          <?php endif; ?>
          <div class="verified-meta">
            <h5><?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></h5>
            <p>
              <span class="badge badge-light border text-primary font-weight-bold">@<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
              <span>&bull;</span>
              <span><?php echo htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
            </p>
          </div>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password/simpan_password'); ?>" novalidate id="formReset">
          
          <div class="form-group mb-3">
            <label class="form-label" for="password_baru">Kata Sandi Baru</label>
            <div class="input-wrapper">
              <input type="password" class="form-control-modern" name="password_baru" id="password_baru" placeholder="Masukkan kata sandi baru..." required autofocus autocomplete="new-password">
              <i class="fas fa-lock input-icon-left" aria-hidden="true"></i>
              <i class="fas fa-eye password-toggle-btn" id="togglePassword1" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <?php echo form_error('password_baru', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
            <label class="form-label" for="konfirmasi_password">Konfirmasi Kata Sandi Baru</label>
            <div class="input-wrapper">
              <input type="password" class="form-control-modern" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi kata sandi baru..." required autocomplete="new-password">
              <i class="fas fa-shield-alt input-icon-left" aria-hidden="true"></i>
              <i class="fas fa-eye password-toggle-btn" id="togglePassword2" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <?php echo form_error('konfirmasi_password', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          
          <button type="submit" class="btn-auth-primary" id="btnSubmitReset">
            <span>Simpan Kata Sandi Baru</span>
            <i class="fas fa-check ml-2"></i>
          </button>

          <a href="<?php echo base_url('lupa_password/batal'); ?>" class="btn-back-outline">
            <i class="fas fa-times"></i>
            <span>Batal dan Kembali ke Login</span>
          </a>
        
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
  
  <script>
    function setupToggle(buttonId, inputId) {
      const btn = document.querySelector(buttonId);
      const input = document.querySelector(inputId);
      if (!btn || !input) return;

      function toggle() {
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        btn.classList.toggle('fa-eye-slash');
        btn.setAttribute('title', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
        btn.setAttribute('aria-label', isPassword ? 'Sembunyikan Kata Sandi' : 'Tampilkan Kata Sandi');
      }

      btn.addEventListener('click', toggle);
      btn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggle();
        }
      });
    }

    setupToggle('#togglePassword1', '#password_baru');
    setupToggle('#togglePassword2', '#konfirmasi_password');
  </script>
</body>
</html>
