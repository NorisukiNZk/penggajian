<!DOCTYPE html>
<html lang="id">
<head>
  <script>
    // Gapless Dark Mode Pre-render Detection (Mencegah flash putih / FOUC)
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistem Informasi Manajemen Kepegawaian & Penggajian Terpadu (HRIS) Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">
  <meta name="author" content="Klinik Pratama Dr. H.M. Hidayatullah">
  <title>Enterprise HRIS & Payroll | Klinik Pratama Dr. H.M. Hidayatullah</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/kpmh.png" type="image/x-icon">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Bootstrap 4.6 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <style>
    /* =========================================================
       MODERN ENTERPRISE SAAS DESIGN SYSTEM
       ========================================================= */
    :root {
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --primary-navy: #0c2b4d;
      --primary-hover: #123d6c;
      --accent-cyan: #0ea5e9;
      --accent-glow: rgba(14, 165, 233, 0.25);
      --accent-cyan-light: #e0f2fe;
      --bg-body: #f8fafc;
      --card-bg: #ffffff;
      --card-border: rgba(226, 232, 240, 0.85);
      --text-main: #0f172a;
      --text-muted: #64748b;
      --navbar-bg: rgba(255, 255, 255, 0.92);
      --section-alt: #f1f5f9;
    }

    /* Dark Mode Tokens */
    html.dark-mode {
      --bg-body: #0b1120;
      --card-bg: #1e293b;
      --card-border: #334155;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --navbar-bg: rgba(15, 23, 42, 0.92);
      --section-alt: #0f172a;
    }

    /* View Transitions Tuning */
    ::view-transition-old(root),
    ::view-transition-new(root) {
      animation-duration: 0.35s;
      animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Seamless Transition */
    html.theme-transitioning,
    html.theme-transitioning *,
    html.theme-transitioning *:before,
    html.theme-transitioning *:after {
      transition: background-color 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                  border-color 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                  color 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                  box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: var(--bg-body);
      color: var(--text-main);
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      scroll-behavior: smooth;
    }

    /* Navbar Glassmorphism */
    .navbar-modern {
      background: var(--navbar-bg);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--card-border);
      padding: 0.85rem 0;
      transition: all 0.3s ease;
      z-index: 1050;
    }
    .navbar-brand {
      font-weight: 800;
      color: var(--primary-navy) !important;
      font-size: 1.25rem;
      letter-spacing: -0.02em;
      display: flex;
      align-items: center;
    }
    html.dark-mode .navbar-brand {
      color: #f8fafc !important;
    }
    .navbar-brand img {
      width: 38px;
      height: 38px;
      object-fit: contain;
      margin-right: 12px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .nav-link {
      font-weight: 600;
      color: var(--text-muted) !important;
      font-size: 0.925rem;
      padding: 0.5rem 1rem !important;
      transition: all 0.2s ease;
      border-radius: 8px;
    }
    .nav-link:hover {
      color: var(--accent-cyan) !important;
      background-color: rgba(14, 165, 233, 0.08);
    }
    .nav-link.active {
      color: var(--accent-cyan) !important;
    }

    /* Modern Buttons */
    .btn-portal-login {
      background: linear-gradient(135deg, #0c2b4d 0%, #164e87 100%);
      color: #ffffff !important;
      font-weight: 700;
      font-size: 0.9rem;
      padding: 0.65rem 1.45rem;
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 14px rgba(12, 43, 77, 0.25);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-portal-login:hover {
      background: linear-gradient(135deg, #103b69 0%, #1e5fa0 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(12, 43, 77, 0.35);
      color: #ffffff !important;
    }

    .btn-secondary-outline {
      border: 1.5px solid var(--card-border);
      color: var(--text-main) !important;
      background: var(--card-bg);
      font-weight: 700;
      font-size: 0.9rem;
      padding: 0.65rem 1.45rem;
      border-radius: 12px;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-secondary-outline:hover {
      border-color: var(--accent-cyan);
      color: var(--accent-cyan) !important;
      background: rgba(14, 165, 233, 0.05);
      transform: translateY(-2px);
    }

    /* Dark Mode Toggle Button */
    .btn-dark-toggle {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      border: 1.5px solid var(--card-border);
      background: var(--card-bg);
      color: var(--text-main);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
      margin-left: 0.5rem;
    }
    .btn-dark-toggle:hover {
      transform: scale(1.1);
      border-color: var(--accent-cyan);
      color: var(--accent-cyan);
    }
    #landingDarkIcon {
      transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Hero Section */
    .hero-section {
      padding: 8.5rem 0 5.5rem 0;
      position: relative;
      overflow: hidden;
      background-image: radial-gradient(at 15% 20%, rgba(14, 165, 233, 0.12) 0px, transparent 55%),
                        radial-gradient(at 85% 75%, rgba(99, 102, 241, 0.08) 0px, transparent 50%);
    }
    .badge-saas {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(14, 165, 233, 0.1);
      border: 1px solid rgba(14, 165, 233, 0.3);
      color: #0284c7;
      padding: 0.45rem 1.15rem;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 700;
      letter-spacing: 0.02em;
      margin-bottom: 1.5rem;
    }
    html.dark-mode .badge-saas {
      color: #38bdf8;
      background: rgba(14, 165, 233, 0.15);
      border-color: rgba(56, 189, 248, 0.3);
    }

    .hero-title {
      font-size: 3.25rem;
      font-weight: 800;
      line-height: 1.18;
      letter-spacing: -0.03em;
      margin-bottom: 1.5rem;
      color: var(--text-main);
    }
    .hero-title .text-gradient {
      background: linear-gradient(135deg, #0c2b4d 0%, #0ea5e9 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    html.dark-mode .hero-title .text-gradient {
      background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-lead {
      font-size: 1.125rem;
      line-height: 1.7;
      color: var(--text-muted);
      margin-bottom: 2.25rem;
      max-width: 540px;
    }

    .hero-illustration-wrapper {
      position: relative;
      text-align: center;
    }
    .hero-illustration-wrapper img.main-illus {
      max-height: 420px;
      width: auto;
      filter: drop-shadow(0 20px 35px rgba(12, 43, 77, 0.15));
      transition: transform 0.3s ease;
    }

    /* Floating Micro-Cards (Stable Healthcare Hierarchy) */
    .floating-card {
      position: absolute;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 0.85rem 1.15rem;
      box-shadow: 0 16px 36px -6px rgba(15, 23, 42, 0.15);
      display: flex;
      align-items: center;
      gap: 0.85rem;
      z-index: 2;
      backdrop-filter: blur(8px);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .floating-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 40px -8px rgba(15, 23, 42, 0.2);
    }
    .floating-card-1 {
      top: 15%;
      left: -5%;
    }
    .floating-card-2 {
      bottom: 15%;
      right: -2%;
    }

    /* Trust Badges Bar */
    .trust-badges-bar {
      padding: 1.75rem 0;
      border-top: 1px solid var(--card-border);
      border-bottom: 1px solid var(--card-border);
      background: var(--card-bg);
    }
    .trust-badge-item {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      font-weight: 700;
      color: var(--text-muted);
      padding: 0.5rem 1rem;
    }

    /* Stats Counter Section */
    .stats-section {
      padding: 4.5rem 0;
      background: var(--section-alt);
    }
    .stat-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 2.25rem 1.75rem;
      text-align: center;
      height: 100%;
      box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 35px -5px rgba(14, 165, 233, 0.15);
      border-color: rgba(14, 165, 233, 0.4);
    }
    .stat-card .stat-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: rgba(14, 165, 233, 0.1);
      color: var(--accent-cyan);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1.25rem;
    }
    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--text-main);
      line-height: 1.1;
      margin-bottom: 0.5rem;
      letter-spacing: -0.03em;
    }
    .stat-label {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 0.35rem;
    }
    .stat-desc {
      font-size: 0.825rem;
      color: var(--text-muted);
      margin-bottom: 0;
    }

    /* Features Section */
    .features-section {
      padding: 6.5rem 0;
      background: var(--bg-body);
    }
    .section-header {
      text-align: center;
      max-width: 720px;
      margin: 0 auto 4rem auto;
    }
    .section-subtitle {
      font-size: 0.85rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--accent-cyan);
      margin-bottom: 0.75rem;
      display: block;
    }
    .section-title {
      font-size: 2.35rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: var(--text-main);
      margin-bottom: 1rem;
    }
    .section-desc {
      font-size: 1.05rem;
      color: var(--text-muted);
      line-height: 1.6;
    }

    .feature-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 24px;
      padding: 2.5rem 2rem;
      height: 100%;
      box-shadow: 0 10px 30px -8px rgba(15, 23, 42, 0.06);
      transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 22px 45px -8px rgba(12, 43, 77, 0.12);
      border-color: rgba(14, 165, 233, 0.4);
    }
    .feature-icon-wrapper {
      width: 64px;
      height: 64px;
      border-radius: 18px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.75rem;
      margin-bottom: 1.75rem;
    }
    .feature-card h4 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 0.85rem;
      letter-spacing: -0.01em;
    }
    .feature-card p {
      font-size: 0.925rem;
      color: var(--text-muted);
      line-height: 1.7;
      margin-bottom: 1.25rem;
    }
    .feature-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .feature-list li {
      font-size: 0.875rem;
      color: var(--text-main);
      display: flex;
      align-items: center;
      gap: 0.65rem;
      margin-bottom: 0.65rem;
    }
    .feature-list li i {
      color: #10b981;
      font-size: 0.85rem;
    }

    /* Workflow Section */
    .workflow-section {
      padding: 6.5rem 0;
      background: var(--section-alt);
    }
    .workflow-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 2rem 1.5rem;
      position: relative;
      height: 100%;
      box-shadow: 0 8px 24px -6px rgba(15, 23, 42, 0.05);
      transition: all 0.3s ease;
    }
    .workflow-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 36px -6px rgba(15, 23, 42, 0.1);
      border-color: var(--accent-cyan);
    }
    .workflow-step-badge {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: linear-gradient(135deg, #0c2b4d 0%, #164e87 100%);
      color: #ffffff;
      font-weight: 800;
      font-size: 1.15rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.25rem;
      box-shadow: 0 6px 14px rgba(12, 43, 77, 0.25);
    }
    html.dark-mode .workflow-step-badge {
      background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
      box-shadow: 0 6px 14px rgba(14, 165, 233, 0.3);
    }
    .workflow-card h5 {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 0.75rem;
    }
    .workflow-card p {
      font-size: 0.875rem;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 0;
    }

    /* FAQ Section */
    .faq-section {
      padding: 6.5rem 0;
      background: var(--bg-body);
    }
    .faq-accordion .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border) !important;
      border-radius: 16px !important;
      margin-bottom: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 14px rgba(0,0,0,0.03);
      transition: all 0.25s ease;
    }
    .faq-accordion .card:hover {
      border-color: rgba(14, 165, 233, 0.3) !important;
    }
    .faq-accordion .card-header {
      background: transparent;
      border-bottom: none;
      padding: 1.35rem 1.75rem;
      cursor: pointer;
    }
    .faq-accordion .btn-link {
      color: var(--text-main);
      font-weight: 700;
      font-size: 1.05rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 0;
      text-align: left;
    }
    .faq-accordion .btn-link:hover,
    .faq-accordion .btn-link:focus {
      text-decoration: none;
      color: var(--accent-cyan);
    }
    .faq-accordion .card-body {
      padding: 0 1.75rem 1.35rem 1.75rem;
      font-size: 0.95rem;
      color: var(--text-muted);
      line-height: 1.7;
    }
    .faq-icon-chevron {
      transition: transform 0.3s ease;
      color: var(--accent-cyan);
      font-size: 0.9rem;
    }
    .btn-link.collapsed .faq-icon-chevron {
      transform: rotate(0deg);
    }
    .btn-link:not(.collapsed) .faq-icon-chevron {
      transform: rotate(180deg);
    }

    /* CTA Section */
    .cta-banner-section {
      padding: 5.5rem 0;
      background: linear-gradient(135deg, #0c2b4d 0%, #164e87 50%, #0c2b4d 100%);
      color: white;
      position: relative;
      overflow: hidden;
    }
    .cta-banner-section::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, transparent 65%);
      pointer-events: none;
    }

    /* Modern Footer */
    .footer-section {
      background: #071322;
      color: #94a3b8;
      padding: 5rem 0 2rem 0;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 0.925rem;
    }
    .footer-brand-title {
      color: #ffffff;
      font-weight: 800;
      font-size: 1.25rem;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .footer-text {
      line-height: 1.7;
      margin-bottom: 1.5rem;
      color: #94a3b8;
    }
    .footer-heading {
      color: #ffffff;
      font-weight: 700;
      font-size: 1rem;
      margin-bottom: 1.25rem;
      letter-spacing: -0.01em;
    }
    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .footer-links li {
      margin-bottom: 0.75rem;
    }
    .footer-links a {
      color: #94a3b8;
      text-decoration: none;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .footer-links a:hover {
      color: #38bdf8;
      transform: translateX(3px);
    }
    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      margin-top: 3.5rem;
      padding-top: 2rem;
      text-align: center;
      font-size: 0.85rem;
      color: #64748b;
    }

    /* Back to Top */
    .btn-back-to-top {
      position: fixed;
      bottom: 25px;
      right: 25px;
      width: 46px;
      height: 46px;
      border-radius: 14px;
      background: linear-gradient(135deg, #0c2b4d, #0ea5e9);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 25px rgba(12, 43, 77, 0.3);
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      z-index: 1000;
      border: none;
    }
    .btn-back-to-top.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .btn-back-to-top:hover {
      transform: translateY(-4px);
      box-shadow: 0 14px 30px rgba(14, 165, 233, 0.4);
      color: #ffffff;
    }

    @media (max-width: 991.98px) {
      .hero-title { font-size: 2.45rem; }
      .hero-section { padding: 7rem 0 4rem 0; text-align: center; }
      .hero-lead { margin: 0 auto 2rem auto; }
      .hero-illustration-wrapper { margin-top: 3.5rem; }
      .floating-card { display: none; }
      .navbar-collapse {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 1.25rem;
        margin-top: 1rem;
        box-shadow: 0 16px 36px rgba(0,0,0,0.12);
      }
    }
  </style>
</head>

<body>

  <!-- Modern Glassmorphism Navbar -->
  <nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#beranda">
        <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah">
        <span>HRIS KPMH</span>
      </a>

      <!-- Dark Mode Toggle Mobile + Hamburger -->
      <div class="d-flex align-items-center d-lg-none">
        <button class="btn-dark-toggle mr-2" id="landingDarkToggleMobile" title="Ubah Tema Gelap/Terang">
          <i class="fas fa-moon" id="landingDarkIconMobile"></i>
        </button>
        <button class="navbar-toggler p-2 border-0" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars text-primary" style="font-size: 1.4rem;"></i>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav ml-auto align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link active" href="#beranda">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#metrik">Statistik</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fitur">Fitur Unggulan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#alur">Alur Kerja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#faq">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#kontak">Kontak</a>
          </li>
          
          <!-- Dark Mode Toggle Desktop -->
          <li class="nav-item d-none d-lg-block">
            <button class="btn-dark-toggle" id="landingDarkToggle" title="Ubah Tema Gelap/Terang">
              <i class="fas fa-moon" id="landingDarkIcon"></i>
            </button>
          </li>

          <!-- Login Gateway Button -->
          <li class="nav-item ml-lg-3 mt-3 mt-lg-0">
            <a class="btn-portal-login" href="<?php echo base_url('login'); ?>">
              <i class="fas fa-arrow-right-to-bracket"></i> Portal Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section" id="beranda">
    <div class="container">
      <div class="row align-items-center">
        
        <!-- Left Content -->
        <div class="col-lg-6">
          <span class="badge-saas animate__animated animate__fadeInDown">
            <i class="fas fa-shield-halved text-info"></i> Enterprise HRIS & Payroll System v2.0
          </span>
          <h1 class="hero-title animate__animated animate__fadeInUp">
            Sistem Informasi <br>
            <span class="text-gradient">Penggajian & SDM</span> Terpadu
          </h1>
          <p class="hero-lead animate__animated animate__fadeInUp animate__delay-1s">
            Solusi digital komprehensif bagi <strong>Klinik Pratama Dr. H.M. Hidayatullah</strong> untuk mengotomasi komputasi gaji presisi (*Stateless*), mengaudit presensi anti-fraud, dan menerbitkan slip gaji berstandar resmi dengan verifikasi QR Code.
          </p>

          <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
            <a href="<?php echo base_url('login'); ?>" class="btn-portal-login py-3 px-4 mr-3 mb-2" style="font-size: 1rem;">
              <i class="fas fa-right-to-bracket mr-1"></i> Masuk ke Portal Login
            </a>
            <a href="#fitur" class="btn-secondary-outline py-3 px-4 mb-2" style="font-size: 1rem;">
              <i class="fas fa-compass mr-1"></i> Eksplorasi Fitur
            </a>
          </div>

          <!-- Mini Security Credential -->
          <div class="d-flex align-items-center text-muted small mt-2">
            <i class="fas fa-lock text-success mr-2"></i>
            <span>Dilindungi BCRYPT Hashing &bull; Google reCAPTCHA v2 &bull; Sesi Terisolasi</span>
          </div>
        </div>

        <!-- Right Illustration & Floating Badges -->
        <div class="col-lg-6 hero-illustration-wrapper">
          
          <!-- Floating Badge 1: Real-time Attendance -->
          <div class="floating-card floating-card-1">
            <div class="rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width: 40px; height: 40px;">
              <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="text-left">
              <div class="font-weight-bold text-gray-900" style="font-size: 0.875rem;">Audit Presensi Real-Time</div>
              <div class="text-muted small">Cross-Validation Anti-Fraud</div>
            </div>
          </div>

          <!-- Main SVG Illustration -->
          <img src="<?php echo base_url(); ?>assets/img/payroll.svg" alt="Payroll & HRIS Illustration" class="img-fluid main-illus">

          <!-- Floating Badge 2: Verified QR Code -->
          <div class="floating-card floating-card-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px;">
              <i class="fas fa-qrcode"></i>
            </div>
            <div class="text-left">
              <div class="font-weight-bold text-gray-900" style="font-size: 0.875rem;">Validasi QR Code Resmi</div>
              <div class="text-muted small">10 Format Cetak Legal</div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- Trust Badges Bar -->
  <div class="trust-badges-bar">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-6 col-md-3 trust-badge-item">
          <i class="fab fa-php text-primary fa-lg"></i>
          <span>CodeIgniter 3.1.11</span>
        </div>
        <div class="col-6 col-md-3 trust-badge-item">
          <i class="fas fa-shield-virus text-info fa-lg"></i>
          <span>BCRYPT & Anti-CSRF</span>
        </div>
        <div class="col-6 col-md-3 trust-badge-item">
          <i class="fas fa-chart-line text-danger fa-lg"></i>
          <span>Chart.js v4 Analytics</span>
        </div>
        <div class="col-6 col-md-3 trust-badge-item">
          <i class="fas fa-table text-success fa-lg"></i>
          <span>DataTables 2.2+ Modern</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Live Statistics Counter Section -->
  <section class="stats-section" id="metrik">
    <div class="container">
      <div class="row justify-content-center">
        
        <!-- Stat Card 1 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="stat-number"><?php echo isset($total_pegawai) ? $total_pegawai : 13; ?>+</div>
            <div class="stat-label">Pegawai Terdaftar</div>
            <p class="stat-desc">Data master pegawai, NIK unik, dan biodata medis/staf klinik.</p>
          </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
              <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-number"><?php echo isset($total_jabatan) ? $total_jabatan : 7; ?></div>
            <div class="stat-label">Struktur Jabatan</div>
            <p class="stat-desc">Klasifikasi skala upah pokok, tunjangan transport, dan uang makan.</p>
          </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
              <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="stat-number"><?php echo isset($total_laporan) ? $total_laporan : 10; ?></div>
            <div class="stat-label">Format Laporan Resmi</div>
            <p class="stat-desc">Slip gaji ESS, rekapitulasi gaji, lembur, dan absensi terstandar QR Code.</p>
          </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="stat-card">
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
              <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Komputasi Presisi</div>
            <p class="stat-desc">Logika stateless anti-double deduct untuk cicilan kasbon & potongan.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Core Features Section -->
  <section class="features-section" id="fitur">
    <div class="container">
      
      <div class="section-header">
        <span class="section-subtitle">ARSITEKTUR & KEUNGGULAN SISTEM</span>
        <h2 class="section-title">Modul Terintegrasi untuk Efisiensi Klinik</h2>
        <p class="section-desc">Platform HRIS dirancang dengan standar industri untuk memastikan transparansi penggajian, kedisiplinan kerja, dan kemudahan akses bagi seluruh staf.</p>
      </div>

      <div class="row">
        
        <!-- Feature 1: Payroll & Kasbon Stateless -->
        <div class="col-md-6 col-lg-6 mb-4">
          <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: rgba(14, 165, 233, 0.12); color: var(--accent-cyan);">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <h4>Manajemen Payroll & Kasbon (*Stateless Logic*)</h4>
            <p>Perhitungan upah otomatis berbasis komponen dinamis dengan arsitektur cicilan pinjaman (*Anti-Double Deduct*). Cetak slip berulang tidak akan mengurangi saldo kasbon secara keliru.</p>
            <ul class="feature-list">
              <li><i class="fas fa-check-circle"></i> Komputasi Gaji Pokok, Tunjangan Transport & Uang Makan</li>
              <li><i class="fas fa-check-circle"></i> Deductor Pinjaman Kasbon Otomatis dengan Pelabelan Angsuran</li>
              <li><i class="fas fa-check-circle"></i> Pemotongan Kehadiran Alpha Proporsional</li>
            </ul>
          </div>
        </div>

        <!-- Feature 2: Employee Self-Service (ESS) -->
        <div class="col-md-6 col-lg-6 mb-4">
          <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
              <i class="fas fa-user-gear"></i>
            </div>
            <h4>Employee Self-Service (ESS Portal)</h4>
            <p>Portal mandiri yang memberdayakan setiap pegawai klinik untuk mengakses data presensi, mengajukan permohonan secara mandiri, dan mengunduh slip gaji pribadi tanpa birokrasi manual.</p>
            <ul class="feature-list">
              <li><i class="fas fa-check-circle"></i> Monitoring Riwayat Kehadiran & Status Absensi Harian</li>
              <li><i class="fas fa-check-circle"></i> Pengajuan Cuti & Izin Sakit Online dengan Kolom Feedback HRD</li>
              <li><i class="fas fa-check-circle"></i> Download Slip Gaji Digital Resmi Kapan Saja</li>
            </ul>
          </div>
        </div>

        <!-- Feature 3: Smart Reporting & QR Validation -->
        <div class="col-md-6 col-lg-6 mb-4">
          <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
              <i class="fas fa-print"></i>
            </div>
            <h4>Standardisasi Dokumen & Validasi QR Code</h4>
            <p>Seluruh dokumen cetak memenuhi standar audit korporat resmi dengan Kop Instansi, Watermark pengaman, penomoran surat format Romawi otomatis, dan QR Code validasi digital pimpinan.</p>
            <ul class="feature-list">
              <li><i class="fas fa-check-circle"></i> 10 Matriks Laporan Resmi (Slip Gaji, Gaji Tahunan, Rekap Lembur, dsb.)</li>
              <li><i class="fas fa-check-circle"></i> Validasi Digital QR Code Pimpinan Klinik Pratama Hidayatullah</li>
              <li><i class="fas fa-check-circle"></i> Watermark Resmi & Nomor Surat Dinamis Berstandar Audit</li>
            </ul>
          </div>
        </div>

        <!-- Feature 4: Security Hardening & Password Recovery -->
        <div class="col-md-6 col-lg-6 mb-4">
          <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: rgba(99, 102, 241, 0.12); color: #6366f1;">
              <i class="fas fa-shield-halved"></i>
            </div>
            <h4>Keamanan Enterprise & Pemulihan Mandiri</h4>
            <p>Perlindungan data kepegawaian menyeluruh dengan enkripsi sandi BCRYPT, pertahanan anti-bot Google reCAPTCHA v2, anti-CSRF, dan modul pemulihan sandi mandiri (*Lupa Password*) berbasis NIK.</p>
            <ul class="feature-list">
              <li><i class="fas fa-check-circle"></i> Kriptografi Kredensial BCRYPT Standar Industri</li>
              <li><i class="fas fa-check-circle"></i> Fitur Pemulihan Password Mandiri (Verifikasi NIK Resmi)</li>
              <li><i class="fas fa-check-circle"></i> Google reCAPTCHA v2 Anti-Bot & Isolasi Sesi Reset</li>
            </ul>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Workflow Section -->
  <section class="workflow-section" id="alur">
    <div class="container">
      
      <div class="section-header">
        <span class="section-subtitle">ALUR KERJA OPERASIONAL</span>
        <h2 class="section-title">Bagaimana Sistem Bekerja</h2>
        <p class="section-desc">Dari pencatatan presensi harian hingga distribusi slip gaji resmi, seluruh tahapan terotomatisasi secara transparan dan akuntabel.</p>
      </div>

      <div class="row">
        
        <!-- Step 1 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="workflow-card text-center">
            <div class="workflow-step-badge">1</div>
            <h5>Presensi & Pengajuan</h5>
            <p>Pencatatan jam hadir/pulang aktual pegawai serta pengajuan cuti atau lembur secara mandiri melalui portal ESS.</p>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="workflow-card text-center">
            <div class="workflow-step-badge">2</div>
            <h5>Verifikasi HRD</h5>
            <p>HRD melakukan validasi silang (*cross-validation*) terhadap jam pulang aktual vs klaim lembur untuk mencegah manipulasi.</p>
          </div>
        </div>

        <!-- Step 3 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="workflow-card text-center">
            <div class="workflow-step-badge">3</div>
            <h5>Komputasi Payroll</h5>
            <p>Sistem secara otomatis mengakumulasi Gaji Pokok, Tunjangan, Uang Lembur, dan menyuntikkan cicilan kasbon dinamis.</p>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
          <div class="workflow-card text-center">
            <div class="workflow-step-badge">4</div>
            <h5>Slip Gaji & QR Code</h5>
            <p>Slip gaji resmi diterbitkan lengkap dengan nomor romawi, watermark instansi, dan verifikasi digital QR Code pimpinan.</p>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section" id="faq">
    <div class="container">
      
      <div class="section-header">
        <span class="section-subtitle">PERTANYAAN UMUM</span>
        <h2 class="section-title">Tanya Jawab Seputar Sistem (FAQ)</h2>
        <p class="section-desc">Jawaban ringkas dan jelas mengenai aspek teknis dan operasional sistem HRIS & Payroll Klinik Pratama Hidayatullah.</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="accordion faq-accordion" id="faqAccordion">
            
            <!-- Question 1 -->
            <div class="card">
              <div class="card-header" id="headingOne">
                <a class="btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <span>Bagaimana mekanisme pemulihan akun jika pegawai atau admin lupa password?</span>
                  <i class="fas fa-chevron-down faq-icon-chevron"></i>
                </a>
              </div>
              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                <div class="card-body">
                  Pengguna dapat mengklik tautan <strong>"Lupa Password?"</strong> pada halaman login. Sistem melakukan verifikasi identitas ganda (*Username SSO* dan *Nomor Induk Kependudukan/NIK* resmi yang terdaftar) serta proteksi Google reCAPTCHA. Jika data valid, sesi reset sementara dibuat untuk mengizinkan pengguna membuat password baru berenkripsi BCRYPT tanpa ketergantungan pada server email luar.
                </div>
              </div>
            </div>

            <!-- Question 2 -->
            <div class="card">
              <div class="card-header" id="headingTwo">
                <a class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <span>Bagaimana sistem mencegah terjadinya pemotongan kasbon ganda pada slip gaji?</span>
                  <i class="fas fa-chevron-down faq-icon-chevron"></i>
                </a>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                <div class="card-body">
                  Sistem mengadopsi mekanisme perhitungan pinjaman yang bersifat <strong>Stateless</strong>. Slip gaji tidak menyimpan mutasi pengurangan saldo statis ke database saat dicetak. Sistem mengevaluasi rentang bulan cicilan secara dinamis, sehingga pencetakan slip berulang kali tidak akan mengurangi saldo pinjaman secara keliru (*Anti-Double Deduct*).
                </div>
              </div>
            </div>

            <!-- Question 3 -->
            <div class="card">
              <div class="card-header" id="headingThree">
                <a class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <span>Bagaimana sistem memvalidasi klaim jam lembur agar bebas kecurangan?</span>
                  <i class="fas fa-chevron-down faq-icon-chevron"></i>
                </a>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                <div class="card-body">
                  Sistem secara otomatis menjalankan validasi silang (*Cross-Validation*) antara durasi jam lembur yang diajukan oleh pegawai dengan <strong>Waktu Pulang Aktual</strong> pada rekam kehadiran mesin absensi. Apabila pegawai pulang mendahului batas jam lembur, durasi lembur langsung dipotong secara proporsional.
                </div>
              </div>
            </div>

            <!-- Question 4 -->
            <div class="card">
              <div class="card-header" id="headingFour">
                <a class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  <span>Apakah dokumen laporan dan slip gaji dapat diverifikasi keasliannya?</span>
                  <i class="fas fa-chevron-down faq-icon-chevron"></i>
                </a>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                <div class="card-body">
                  Ya, setiap slip gaji dan dokumen laporan resmi dilengkapi dengan QR Code validasi digital pimpinan klinik, kop instansi resmi, nomor surat format Romawi dinamis, serta watermark instansi transparan untuk keperluan arsip legal dan audit formal.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- CTA Banner Section -->
  <section class="cta-banner-section text-center">
    <div class="container position-relative" style="z-index: 2;">
      <h2 class="font-weight-bold mb-3 text-white" style="font-size: 2.35rem; letter-spacing: -0.02em;">Siap Mengakses Sistem Kepegawaian?</h2>
      <p class="lead mb-4 text-light opacity-90 mx-auto" style="max-width: 620px;">
        Silakan masuk menggunakan akun kredensial yang telah didaftarkan oleh Administrator HRD Klinik Pratama Dr. H.M. Hidayatullah.
      </p>
      <div class="d-flex justify-content-center gap-3">
        <a href="<?php echo base_url('login'); ?>" class="btn btn-light btn-lg font-weight-bold px-5 py-3 shadow-lg" style="border-radius: 14px; color: #0c2b4d;">
          <i class="fas fa-arrow-right-to-bracket mr-2 text-primary"></i> Masuk ke Portal Login
        </a>
      </div>
    </div>
  </section>

  <!-- Modern Footer -->
  <footer class="footer-section" id="kontak">
    <div class="container">
      <div class="row">
        
        <!-- Col 1: Instansi & Profil -->
        <div class="col-lg-5 mb-4 mb-lg-0">
          <div class="footer-brand-title">
            <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo" width="34" height="34" style="filter: brightness(0) invert(1);">
            <span>Klinik Pratama Dr. H.M. Hidayatullah</span>
          </div>
          <p class="footer-text">
            Sistem Informasi Manajemen Kepegawaian & Penggajian Terpadu (*Enterprise HRIS & Payroll*). Menghadirkan transparansi, akurasi, dan efisiensi operasional bagi seluruh staf medis dan non-medis.
          </p>
          <div class="text-light small opacity-75">
            <i class="fas fa-shield-alt text-info mr-2"></i> Sistem Terverifikasi dan Terintegrasi &bull; Banjarbaru
          </div>
        </div>

        <!-- Col 2: Tautan Cepat -->
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
          <h5 class="footer-heading">Navigasi Utama</h5>
          <ul class="footer-links">
            <li><a href="#beranda"><i class="fas fa-angle-right text-info"></i> Beranda</a></li>
            <li><a href="#metrik"><i class="fas fa-angle-right text-info"></i> Metrik Operasional</a></li>
            <li><a href="#fitur"><i class="fas fa-angle-right text-info"></i> Fitur & Modul Payroll</a></li>
            <li><a href="#alur"><i class="fas fa-angle-right text-info"></i> Alur Kerja Sistem</a></li>
            <li><a href="#faq"><i class="fas fa-angle-right text-info"></i> Tanya Jawab (FAQ)</a></li>
          </ul>
        </div>

        <!-- Col 3: Portal & Kontak -->
        <div class="col-lg-4 col-md-6">
          <h5 class="footer-heading">Informasi & Bantuan</h5>
          <p class="footer-text mb-2">
            <i class="fas fa-map-marker-alt text-info mr-2"></i>
            Jl. A. Yani KM 23 Liang Anggang, Kota Banjarbaru, Kalimantan Selatan
          </p>
          <p class="footer-text mb-2">
            <i class="fas fa-phone text-info mr-2"></i>
            (0511) 4705000 &bull; Layanan HRD & Administrasi
          </p>
          <p class="footer-text mb-3">
            <i class="fas fa-envelope text-info mr-2"></i>
            hrd@klinikhidayatullah.com
          </p>
          
          <div class="mt-3">
            <a href="<?php echo base_url('lupa_password'); ?>" class="btn btn-outline-light btn-sm font-weight-bold px-3 py-2" style="border-radius: 10px;">
              <i class="fas fa-key mr-1 text-warning"></i> Pemulihan Akun (Lupa Password)
            </a>
          </div>
        </div>

      </div>

      <!-- Bottom Copyright -->
      <div class="footer-bottom">
        <div class="row align-items-center">
          <div class="col-md-6 text-center text-md-left mb-2 mb-md-0">
            &copy; <?php echo date('Y'); ?> <strong>Klinik Pratama Dr. H.M. Hidayatullah</strong>. All Rights Reserved.
          </div>
          <div class="col-md-6 text-center text-md-right">
            <span>Didedikasikan untuk Skripsi Bidang Teknologi Informasi</span>
          </div>
        </div>
      </div>

    </div>
  </footer>

  <!-- Back to Top Button -->
  <button class="btn-back-to-top" id="btnBackToTop" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
  </button>

  <!-- Scripts -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script>
    // =========================================================
    // SEAMLESS DARK MODE ENGINE FOR LANDING PAGE
    // =========================================================
    const landingDarkToggle = document.getElementById('landingDarkToggle');
    const landingDarkToggleMobile = document.getElementById('landingDarkToggleMobile');
    const landingDarkIcon = document.getElementById('landingDarkIcon');
    const landingDarkIconMobile = document.getElementById('landingDarkIconMobile');

    function syncDarkModeUI(isDark) {
      if (isDark) {
        document.documentElement.classList.add('dark-mode');
        document.body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        if (landingDarkIcon) {
          landingDarkIcon.className = 'fas fa-sun text-warning';
        }
        if (landingDarkIconMobile) {
          landingDarkIconMobile.className = 'fas fa-sun text-warning';
        }
      } else {
        document.documentElement.classList.remove('dark-mode');
        document.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        if (landingDarkIcon) {
          landingDarkIcon.className = 'fas fa-moon';
        }
        if (landingDarkIconMobile) {
          landingDarkIconMobile.className = 'fas fa-moon';
        }
      }
    }

    // Initial check on load
    if (localStorage.getItem('darkMode') === 'enabled') {
      syncDarkModeUI(true);
    }

    function toggleTheme() {
      const willBeDark = !document.documentElement.classList.contains('dark-mode');
      
      // Animate icon rotation
      if (landingDarkIcon) landingDarkIcon.style.transform = 'rotate(180deg) scale(0.7)';
      if (landingDarkIconMobile) landingDarkIconMobile.style.transform = 'rotate(180deg) scale(0.7)';

      if (document.startViewTransition) {
        document.startViewTransition(() => {
          syncDarkModeUI(willBeDark);
        }).finished.finally(() => {
          if (landingDarkIcon) landingDarkIcon.style.transform = 'rotate(0deg) scale(1)';
          if (landingDarkIconMobile) landingDarkIconMobile.style.transform = 'rotate(0deg) scale(1)';
        });
      } else {
        document.documentElement.classList.add('theme-transitioning');
        syncDarkModeUI(willBeDark);
        setTimeout(() => {
          if (landingDarkIcon) landingDarkIcon.style.transform = 'rotate(0deg) scale(1)';
          if (landingDarkIconMobile) landingDarkIconMobile.style.transform = 'rotate(0deg) scale(1)';
          setTimeout(() => {
            document.documentElement.classList.remove('theme-transitioning');
          }, 380);
        }, 50);
      }
    }

    if (landingDarkToggle) {
      landingDarkToggle.addEventListener('click', toggleTheme);
    }
    if (landingDarkToggleMobile) {
      landingDarkToggleMobile.addEventListener('click', toggleTheme);
    }

    // Back to Top Logic
    const btnBackToTop = document.getElementById('btnBackToTop');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        btnBackToTop.classList.add('show');
      } else {
        btnBackToTop.classList.remove('show');
      }
    });

    btnBackToTop.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Close mobile menu on click
    $('.navbar-nav>li>a:not(.dropdown-toggle)').on('click', function(){
      $('.navbar-collapse').collapse('hide');
    });
  </script>

</body>
</html>