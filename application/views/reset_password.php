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
      --navy-deep: #07172b;
      --navy-main: #0c2b4d;
      --navy-light: #123d6c;
      --sky-main: #0284c7;
      --sky-hover: #0369a1;
      --emerald-main: #059669;
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
      background: rgba(16, 185, 129, 0.18);
      border: 1px solid rgba(52, 211, 153, 0.4);
      color: #6ee7b7;
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

    .security-tips {
      list-style: none;
      padding: 0;
      margin: 0;
      text-align: left;
      width: 100%;
      max-width: 310px;
    }

    .security-tips li {
      display: flex;
      align-items: center;
      font-size: 0.825rem;
      color: #cbd5e1;
      margin-bottom: 0.75rem;
    }

    .security-tips li i {
      width: 22px;
      color: #34d399;
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
      margin-bottom: 1.25rem;
    }

    .verified-user-card {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 12px;
      padding: 0.75rem 1rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
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
    }

    .input-icon-modern.clickable {
      cursor: pointer;
    }

    .input-icon-modern.clickable:hover {
      color: var(--sky-main);
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

    .btn-back-outline {
      background: transparent;
      color: #475569;
      border: 1.5px solid var(--border-color);
      border-radius: 10px;
      padding: 0.75rem 1.25rem;
      font-weight: 600;
      font-size: 0.9rem;
      width: 100%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-top: 0.85rem;
      text-decoration: none;
      transition: all 0.2s;
      min-height: 44px;
    }

    .btn-back-outline:hover {
      background: #f1f5f9;
      color: var(--navy-main);
      border-color: #cbd5e1;
      text-decoration: none;
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
      
      <!-- Sisi Kiri: Panel Informasi Pengaturan Sandi -->
      <section class="brand-panel" aria-label="Informasi Pembaruan Sandi">
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
        <span class="brand-badge"><i class="fas fa-check-circle mr-1"></i> IDENTITAS TERVERIFIKASI</span>
        <h1>Kata Sandi Baru</h1>
        <p>
          Buat kombinasi kata sandi baru yang aman untuk melindungi akun dan akses data kepegawaian Anda.
        </p>
        <ul class="security-tips">
          <li><i class="fas fa-shield-halved"></i> Minimal 4 karakter unik</li>
          <li><i class="fas fa-lock"></i> Gunakan kombinasi huruf dan angka</li>
          <li><i class="fas fa-key"></i> Jangan gunakan tanggal lahir atau nama</li>
        </ul>
      </section>

      <!-- Sisi Kanan: Formulir Pembaruan Sandi -->
      <section class="form-container" aria-label="Formulir Buat Kata Sandi Baru">
        <div>
          <h2>Atur Ulang Kata Sandi</h2>
          <p class="subtitle">Identitas pegawai telah diverifikasi. Silakan masukkan kata sandi baru.</p>
        </div>

        <!-- Kartu Identitas Pegawai Terverifikasi -->
        <div class="verified-user-card shadow-xs">
          <div class="mr-3">
            <?php 
            $photo_url = (!empty($photo) && file_exists(FCPATH . 'assets/photo/' . $photo))
              ? base_url('assets/photo/' . $photo)
              : ((!empty($photo) && file_exists(FCPATH . 'photo/' . $photo)) ? base_url('photo/' . $photo) : '');
            ?>
            <?php if (!empty($photo_url)) : ?>
              <img src="<?php echo $photo_url; ?>" alt="<?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 50%;" class="border">
            <?php else : ?>
              <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="fas fa-user-check"></i>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <div class="font-weight-bold text-dark" style="font-size: 0.95rem;"><?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="text-muted small">
              <span class="badge badge-light border text-primary">@<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
              <span class="mx-1">•</span>
              <span><?php echo htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
          </div>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password/simpan_password'); ?>" novalidate>
          
          <div class="form-group mb-3">
            <label class="form-label" for="password_baru">Kata Sandi Baru</label>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="password_baru" id="password_baru" placeholder="Minimal 4 karakter..." required autofocus autocomplete="new-password">
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword1" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <?php echo form_error('password_baru', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
            <label class="form-label" for="konfirmasi_password">Konfirmasi Kata Sandi Baru</label>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi Kata Sandi Baru..." required autocomplete="new-password">
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword2" title="Tampilkan Kata Sandi" aria-label="Tampilkan Kata Sandi" role="button" tabindex="0"></i>
            </div>
            <?php echo form_error('konfirmasi_password', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          
          <button type="submit" class="btn-auth-primary">
            Simpan Kata Sandi Baru
          </button>

          <a href="<?php echo base_url('lupa_password/batal'); ?>" class="btn-back-outline">
            <i class="fas fa-times mr-2"></i> Batal dan Kembali ke Login
          </a>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

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
