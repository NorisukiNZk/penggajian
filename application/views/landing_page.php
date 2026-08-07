<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Penggajian</title>
      <!-- StyleSheets -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/landing/css/bootstrap/bootstrap.min.css" />
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/landing/css/fontawesome/css/all.min.css" />
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/landing/css/style.css" />
      <style>
         /* Modern Navbar Glassmorphism */
         .navbar.fixed-top {
             background: rgba(255, 255, 255, 0.95) !important;
             backdrop-filter: blur(10px);
             -webkit-backdrop-filter: blur(10px);
             box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
             border-bottom: 1px solid rgba(255, 255, 255, 0.3);
             padding: 10px 0;
             transition: all 0.3s ease;
         }
         .navbar-brand {
             font-weight: 800;
             color: #0c2b4d !important;
             font-size: 1.5rem;
             letter-spacing: 1px;
             display: flex;
             align-items: center;
         }
         .navbar-brand img {
             width: 35px;
             margin-right: 10px;
         }
         .nav-link {
             font-weight: 600;
             color: #4a5568 !important;
             margin: 0 10px;
             transition: color 0.3s;
         }
         .nav-link:hover {
             color: #00BFD8 !important;
         }
         .btn-login-nav {
             background: linear-gradient(135deg, #0c2b4d, #1a4270);
             color: white !important;
             padding: 8px 24px !important;
             border-radius: 20px;
             font-weight: 700;
             box-shadow: 0 4px 15px rgba(12, 43, 77, 0.2);
             transition: transform 0.3s, box-shadow 0.3s;
             margin-left: 10px;
         }
         .btn-login-nav:hover {
             transform: translateY(-2px);
             box-shadow: 0 6px 20px rgba(12, 43, 77, 0.3);
             color: white !important;
         }

         /* Modern Footer */
         .Footer {
             background: #0c2b4d;
             color: #cbd5e0;
             padding: 4rem 0 1.5rem 0;
             position: relative;
             overflow: hidden;
         }
         .Footer::before {
             content: '';
             position: absolute;
             top: 0; left: 0; width: 100%; height: 4px;
             background: linear-gradient(90deg, #00BFD8, #0c2b4d);
         }
         .footer-title {
             color: white;
             font-weight: 700;
             font-size: 1.2rem;
             margin-bottom: 1rem;
         }
         .footer-text {
             font-size: 0.9rem;
             line-height: 1.6;
         }
         .social-icons a {
             color: white;
             background: rgba(255,255,255,0.1);
             display: inline-flex;
             width: 36px; height: 36px;
             align-items: center;
             justify-content: center;
             border-radius: 50%;
             margin-right: 10px;
             transition: all 0.3s;
             text-decoration: none;
         }
         .social-icons a:hover {
             background: #00BFD8;
             transform: translateY(-3px);
         }
         .copyright {
             border-top: 1px solid rgba(255,255,255,0.1);
             margin-top: 3rem;
             padding-top: 1.5rem;
             font-size: 0.85rem;
         }
         
         /* Modern Feature Cards */
         .feature-card {
             background: #ffffff;
             border-radius: 20px;
             border: 1px solid rgba(12, 43, 77, 0.05);
             transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
             position: relative;
             z-index: 1;
         }
         .feature-card::before {
             content: "";
             position: absolute;
             top: 0; left: 0; right: 0; bottom: 0;
             border-radius: 20px;
             background: linear-gradient(135deg, rgba(0, 191, 216, 0.05), rgba(12, 43, 77, 0.02));
             z-index: -1;
             opacity: 0;
             transition: opacity 0.4s;
         }
         .feature-card:hover {
             transform: translateY(-10px);
             box-shadow: 0 20px 40px rgba(12, 43, 77, 0.1) !important;
             border-color: rgba(0, 191, 216, 0.3);
         }
         .feature-card:hover::before {
             opacity: 1;
         }
         .feature-card img {
             transition: transform 0.4s ease;
             filter: drop-shadow(0 8px 16px rgba(0,0,0,0.1));
         }
         .feature-card:hover img {
             transform: scale(1.1) translateY(-5px);
         }
         .feature-card h5 {
             color: #0c2b4d;
             margin-top: 1.5rem;
         }
         .feature-card p {
             color: #64748b;
             line-height: 1.7;
         }
      </style>
   </head>
   <body>
      <!-- Pre Loader -->
      <div class="Loader" id="Loader">
         <div class="LoaderWrapper">
            <div class="circleBall"></div>
            <div class="circleBall"></div>
            <div class="circleBall"></div>
         </div>
      </div>
      <!-- Go to top Button -->
      <a href="#Home">
         <div class="Gototop">
               <i class="fa fa-angle-double-up text-white" aria-hidden="true"></i>
         </div>
      </a>
      <!-- Header Section -->
      <div class="Header" id="Home">
         <nav class="navbar fixed-top">
            <div class="container">
               <a class="navbar-brand" href="#">
                  <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo">
                  HRIS KPMH
               </a>
               <div class="collapse_menu deactive">
                  <i class="fa fa-bars" aria-hidden="true"></i>
                  <i class="fa fa-times" aria-hidden="true"></i>
                  <ul class="nav align-items-center">
                     <li class="nav-item">
                        <a class="nav-link" href="#Home">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#Tentang">Informasi</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link btn-login-nav" href="<?php echo base_url('login');?>"><i class="fas fa-sign-in-alt mr-2"></i> Portal Login</a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
         <div class="banner">
            <div class="layer">
               <div class="row Section align-items-center">
                  <div class="col-lg-6 mb-5 mb-lg-0">
                     <div class="box pr-lg-5">
                        <h1 class="font-weight-bold mb-4" style="color: #0c2b4d; font-size: 3.2rem; line-height: 1.2;">
                           Sistem Informasi <br> <span style="color: #00BFD8;">Kepegawaian</span>
                        </h1>
                        <p class="lead text-secondary mb-5" style="font-size: 1.1rem; line-height: 1.6;">
                           Platform Terpadu Pengelolaan SDM & Penggajian <br>Klinik Pratama Dr. H.M. Hidayatullah
                        </p>
                        <a href="<?php echo base_url('login');?>" class="btn btn-login-nav btn-lg px-5 py-3" style="font-size: 1.1rem;">
                           <i class="fas fa-rocket mr-2"></i> Mulai Eksplorasi
                        </a>
                     </div>
                  </div>
                  <div class="col-lg-6 headerImg text-center">
                     <img src="<?php echo base_url()?>assets/img/payroll.svg" alt="Payroll Illustration" class="img-fluid" style="max-height: 450px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.1));">
                  </div>
                  <div class="col-12 Dicover_Parent mt-5 pt-5">
                     <a href="#Tentang">
                        <div class="Discover shadow-sm" style="background: white; border-radius: 50%; width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s;">
                           <i class="fa fa-angle-double-down text-info" aria-hidden="true" style="font-size: 1.5rem;"></i>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Service Section -->
      <div class="Service" id="Tentang">
         <div class="Section">
            <div class="text-center">
               <h2>Informasi Website</h2>
               <div class="subHeading">
                  Berikut informasi singkat tentang website penggajian karyawan
               </div>
            </div>

            <div class="content mt-5">
               <div class="row justify-content-center">
                  <!-- Card 1 -->
                  <div class="col-md-6 col-lg-3 mb-4">
                     <div class="feature-card text-center p-4 shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                           <img src="<?php echo base_url(); ?>assets/img/tentang.svg" alt="Tentang" style="height: 100px;">
                        </div>
                        <h5 class="font-weight-bold">Tentang Sistem</h5>
                        <p class="small mt-3 mb-0">Sistem Informasi Kepegawaian terpadu yang dirancang khusus untuk memfasilitasi manajemen SDM, memantau kehadiran secara real-time, dan mengotomatisasi perhitungan gaji secara presisi.</p>
                     </div>
                  </div>

                  <!-- Card 2 -->
                  <div class="col-md-6 col-lg-3 mb-4">
                     <div class="feature-card text-center p-4 shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                           <img src="<?php echo base_url(); ?>assets/img/administrator.svg" alt="Admin" style="height: 100px;">
                        </div>
                        <h5 class="font-weight-bold">Portal HRD / Admin</h5>
                        <p class="small mt-3 mb-0">Ruang kendali HRD dengan Executive Dashboard untuk memonitor kedisiplinan harian, mengelola master data karyawan, mengatur komponen tunjangan dinamis, hingga mencetak laporan penggajian.</p>
                     </div>
                  </div>

                  <!-- Card 3 -->
                  <div class="col-md-6 col-lg-3 mb-4">
                     <div class="feature-card text-center p-4 shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                           <img src="<?php echo base_url(); ?>assets/img/karyawan.svg" alt="Pegawai" style="height: 100px;">
                        </div>
                        <h5 class="font-weight-bold">Portal Pegawai</h5>
                        <p class="small mt-3 mb-0">Halaman mandiri (Self-Service) bagi karyawan klinik untuk melakukan absensi digital secara real-time, memantau rekap kehadiran bulanan, serta mengunduh slip gaji digital langsung dari gadget mereka.</p>
                     </div>
                  </div>

                  <!-- Card 4 -->
                  <div class="col-md-6 col-lg-3 mb-4">
                     <div class="feature-card text-center p-4 shadow-sm h-100">
                        <div class="icon-wrapper mb-3">
                           <img src="<?php echo base_url(); ?>assets/img/others-fitur.svg" alt="Fitur" style="height: 100px;">
                        </div>
                        <h5 class="font-weight-bold">Keunggulan Keamanan</h5>
                        <p class="small mt-3 mb-0">Sistem ini dilengkapi perlindungan Enterprise-grade; enkripsi sandi Bcrypt modern, perisai anti-CSRF Global, filter anti-XSS, dan pemblokiran SQL Injection berbasis CodeIgniter Query Builder.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Footer Section -->
      <div class="Footer" id="Footer">
         <div class="container">
            <div class="row">
               <div class="col-md-5 mb-4">
                  <div class="footer-title">
                     <img src="<?php echo base_url(); ?>assets/img/kpmh.png" width="30" class="mr-2" style="filter: brightness(0) invert(1);"> 
                     Klinik dr. H.M. Hidayatullah
                  </div>
                  <p class="footer-text">Sistem Manajemen Sumber Daya Manusia Terpadu. Menghadirkan efisiensi dan transparansi dalam pengelolaan absensi, cuti, dan penggajian seluruh staf medis maupun non-medis.</p>
               </div>
               <div class="col-md-3 mb-4">
                  <div class="footer-title">Tautan Cepat</div>
                  <ul class="list-unstyled footer-text">
                     <li class="mb-2"><a href="#Home" class="text-light text-decoration-none"><i class="fas fa-chevron-right mr-2 text-info"></i> Beranda</a></li>
                     <li class="mb-2"><a href="#Tentang" class="text-light text-decoration-none"><i class="fas fa-chevron-right mr-2 text-info"></i> Informasi Sistem</a></li>
                     <li class="mb-2"><a href="<?php echo base_url('login'); ?>" class="text-light text-decoration-none"><i class="fas fa-chevron-right mr-2 text-info"></i> Portal Login</a></li>
                  </ul>
               </div>
               <div class="col-md-4 mb-4">
                  <div class="footer-title">Hubungi Kami</div>
                  <p class="footer-text mb-2"><i class="fas fa-map-marker-alt mr-2 text-info"></i> Jl. Kesehatan No. 123, Kota Anda</p>
                  <p class="footer-text mb-2"><i class="fas fa-phone mr-2 text-info"></i> (021) 1234-5678</p>
                  <p class="footer-text mb-3"><i class="fas fa-envelope mr-2 text-info"></i> hrd@klinikhidayatullah.com</p>
                  <div class="social-icons">
                     <a href="#"><i class="fab fa-facebook-f"></i></a>
                     <a href="#"><i class="fab fa-instagram"></i></a>
                     <a href="#"><i class="fab fa-twitter"></i></a>
                  </div>
               </div>
            </div>
            <div class="row copyright">
               <div class="col-12 text-center">
                  <p class="mb-0">&copy; <?php echo date('Y'); ?> Klinik Pratama Dr. H.M. Hidayatullah. All Rights Reserved.</p>
               </div>
            </div>
         </div>
      </div>
      <!-- Javascripts -->
      <script src="<?php echo base_url(); ?>assets/landing/js/jquery.js"></script>
      <script src="<?php echo base_url(); ?>assets/landing/js/bootstrap.js"></script>
      <script src="<?php echo base_url(); ?>assets/landing/js/script.js"></script>
   </body>
</html>