<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | HRIS Klinik Hidayatullah</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS v4 Browser Runtime -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- FontAwesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Base Stylesheet -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
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

    .login-form-container h2 {
      font-weight: 800;
      color: #0c2b4d;
      letter-spacing: -0.02em;
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

    .btn-login-modern {
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

    .btn-login-modern:hover {
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
      transition: color 0.2s;
    }

    .input-icon-modern.clickable:hover {
      color: var(--accent-color);
      cursor: pointer;
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
      
      <!-- Left Side: Image/Branding -->
      <div class="login-image">
        <div id="particles-js"></div>
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik">
        <span class="badge badge-pill badge-info mb-3 px-3 py-1 font-weight-bold" style="letter-spacing: 0.08em; background-color: rgba(14, 165, 233, 0.3); border: 1px solid rgba(14, 165, 233, 0.5);">PORTAL RESMI</span>
        <h3 class="font-weight-bold mb-2 text-white">HRIS & Penggajian</h3>
        <p class="text-light small opacity-75 mb-0" style="max-width: 320px; line-height: 1.6;">
          Sistem Manajemen SDM & Penggajian Terpadu Klinik Pratama Dr. H.M. Hidayatullah
        </p>
      </div>

      <!-- Right Side: Form -->
      <div class="login-form-container">
        <div class="mb-4">
          <h2 class="h4 mb-1">Selamat Datang! 👋</h2>
          <p class="text-muted small mb-0">Silakan masuk menggunakan akun kredensial Anda.</p>
        </div>
        
        <?php echo $this->session->flashdata('pesan') ?>

        <form method="POST" action="<?php echo base_url('login') ?>">
          
          <div class="form-group mb-3">
            <label class="font-weight-bold text-gray-700 small mb-1">Username SSO</label>
            <div class="position-relative">
              <input type="text" class="form-control-modern" name="username" placeholder="Masukkan Username..." required autofocus>
              <i class="fas fa-user input-icon-modern"></i>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold text-gray-700 small mb-1">Password</label>
            <div class="position-relative">
              <input type="password" class="form-control-modern" name="password" id="password" placeholder="Masukkan Password..." required>
              <i class="fas fa-eye input-icon-modern clickable" id="togglePassword" title="Tampilkan Password"></i>
            </div>
            <?php echo form_error('password', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>
          
          <!-- reCAPTCHA Widget -->
          <div class="form-group mb-4 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
          </div>
          
          <button type="submit" class="btn btn-login-modern btn-block">
            MASUK KE SISTEM <i class="fas fa-arrow-right ml-2"></i>
          </button>
        
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>

        <div class="text-center mt-4 pt-2 border-top">
          <small class="text-muted">© <?php echo date('Y') ?> Klinik Pratama Dr. H.M. Hidayatullah</small>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  
  <script>
    // Initialize Particles.js
    if (document.getElementById('particles-js')) {
      particlesJS('particles-js', {
        "particles": {
          "number": {
            "value": 50,
            "density": { "enable": true, "value_area": 800 }
          },
          "color": { "value": "#ffffff" },
          "shape": { "type": "circle" },
          "opacity": {
            "value": 0.4,
            "random": true
          },
          "size": {
            "value": 3,
            "random": true
          },
          "line_linked": {
            "enable": true,
            "distance": 140,
            "color": "#ffffff",
            "opacity": 0.3,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 1.5,
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out"
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": { "enable": true, "mode": "grab" },
            "onclick": { "enable": true, "mode": "push" },
            "resize": true
          },
          "modes": {
            "grab": { "distance": 130, "line_linked": { "opacity": 0.8 } }
          }
        },
        "retina_detect": true
      });
    }

    // Password Toggle Logic
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
      togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        if (type === 'text') {
          this.setAttribute('title', 'Sembunyikan Password');
        } else {
          this.setAttribute('title', 'Tampilkan Password');
        }
      });
    }
  </script>
</body>
</html>