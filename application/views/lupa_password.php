<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo isset($title) ? $title : 'Pemulihan Akun | HRIS Klinik Pratama Dr. H.M. Hidayatullah'; ?></title>
  <meta name="description" content="Portal Pemulihan Akun & Lupa Password HRIS Klinik Pratama Dr. H.M. Hidayatullah Banjarbaru.">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/kpmh.png" type="image/x-icon">

  <!-- Pre-render Theme Check (Anti-FOUC) -->
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Base Stylesheet (SB Admin 2) -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Google reCAPTCHA v2 -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <style>
    /* =========================================================
       DESIGN SYSTEM TOKENS (LIGHT & DARK MODE)
       ========================================================= */
    :root {
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --navy-deep: #061528;
      --navy-main: #0c2b4d;
      --navy-light: #164070;
      --sky-main: #0284c7;
      --sky-hover: #0369a1;
      --sky-light: #f0f9ff;
      --sky-glow: rgba(2, 132, 199, 0.18);
      
      --bg-page: #f8fafc;
      --bg-mesh-1: rgba(14, 165, 233, 0.08);
      --bg-mesh-2: rgba(12, 43, 77, 0.07);
      
      --card-bg: #ffffff;
      --card-border: rgba(226, 232, 240, 0.95);
      --card-shadow: 0 25px 60px -15px rgba(12, 43, 77, 0.16), 0 10px 25px -5px rgba(12, 43, 77, 0.05);
      
      --text-title: #0f172a;
      --text-body: #334155;
      --text-muted: #64748b;
      
      --input-bg: #f8fafc;
      --input-border: #e2e8f0;
      --input-text: #0f172a;
      --input-hover-border: #cbd5e1;
      --input-focus-border: #0284c7;
      
      --emerald-accent: #10b981;
      --amber-accent: #f59e0b;
      --rose-accent: #f43f5e;
      --topbar-bg: rgba(255, 255, 255, 0.85);
      --topbar-border: rgba(226, 232, 240, 0.8);
    }

    html.dark-mode {
      --bg-page: #070d18;
      --bg-mesh-1: rgba(14, 165, 233, 0.05);
      --bg-mesh-2: rgba(15, 23, 42, 0.6);
      
      --card-bg: #0f1c2e;
      --card-border: rgba(51, 65, 85, 0.6);
      --card-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6), 0 10px 30px -5px rgba(0, 0, 0, 0.4);
      
      --text-title: #f8fafc;
      --text-body: #cbd5e1;
      --text-muted: #94a3b8;
      
      --input-bg: #142338;
      --input-border: #1e3a5f;
      --input-text: #f8fafc;
      --input-hover-border: #2563eb;
      --input-focus-border: #38bdf8;
      
      --topbar-bg: rgba(15, 28, 46, 0.85);
      --topbar-border: rgba(51, 65, 85, 0.5);
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: var(--bg-page);
      background-image: 
        radial-gradient(at 0% 0%, var(--bg-mesh-1) 0px, transparent 50%),
        radial-gradient(at 100% 100%, var(--bg-mesh-2) 0px, transparent 50%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 1.5rem 1rem 2rem;
      color: var(--text-body);
      -webkit-font-smoothing: antialiased;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Top Floating Utility Bar */
    .top-utility-bar {
      width: 100%;
      max-width: 1020px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.25rem;
      padding: 0 0.25rem;
    }

    .btn-utility-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.84rem;
      font-weight: 700;
      color: var(--text-muted);
      text-decoration: none;
      padding: 0.45rem 0.95rem;
      background: var(--topbar-bg);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid var(--topbar-border);
      border-radius: 999px;
      transition: all 0.2s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .btn-utility-link:hover {
      color: var(--sky-main);
      border-color: var(--sky-main);
      transform: translateY(-1px);
      text-decoration: none;
    }

    .top-actions-right {
      display: flex;
      align-items: center;
      gap: 0.65rem;
    }

    .status-pill-secure {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      font-size: 0.76rem;
      font-weight: 700;
      color: var(--emerald-accent);
      background: rgba(16, 185, 129, 0.08);
      border: 1px solid rgba(16, 185, 129, 0.25);
      padding: 0.4rem 0.85rem;
      border-radius: 999px;
    }

    .pulse-dot {
      width: 8px;
      height: 8px;
      background-color: var(--emerald-accent);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--emerald-accent);
      animation: pulseGlow 2s infinite;
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.45; transform: scale(1.2); }
    }

    .theme-toggle-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--topbar-bg);
      backdrop-filter: blur(8px);
      border: 1px solid var(--topbar-border);
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.95rem;
      transition: all 0.25s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .theme-toggle-btn:hover {
      color: var(--sky-main);
      border-color: var(--sky-main);
      transform: rotate(15deg) scale(1.05);
    }

    /* Main Auth Container */
    .auth-wrapper {
      width: 100%;
      max-width: 1020px;
    }

    .auth-card {
      background: var(--card-bg);
      border-radius: 24px;
      border: 1px solid var(--card-border);
      box-shadow: var(--card-shadow);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
      transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Sisi Kiri: Brand Panel */
    .brand-panel {
      flex: 1.05;
      background: linear-gradient(155deg, #041021 0%, #0c2b4d 55%, #13457b 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      padding: 3.5rem 2.85rem;
      color: #ffffff;
      text-align: center;
      position: relative;
    }

    .brand-panel::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: 
        radial-gradient(circle at 15% 15%, rgba(14, 165, 233, 0.2), transparent 45%),
        radial-gradient(circle at 85% 85%, rgba(16, 185, 129, 0.12), transparent 45%);
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

    .brand-logo-pod {
      width: 98px;
      height: 98px;
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border: 1.5px solid rgba(255, 255, 255, 0.25);
      border-radius: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .brand-logo-pod:hover {
      transform: translateY(-3px) scale(1.03);
    }

    .brand-logo {
      width: 66px;
      height: auto;
      filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.25));
    }

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      background: rgba(14, 165, 233, 0.18);
      border: 1px solid rgba(56, 189, 248, 0.4);
      color: #7dd3fc;
      padding: 0.35rem 0.95rem;
      border-radius: 999px;
      font-size: 0.725rem;
      font-weight: 800;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin-bottom: 1.15rem;
    }

    .brand-title {
      font-size: 1.55rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.025em;
      line-height: 1.28;
      margin-bottom: 0.65rem;
    }

    .brand-description {
      color: #94a3b8;
      font-size: 0.885rem;
      line-height: 1.6;
      max-width: 325px;
      margin: 0 auto 2rem auto;
    }

    /* 3-Step Interactive Breadcrumb Stepper */
    .recovery-steps-list {
      width: 100%;
      max-width: 335px;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    .recovery-step-item {
      display: flex;
      align-items: flex-start;
      gap: 0.85rem;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      padding: 0.85rem 1rem;
      border-radius: 14px;
      text-align: left;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      transition: all 0.25s ease;
    }

    .recovery-step-item.is-active {
      background: rgba(14, 165, 233, 0.18);
      border-color: rgba(56, 189, 248, 0.45);
      box-shadow: 0 4px 16px rgba(14, 165, 233, 0.2);
    }

    .step-number-badge {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #cbd5e1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.785rem;
      font-weight: 800;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .recovery-step-item.is-active .step-number-badge {
      background: #0284c7;
      border-color: #38bdf8;
      color: #ffffff;
      box-shadow: 0 0 10px rgba(14, 165, 233, 0.6);
    }

    .step-text-group h4 {
      font-size: 0.835rem;
      font-weight: 700;
      color: #f1f5f9;
      margin: 0 0 2px 0;
    }

    .step-text-group p {
      font-size: 0.725rem;
      color: #94a3b8;
      margin: 0;
      line-height: 1.35;
    }

    .brand-footer-pill {
      position: relative;
      z-index: 2;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.735rem;
      color: #94a3b8;
      background: rgba(255, 255, 255, 0.05);
      padding: 0.4rem 0.95rem;
      border-radius: 999px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Sisi Kanan: Form Container */
    .form-container {
      flex: 1.02;
      padding: 3.5rem 3.25rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: var(--card-bg);
      transition: background 0.3s ease;
    }

    .form-header-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.735rem;
      font-weight: 800;
      color: var(--sky-main);
      background: var(--sky-light);
      padding: 0.25rem 0.75rem;
      border-radius: 6px;
      margin-bottom: 0.75rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }

    html.dark-mode .form-header-badge {
      background: rgba(2, 132, 199, 0.16);
      color: #38bdf8;
    }

    .auth-title {
      font-weight: 800;
      color: var(--text-title);
      font-size: 1.65rem;
      letter-spacing: -0.025em;
      margin-bottom: 0.4rem;
    }

    .auth-subtitle {
      color: var(--text-muted);
      font-size: 0.895rem;
      margin-bottom: 1.85rem;
      line-height: 1.5;
    }

    .form-label {
      font-size: 0.84rem;
      font-weight: 700;
      color: var(--text-body);
      margin-bottom: 0.45rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .label-counter {
      font-size: 0.725rem;
      font-weight: 600;
      color: var(--text-muted);
    }

    .input-wrapper {
      position: relative;
    }

    .form-control-modern {
      border-radius: 12px;
      padding: 0.8rem 2.85rem 0.8rem 2.95rem;
      border: 1.5px solid var(--input-border);
      background-color: var(--input-bg);
      font-size: 0.925rem;
      font-family: var(--font-main);
      color: var(--input-text);
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      width: 100%;
      outline: none;
      min-height: 48px;
    }

    .form-control-modern:hover {
      border-color: var(--input-hover-border);
    }

    .form-control-modern:focus {
      border-color: var(--input-focus-border);
      box-shadow: 0 0 0 4px var(--sky-glow);
      background-color: var(--card-bg);
    }

    .input-icon-left {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 0.95rem;
      pointer-events: none;
      transition: color 0.2s;
    }

    .form-control-modern:focus ~ .input-icon-left {
      color: var(--sky-main);
    }

    /* Clear Input Button */
    .input-clear-btn {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 0.85rem;
      background: none;
      border: none;
      cursor: pointer;
      display: none;
      padding: 4px;
      border-radius: 50%;
      transition: all 0.15s;
    }

    .input-clear-btn:hover {
      color: var(--rose-accent);
      background: rgba(244, 63, 94, 0.1);
    }

    .input-wrapper.has-value .input-clear-btn {
      display: block;
    }

    /* reCAPTCHA Wrapper */
    .recaptcha-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 1.5rem;
      overflow: hidden;
      border-radius: 10px;
    }

    /* Submit & Back Buttons */
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
      box-shadow: 0 8px 20px -4px rgba(12, 43, 77, 0.35);
      min-height: 50px;
      width: 100%;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-bottom: 0.85rem;
    }

    .btn-auth-primary:hover {
      transform: translateY(-1.5px);
      box-shadow: 0 12px 28px -4px rgba(2, 132, 199, 0.45);
      color: #ffffff;
    }

    .btn-auth-primary:active {
      transform: scale(0.985);
    }

    .btn-arrow {
      transition: transform 0.2s ease;
    }

    .btn-auth-primary:hover .btn-arrow {
      transform: translateX(4px);
    }

    .btn-back-outline {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      width: 100%;
      padding: 0.75rem 1.5rem;
      background: transparent;
      border: 1.5px solid var(--input-border);
      border-radius: 12px;
      color: var(--text-body);
      font-weight: 700;
      font-size: 0.9rem;
      text-decoration: none;
      transition: all 0.2s ease;
      min-height: 46px;
    }

    .btn-back-outline:hover {
      background: var(--input-bg);
      border-color: var(--input-hover-border);
      color: var(--sky-main);
      text-decoration: none;
      transform: translateY(-1px);
    }

    .form-footer-copyright {
      text-align: center;
      margin-top: 2rem;
      padding-top: 1.25rem;
      border-top: 1px solid var(--input-border);
      color: var(--text-muted);
      font-size: 0.785rem;
    }

    /* SweetAlert2 Modern Corporate Styles */
    .swal2-container {
      font-family: var(--font-main) !important;
      backdrop-filter: blur(4px) !important;
      -webkit-backdrop-filter: blur(4px) !important;
    }
    .swal2-modern-card {
      border-radius: 24px !important;
      padding: 2.25rem 2rem 2rem !important;
      border: 1px solid var(--card-border) !important;
      box-shadow: 0 25px 60px -15px rgba(12, 43, 77, 0.28), 0 0 0 1px rgba(255, 255, 255, 0.8) inset !important;
      width: 440px !important;
      max-width: 92vw !important;
      background: var(--card-bg) !important;
      color: var(--text-body) !important;
    }
    .swal-icon-shield {
      width: 68px;
      height: 68px;
      border-radius: 20px;
      background: linear-gradient(135deg, rgba(2, 132, 199, 0.12) 0%, rgba(14, 165, 233, 0.05) 100%);
      border: 1.5px solid rgba(2, 132, 199, 0.25);
      box-shadow: 0 8px 20px -4px rgba(2, 132, 199, 0.2);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: #0284c7;
      margin-bottom: 1rem;
      animation: shieldPulse 2s infinite ease-in-out;
    }
    @keyframes shieldPulse {
      0%, 100% { transform: scale(1); box-shadow: 0 8px 20px -4px rgba(2, 132, 199, 0.2); }
      50% { transform: scale(1.05); box-shadow: 0 12px 28px -4px rgba(2, 132, 199, 0.35); }
    }
    .swal-badge-security {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.725rem;
      font-weight: 800;
      color: #0284c7;
      background: rgba(2, 132, 199, 0.08);
      border: 1px solid rgba(2, 132, 199, 0.2);
      padding: 0.3rem 0.8rem;
      border-radius: 999px;
      letter-spacing: 0.05em;
      margin-bottom: 0.85rem;
      text-transform: uppercase;
    }
    .swal-title-modern {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-title);
      letter-spacing: -0.025em;
      line-height: 1.3;
      margin-bottom: 0.5rem;
    }
    .swal-text-modern {
      font-size: 0.885rem;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 1.25rem;
    }
    .swal-hint-box {
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 14px;
      padding: 0.85rem 1rem;
      text-align: left;
      margin-bottom: 0.25rem;
    }
    .swal-hint-icon {
      font-size: 1.15rem;
      color: #0284c7;
      margin-top: 2px;
      flex-shrink: 0;
    }
    .swal-hint-text {
      font-size: 0.8rem;
      color: var(--text-body);
      line-height: 1.45;
    }
    .swal-hint-text strong {
      color: var(--text-title);
    }
    .swal2-modern-actions {
      margin-top: 1.35rem !important;
      width: 100% !important;
    }
    .btn-swal-confirm {
      width: 100% !important;
      background: linear-gradient(135deg, var(--navy-main) 0%, #114277 50%, var(--sky-main) 100%) !important;
      color: #ffffff !important;
      border: none !important;
      border-radius: 12px !important;
      padding: 0.85rem 1.5rem !important;
      font-weight: 700 !important;
      font-size: 0.95rem !important;
      cursor: pointer !important;
      transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
      box-shadow: 0 8px 20px -4px rgba(12, 43, 77, 0.35) !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.5rem !important;
      text-decoration: none !important;
    }
    .btn-swal-confirm:hover {
      transform: translateY(-1.5px) !important;
      box-shadow: 0 12px 28px -4px rgba(2, 132, 199, 0.45) !important;
      color: #ffffff !important;
    }
    .btn-swal-confirm:active {
      transform: scale(0.98) !important;
    }
    .recaptcha-shake {
      animation: recaptchaPulse 0.65s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
      border-radius: 10px;
      box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.4);
    }
    @keyframes recaptchaPulse {
      0%, 100% { transform: scale(1); }
      20% { transform: scale(1.04) translateY(-2px); }
      40% { transform: scale(0.98); }
      60% { transform: scale(1.02); }
      80% { transform: scale(0.99); }
    }

    @media (max-width: 880px) {
      .brand-panel { display: none; }
      .form-container { padding: 2.75rem 2rem; }
      .auth-card { border-radius: 20px; }
      .top-utility-bar { padding: 0 0.5rem; }
    }
  </style>
</head>

<body>

  <!-- Top Floating Utility Bar -->
  <header class="top-utility-bar" aria-label="Navigasi Akses Cepat">
    <a href="<?php echo base_url('login'); ?>" class="btn-utility-link">
      <i class="fas fa-arrow-left"></i>
      <span>Kembali ke Halaman Login</span>
    </a>

    <div class="top-actions-right">
      <div class="status-pill-secure" title="Koneksi Sistem Terenkripsi">
        <span class="pulse-dot"></span>
        <span>SSL 256-Bit</span>
      </div>

      <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Beralih Tema Gelap/Terang" aria-label="Beralih Tema">
        <i class="fas fa-moon" id="themeIcon"></i>
      </button>
    </div>
  </header>

  <!-- Main Auth Card -->
  <main class="auth-wrapper">
    <div class="auth-card">
      
      <!-- Sisi Kiri: Panel Informasi Pemulihan Akun -->
      <section class="brand-panel" aria-label="Informasi Pemulihan Akun">
        <div class="brand-content">
          <div class="brand-logo-pod">
            <img src="<?php echo base_url(); ?>assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" class="brand-logo">
          </div>
          
          <span class="brand-badge">
            <i class="fas fa-key"></i> PEMULIHAN AKUN RESMI
          </span>
          
          <h1 class="brand-title">Atur Ulang Kata Sandi</h1>
          <p class="brand-description">
            Verifikasi data identitas resmi kepegawaian Anda untuk memulihkan akses akun dengan aman.
          </p>

          <!-- 3-Step Breadcrumb Stepper -->
          <div class="recovery-steps-list">
            <div class="recovery-step-item is-active">
              <span class="step-number-badge">1</span>
              <div class="step-text-group">
                <h4>Input Identitas Kepegawaian</h4>
                <p>Masukkan Username SSO dan NIK pegawai terdaftar</p>
              </div>
            </div>

            <div class="recovery-step-item">
              <span class="step-number-badge">2</span>
              <div class="step-text-group">
                <h4>Validasi Database Klinik</h4>
                <p>Pencocokan data otomatis dengan basis data kepegawaian</p>
              </div>
            </div>

            <div class="recovery-step-item">
              <span class="step-number-badge">3</span>
              <div class="step-text-group">
                <h4>Atur Kata Sandi Baru</h4>
                <p>Buat kata sandi baru yang aman dan terenkripsi</p>
              </div>
            </div>
          </div>
        </div>

        <div class="brand-footer-pill">
          <i class="fas fa-shield-halved text-info"></i>
          <span>Validasi Identitas Ganda Terenkripsi</span>
        </div>
      </section>

      <!-- Sisi Kanan: Formulir Verifikasi Identitas -->
      <section class="form-container" aria-label="Formulir Verifikasi Identitas">
        <div>
          <span class="form-header-badge">
            <i class="fas fa-user-shield"></i> TAHAP 1 &bull; VERIFIKASI KEAMANAN
          </span>
          <h2 class="auth-title">Verifikasi Identitas Pegawai</h2>
          <p class="auth-subtitle">Masukkan Username SSO dan NIK yang terdaftar pada sistem klinik.</p>
        </div>
        
        <?php echo $this->session->flashdata('pesan'); ?>

        <form method="POST" action="<?php echo base_url('lupa_password'); ?>" novalidate id="formRecovery">
          
          <!-- Username Input -->
          <div class="form-group mb-3">
            <label class="form-label" for="username">
              <span>Username SSO</span>
            </label>
            <div class="input-wrapper" id="usernameWrapper">
              <input type="text" class="form-control-modern" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Masukkan Username SSO..." required autofocus autocomplete="username">
              <i class="fas fa-user input-icon-left" aria-hidden="true"></i>
              <button type="button" class="input-clear-btn" id="clearUsernameBtn" title="Hapus teks" aria-label="Hapus teks username">
                <i class="fas fa-circle-xmark"></i>
              </button>
            </div>
            <?php echo form_error('username', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>

          <!-- NIK Input -->
          <div class="form-group mb-4">
            <label class="form-label" for="nik">
              <span>Nomor Induk Kependudukan (NIK)</span>
              <span class="label-counter" id="nikCounter">0 / 16 Digit</span>
            </label>
            <div class="input-wrapper" id="nikWrapper">
              <input type="text" class="form-control-modern" id="nik" name="nik" value="<?php echo set_value('nik'); ?>" placeholder="Masukkan 16 digit NIK pegawai..." required autocomplete="off" inputmode="numeric" maxlength="16">
              <i class="fas fa-id-card input-icon-left" aria-hidden="true"></i>
              <button type="button" class="input-clear-btn" id="clearNikBtn" title="Hapus teks" aria-label="Hapus teks NIK">
                <i class="fas fa-circle-xmark"></i>
              </button>
            </div>
            <?php echo form_error('nik', '<div class="text-small text-danger mt-1 font-weight-bold">', '</div>'); ?>
          </div>
          
          <!-- reCAPTCHA Widget -->
          <div class="recaptcha-wrapper">
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
          </div>
          
          <!-- Submit Button -->
          <button type="submit" class="btn-auth-primary" id="btnSubmitRecovery">
            <span>Verifikasi Identitas Pegawai</span>
            <i class="fas fa-arrow-right btn-arrow"></i>
          </button>

          <!-- Back Button -->
          <a href="<?php echo base_url('login'); ?>" class="btn-back-outline">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Halaman Login</span>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

  <script>
    // =========================================================
    // 1. SEAMLESS DARK MODE ENGINE
    // =========================================================
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');

    function syncThemeUI(isDark) {
      if (isDark) {
        document.documentElement.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        if (themeIcon) themeIcon.className = 'fas fa-sun text-warning';
      } else {
        document.documentElement.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        if (themeIcon) themeIcon.className = 'fas fa-moon';
      }
    }

    if (localStorage.getItem('darkMode') === 'enabled') {
      syncThemeUI(true);
    }

    if (themeToggleBtn) {
      themeToggleBtn.addEventListener('click', () => {
        const isDark = document.documentElement.classList.contains('dark-mode');
        syncThemeUI(!isDark);
      });
    }

    // =========================================================
    // 2. INPUT CLEAR BUTTONS & NIK COUNTER
    // =========================================================
    const usernameInput = document.getElementById('username');
    const usernameWrapper = document.getElementById('usernameWrapper');
    const clearUsernameBtn = document.getElementById('clearUsernameBtn');

    const nikInput = document.getElementById('nik');
    const nikWrapper = document.getElementById('nikWrapper');
    const clearNikBtn = document.getElementById('clearNikBtn');
    const nikCounter = document.getElementById('nikCounter');

    function toggleClearBtn(input, wrapper) {
      if (input && wrapper) {
        if (input.value.trim().length > 0) {
          wrapper.classList.add('has-value');
        } else {
          wrapper.classList.remove('has-value');
        }
      }
    }

    function updateNikCounter() {
      if (!nikInput || !nikCounter) return;
      // Allow only numbers
      nikInput.value = nikInput.value.replace(/[^0-9]/g, '');
      const len = nikInput.value.length;
      nikCounter.textContent = `${len} / 16 Digit`;
      if (len === 16) {
        nikCounter.style.color = 'var(--emerald-accent)';
      } else {
        nikCounter.style.color = 'var(--text-muted)';
      }
      toggleClearBtn(nikInput, nikWrapper);
    }

    if (usernameInput) {
      usernameInput.addEventListener('input', () => toggleClearBtn(usernameInput, usernameWrapper));
      toggleClearBtn(usernameInput, usernameWrapper);
    }
    if (clearUsernameBtn && usernameInput) {
      clearUsernameBtn.addEventListener('click', () => {
        usernameInput.value = '';
        toggleClearBtn(usernameInput, usernameWrapper);
        usernameInput.focus();
      });
    }

    if (nikInput) {
      nikInput.addEventListener('input', updateNikCounter);
      updateNikCounter();
    }
    if (clearNikBtn && nikInput) {
      clearNikBtn.addEventListener('click', () => {
        nikInput.value = '';
        updateNikCounter();
        nikInput.focus();
      });
    }

    // =========================================================
    // 3. FORM SUBMISSION VALIDATION & SWEETALERT2
    // =========================================================
    const formRecovery = document.getElementById('formRecovery');
    if (formRecovery) {
      formRecovery.addEventListener('submit', function(e) {
        const u = document.getElementById('username');
        const nik = document.getElementById('nik');

        if (!u || !u.value.trim()) {
          e.preventDefault();
          if (u) u.focus();
          Swal.fire({
            html: `
              <div class="text-center pt-2">
                <div class="swal-icon-shield" style="color: #0284c7; background: rgba(2, 132, 199, 0.08); border-color: rgba(2, 132, 199, 0.2);">
                  <i class="fas fa-user-pen"></i>
                </div>
                <div>
                  <span class="swal-badge-security">
                    <i class="fas fa-user-shield"></i> KREDENSIAL PENGGUNA
                  </span>
                </div>
                <h3 class="swal-title-modern">Username SSO Diperlukan</h3>
                <p class="swal-text-modern">
                  Silakan masukkan Username SSO Anda terlebih dahulu untuk verifikasi data pemulihan.
                </p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi Username</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: {
              popup: 'swal2-modern-card',
              actions: 'swal2-modern-actions',
              confirmButton: 'btn-swal-confirm'
            }
          });
          return false;
        }

        if (!nik || !nik.value.trim()) {
          e.preventDefault();
          if (nik) nik.focus();
          Swal.fire({
            html: `
              <div class="text-center pt-2">
                <div class="swal-icon-shield" style="color: #0284c7; background: rgba(2, 132, 199, 0.08); border-color: rgba(2, 132, 199, 0.2);">
                  <i class="fas fa-id-card"></i>
                </div>
                <div>
                  <span class="swal-badge-security">
                    <i class="fas fa-id-badge"></i> IDENTITAS PEGAWAI
                  </span>
                </div>
                <h3 class="swal-title-modern">NIK Pegawai Diperlukan</h3>
                <p class="swal-text-modern">
                  Silakan masukkan Nomor Induk Kependudukan (NIK) terdaftar untuk verifikasi akun.
                </p>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Lengkapi NIK</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: {
              popup: 'swal2-modern-card',
              actions: 'swal2-modern-actions',
              confirmButton: 'btn-swal-confirm'
            }
          });
          return false;
        }

        const captchaResponse = (typeof grecaptcha !== 'undefined') ? grecaptcha.getResponse() : '';
        if (!captchaResponse) {
          e.preventDefault();
          Swal.fire({
            html: `
              <div class="text-center pt-2">
                <div class="swal-icon-shield">
                  <i class="fas fa-shield-halved"></i>
                </div>
                <div>
                  <span class="swal-badge-security">
                    <i class="fas fa-robot"></i> PROTEKSI SISTEM ANTI-BOT
                  </span>
                </div>
                <h3 class="swal-title-modern">Verifikasi reCAPTCHA Wajib</h3>
                <p class="swal-text-modern">
                  Untuk keamanan verifikasi identitas, mohon centang kotak verifikasi <strong>"I'm not a robot"</strong> terlebih dahulu sebelum melanjutkan.
                </p>
                <div class="swal-hint-box">
                  <i class="fas fa-arrow-pointer swal-hint-icon"></i>
                  <div class="swal-hint-text">
                    <strong>Panduan Cepat:</strong> Centang kotak verifikasi reCAPTCHA yang berada tepat di atas tombol <em>Verifikasi Identitas Pegawai</em>.
                  </div>
                </div>
              </div>
            `,
            showConfirmButton: true,
            confirmButtonText: '<span>Saya Mengerti &amp; Centang Sekarang</span><i class="fas fa-arrow-right"></i>',
            buttonsStyling: false,
            customClass: {
              popup: 'swal2-modern-card',
              actions: 'swal2-modern-actions',
              confirmButton: 'btn-swal-confirm'
            },
            showClass: {
              popup: 'swal2-show'
            },
            hideClass: {
              popup: 'swal2-hide'
            },
            didClose: () => {
              const recap = document.querySelector('.recaptcha-wrapper');
              if (recap) {
                recap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                recap.classList.remove('recaptcha-shake');
                void recap.offsetWidth;
                recap.classList.add('recaptcha-shake');
                setTimeout(() => {
                  recap.classList.remove('recaptcha-shake');
                }, 1400);
              }
            }
          });
          return false;
        }

        Swal.fire({
          html: `
            <div class="py-2 text-center">
              <div class="mb-3 d-inline-flex align-items-center justify-content-center" style="width: 58px; height: 58px; border-radius: 50%; background: rgba(14, 165, 233, 0.1);">
                <i class="fas fa-user-shield" style="font-size: 1.75rem; color: #0284c7;"></i>
              </div>
              <h4 class="font-weight-bold text-gray-900 mb-1" style="font-size: 1.25rem; letter-spacing: -0.01em;">
                Memvalidasi Data...
              </h4>
              <p class="text-muted small mb-3">
                Memeriksa kecocokan data SSO & NIK ke pangkalan data klinik...
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
            popup: 'swal2-modern-card'
          },
          width: 380,
          background: '#ffffff'
        });
      });
    }
  </script>
</body>
</html>
