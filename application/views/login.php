<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | HRIS Klinik Hidayatullah</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <style>
    body {
        background-color: #f4f7f6;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        background-image: radial-gradient(circle at 10% 20%, rgb(239, 246, 249) 0%, rgb(206, 239, 253) 90%);
    }
    .login-container {
        width: 100%;
        max-width: 1000px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(12, 43, 77, 0.15);
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
        backdrop-filter: blur(10px);
    }
    .login-image {
        flex: 1;
        /* Medical themed background with overlay */
        background: linear-gradient(135deg, rgba(12, 43, 77, 0.85), rgba(26, 66, 112, 0.75)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        color: white;
        text-align: center;
        position: relative;
    }
    .login-image::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: inherit;
        filter: blur(2px);
        z-index: -1;
    }
    .login-image img {
        width: 150px;
        margin-bottom: 1.5rem;
        drop-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .login-form-container {
        flex: 1;
        padding: 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
    }
    .login-form-container h2 {
        font-weight: 800;
        color: #0c2b4d;
        margin-bottom: 0.5rem;
    }
    .login-form-container p {
        color: #858796;
        margin-bottom: 2.5rem;
    }
    .form-control {
        border-radius: 12px;
        padding: 1.4rem 1.2rem;
        border: 2px solid #e3e6f0;
        background-color: #f8f9fc;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: #0c2b4d;
        box-shadow: 0 0 0 0.25rem rgba(12, 43, 77, 0.15);
        background-color: #fff;
    }
    .btn-login {
        background-color: #0c2b4d;
        color: white;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s;
        margin-top: 1rem;
    }
    .btn-login:hover {
        background-color: #1a4270;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(26, 66, 112, 0.4);
        color: white;
    }
    .input-icon {
        position: absolute;
        right: 15px;
        top: 43px;
        color: #d1d3e2;
        transition: color 0.2s;
    }
    .input-icon.clickable:hover {
        color: #0c2b4d;
        cursor: pointer;
    }
    .form-group {
        position: relative;
    }
    @media (max-width: 768px) {
        .login-image { display: none; }
        .login-form-container { padding: 3rem 2rem; }
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center h-100">
    <div class="login-container w-100">
      
      <!-- Left Side: Image/Branding -->
      <div class="login-image">
        <!-- Logo Klinik -->
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik">
        <h3 class="font-weight-bold mb-3">Portal HRIS</h3>
        <p class="mb-0">Sistem Manajemen Sumber Daya Manusia Terpadu<br>Klinik Pratama Dr. H.M. Hidayatullah</p>
      </div>

      <!-- Right Side: Form -->
      <div class="login-form-container">
        <h2>Selamat Datang!</h2>
        <p>Silakan masuk dengan akun yang terdaftar.</p>
        
        <?php echo $this->session->flashdata('pesan') ?>

        <form class="user" method="POST" action="<?php echo base_url('login') ?>">
          <div class="form-group mb-4">
            <label class="font-weight-bold text-gray-700 small mb-2">Username SSO</label>
            <input type="text" class="form-control" name="username" placeholder="Masukkan Username Anda..." required>
            <i class="fas fa-user input-icon"></i>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>
          <div class="form-group mb-4">
            <label class="font-weight-bold text-gray-700 small mb-2">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Anda..." required>
            <i class="fas fa-eye input-icon clickable" id="togglePassword" title="Tampilkan Password"></i>
            <?php echo form_error('password', '<div class="text-small text-danger mt-1">', '</div>') ?>
          </div>
          
          <button type="submit" class="btn btn-login btn-block">
            LOGIN SEKARANG <i class="fas fa-arrow-right ml-2"></i>
          </button>
        </form>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
        
        // Change title tooltip
        if (type === 'text') {
            this.setAttribute('title', 'Sembunyikan Password');
        } else {
            this.setAttribute('title', 'Tampilkan Password');
        }
    });
  </script>
</body>
</html>