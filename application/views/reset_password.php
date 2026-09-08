<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo isset($title) ? $title : 'Atur Ulang Password | HRIS Klinik Hidayatullah'; ?></title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Base Stylesheet -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <style>
    :root {
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      --primary-color: #0c2b4d;
      --accent-color: #0ea5e9;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      background-image: radial-gradient(at 10% 20%, rgba(224, 242, 254, 0.8) 0px, transparent 50%),
                        radial-gradient(at 90% 80%, rgba(219, 234, 254, 0.8) 0px, transparent 50%);
    }

    .login-container {
      width: 100%;
      max-width: 960px;
      background: rgba(255, 255, 255, 0.96);
      border-radius: 24px;
      box-shadow: 0 25px 60px -15px rgba(12, 43, 77, 0.18), 0 0 0 1px rgba(226, 232, 240, 0.8);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
      backdrop-filter: blur(12px);
    }

    .login-image {
      flex: 1.1;
      background: linear-gradient(145deg, rgba(12, 43, 77, 0.92), rgba(18, 61, 108, 0.88)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3.5rem 2.5rem;
      color: white;
      text-align: center;
      position: relative;
    }

    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .login-image img, .login-image h3, .login-image p, .login-badge {
      position: relative;
      z-index: 2;
    }

    .login-image img {
      width: 130px;
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 6px 12px rgba(0,0,0,0.3));
    }

    .login-form-container {
      flex: 1;
      padding: 3.5rem 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #ffffff;
    }

    .form-control-modern {
      border-radius: 12px;
      padding: 0.85rem 1.15rem;
      padding-right: 2.75rem;
      border: 1.5px solid #e2e8f0;
      background-color: #f8fafc;
      font-size: 0.95rem;
      font-family: var(--font-main);
      transition: all 0.2s ease;
      width: 100%;
      outline: none;
    }

    .form-control-modern:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
      background-color: #ffffff;
    }

    .btn-action-modern {
      background: linear-gradient(135deg, #0c2b4d 0%, #164e87 100%);
      color: white;
      border-radius: 12px;
      padding: 0.85rem 1.5rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      border: none;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(12, 43, 77, 0.25);
    }

    .btn-action-modern:hover {
      background: linear-gradient(135deg, #103b69 0%, #1c5f9f 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(12, 43, 77, 0.35);
      color: white;
    }

    .input-icon-modern {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
    }

    .input-icon-modern.clickable:hover {
      color: var(--accent-color);
      cursor: pointer;
    }

    .user-verified-badge {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 16px;
      padding: 0.85rem 1rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
    }

    @media (max-width: 768px) {
      .login-image { display: none; }
      .login-form-container { padding: 3rem 1.75rem; }
      .login-container { border-radius: 18px; margin: 1rem; }
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center py-4">
    <div class="login-container">
      
      <!-- Left Side: Branding -->
      <div class="login-image">
        <div id="particles-js"></div>
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik">
        <span class="badge badge-pill badge-success mb-3 px-3 py-1 font-weight-bold" style="letter-spacing: 0.08em; background-color: rgba(34, 197, 94, 0.3); border: 1px solid rgba(34, 197, 94, 0.5);">TERVERIFIKASI</span>
        <h3 class="font-weight-bold mb-2 text-white">Kata Sandi Baru</h3>
        <p class="text-light small opacity-75 mb-0" style="max-width: 320px; line-height: 1.6;">
          Buat kombinasi kata sandi baru yang kuat dan mudah Anda ingat untuk mengamankan akun Anda.
        </p>
      </div>

      <!-- Right Side: Reset Form -->
      <div class="login-form-container">
        <div class="mb-3">
          <h2 class="h4 font-weight-bold mb-1 text-gray-900">Atur Ulang Password</h2>
          <p class="text-muted small mb-0">Identitas akun terverifikasi. Silakan masukkan password baru.</p>
        </div>

        <!-- Verified Account Badge Card -->
        <div class="user-verified-badge shadow-sm">
          <div class="mr-3">
            <?php if (!empty($photo) && file_exists(FCPATH . 'photo/' . $photo)) : ?>
              <img src="<?php echo base_url('photo/' . $photo); ?>" alt="Photo" style="width: 44px; height: 44px; object-fit: cover; border-radius: 50%;" class="border">
            <?php else : ?>
              <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="fas fa-check"></i>
              </div>
            <?php endif; ?>
          </div>
          <div>
            <div class="font-weight-bold text-gray-900" style="font-size: 0.95rem;"><?php echo htmlspecialchars($nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="text-muted small">
              <span class="badge badge-light border text-primary">@<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
              <span class="mx-1">•</span>
              <span><?php echo htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
          </div>
        </div>

        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password/simpan_password'); ?>">
          
          <div class="form-group mb-3">
            <label class="font-weight-bold text-gray-700 small mb-1">Password Baru</label>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="password_baru" id="password_baru" placeholder="Minimal 4 karakter..." required autofocus>
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword1" title="Tampilkan Password"></i>
            </div>
            <?php echo form_error('password_baru', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold text-gray-700 small mb-1">Konfirmasi Password Baru</label>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi Password Baru..." required>
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword2" title="Tampilkan Password"></i>
            </div>
            <?php echo form_error('konfirmasi_password', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          
          <button type="submit" class="btn btn-action-modern btn-block py-3">
            SIMPAN PASSWORD BARU <i class="fas fa-check ml-2"></i>
          </button>

          <a href="<?php echo base_url('lupa_password/batal'); ?>" class="btn btn-light btn-block border py-2 mt-3 font-weight-bold text-gray-700" style="border-radius: 12px;">
            <i class="fas fa-times mr-2"></i> Batal & Kembali ke Login
          </a>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <div class="text-center mt-4 pt-2 border-top">
          <small class="text-muted">© <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah</small>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

  <script>
    // Toggle Password 1
    const togglePassword1 = document.querySelector('#togglePassword1');
    const passwordInput1 = document.querySelector('#password_baru');
    if (togglePassword1 && passwordInput1) {
      togglePassword1.addEventListener('click', function () {
        const type = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput1.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }

    // Toggle Password 2
    const togglePassword2 = document.querySelector('#togglePassword2');
    const passwordInput2 = document.querySelector('#konfirmasi_password');
    if (togglePassword2 && passwordInput2) {
      togglePassword2.addEventListener('click', function () {
        const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput2.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }

    // Particles.js
    if (document.getElementById('particles-js')) {
      particlesJS('particles-js', {
        "particles": {
          "number": { "value": 45, "density": { "enable": true, "value_area": 800 } },
          "color": { "value": "#ffffff" },
          "shape": { "type": "circle" },
          "opacity": { "value": 0.4, "random": true },
          "size": { "value": 3, "random": true },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.2,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 1.5,
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": { "onhover": { "enable": false }, "onclick": { "enable": false }, "resize": true }
        },
        "retina_detect": true
      });
    }
  </script>
</body>
</html>
