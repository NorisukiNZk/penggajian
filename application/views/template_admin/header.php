<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistem Informasi HRIS dan Penggajian Klinik Hidayatullah">
  <meta name="author" content="Klinik Hidayatullah">

  <title><?php echo isset($title) ? $title : 'Dashboard'; ?> | HRIS Klinik Hidayatullah</title>

  <!-- Google Fonts: Plus Jakarta Sans (Modern Clean UI) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Modern DataTables 2.x CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

  <!-- Base Grid & Theme Layout Stylesheet -->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    :root {
      --font-main: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --primary-color: #0c2b4d;
      --primary-hover: #123d6c;
      --accent-color: #0ea5e9;
      --bg-body: #f8fafc;
      --text-main: #1e293b;
      --text-muted: #64748b;
    }

    body {
      font-family: var(--font-main) !important;
      background-color: var(--bg-body);
      color: var(--text-main);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Modern Card Overhaul */
    .card {
      border: 1px solid #eef2f6 !important;
      border-radius: 16px !important;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.02) !important;
      background: #ffffff;
      transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }
    .card-header {
      background-color: transparent !important;
      border-bottom: 1px solid #f1f5f9 !important;
      padding: 1.25rem 1.5rem !important;
      font-weight: 700;
    }
    .card-body {
      padding: 1.5rem !important;
    }

    /* KPI Cards Hover Effects */
    .border-left-primary, .border-left-success, .border-left-info, .border-left-warning, .border-left-danger {
      border-left-width: 4px !important;
      border-radius: 16px !important;
    }
    .border-left-primary:hover, .border-left-success:hover, .border-left-info:hover, .border-left-warning:hover, .border-left-danger:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 22px -3px rgba(12, 43, 77, 0.1) !important;
    }

    /* Modern Buttons */
    .btn {
      font-family: var(--font-main);
      font-weight: 600;
      border-radius: 10px !important;
      padding: 0.5rem 1.15rem;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      justify-content: center;
    }
    .btn-sm {
      padding: 0.35rem 0.85rem;
      border-radius: 8px !important;
      font-size: 0.8125rem;
    }
    .btn:hover {
      transform: translateY(-1.5px);
      box-shadow: 0 6px 16px -2px rgba(12, 43, 77, 0.18);
    }
    .btn-primary {
      background-color: var(--primary-color) !important;
      border-color: var(--primary-color) !important;
    }
    .btn-primary:hover {
      background-color: var(--primary-hover) !important;
      border-color: var(--primary-hover) !important;
    }

    /* Modern Badges */
    .badge {
      font-family: var(--font-main);
      font-weight: 600;
      padding: 0.35rem 0.75rem;
      border-radius: 9999px !important;
      letter-spacing: 0.025em;
    }

    /* Modern Minimalist Tables */
    .table-bordered { border: none !important; }
    .table-bordered td, .table-bordered th {
      border-left: none !important;
      border-right: none !important;
      border-top: 1px solid #f1f5f9 !important;
      border-bottom: 1px solid #f1f5f9 !important;
      vertical-align: middle !important;
      padding: 0.95rem 1rem !important;
      font-size: 0.9rem;
    }
    .table thead th {
      background-color: #f8fafc !important;
      color: #475569 !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      font-size: 0.75rem !important;
      letter-spacing: 0.06em !important;
      border-bottom: 2px solid #e2e8f0 !important;
      border-top: none !important;
    }
    .table tbody tr:hover {
      background-color: #f8fafc !important;
    }

    /* Modern Forms */
    .form-control {
      border-radius: 10px !important;
      border: 1.5px solid #cbd5e1 !important;
      padding: 0.55rem 1rem !important;
      font-size: 0.925rem !important;
      transition: all 0.2s ease !important;
    }
    .form-control:focus {
      border-color: var(--accent-color) !important;
      box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15) !important;
      background-color: #ffffff !important;
    }

    /* Modern DataTables 2.x Styling */
    .dt-container {
      font-family: var(--font-main) !important;
      padding-top: 0.5rem;
    }
    .dt-search input {
      border-radius: 9999px !important;
      padding: 0.45rem 1.25rem !important;
      border: 1.5px solid #cbd5e1 !important;
      background-color: #f8fafc !important;
      font-size: 0.875rem !important;
      outline: none;
      transition: all 0.2s ease;
      min-width: 240px;
    }
    .dt-search input:focus {
      background-color: #ffffff !important;
      border-color: var(--accent-color) !important;
      box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15) !important;
    }
    .dt-paging .dt-paging-button {
      border-radius: 8px !important;
      border: 1px solid transparent !important;
      font-weight: 600 !important;
      padding: 0.35rem 0.85rem !important;
      margin: 0 2px !important;
    }
    .dt-paging .dt-paging-button.current {
      background: var(--primary-color) !important;
      color: #ffffff !important;
      border-color: var(--primary-color) !important;
    }

    /* =========================================================
       UTILITY & SPACING HELPERS
       ========================================================= */
    .gap-1 { gap: 0.25rem !important; }
    .gap-2 { gap: 0.5rem !important; }
    .gap-3 { gap: 1rem !important; }
    .gap-4 { gap: 1.5rem !important; }

    /* =========================================================
       PREMIUM MODERN SIDEBAR & ACCORDION SUBMENU
       ========================================================= */
    .bg-modern-blue {
      background: #091a2e !important;
      background-image: linear-gradient(180deg, #071526 0%, #0c233c 50%, #091a2e 100%) !important;
      border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    @media (min-width: 768px) {
      .sidebar {
        width: 260px !important;
        min-width: 260px !important;
      }
      #content-wrapper {
        margin-left: 0;
      }
    }

    /* Brand Header */
    .sidebar .sidebar-brand {
      height: 4.75rem !important;
      padding: 1.25rem 1.25rem !important;
      display: flex !important;
      align-items: center !important;
      justify-content: flex-start !important;
      text-decoration: none !important;
      background: rgba(0, 0, 0, 0.18) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    }
    .sidebar .sidebar-brand .sidebar-brand-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, rgba(14, 165, 233, 0.2) 0%, rgba(56, 189, 248, 0.1) 100%);
      border: 1px solid rgba(56, 189, 248, 0.35);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.85rem;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    }
    .sidebar .sidebar-brand .sidebar-brand-text {
      font-size: 0.975rem !important;
      letter-spacing: 0.04em !important;
      line-height: 1.25 !important;
    }

    /* Nav Items & Links */
    .sidebar-heading {
      text-transform: uppercase !important;
      letter-spacing: 0.1em !important;
      font-size: 0.68rem !important;
      font-weight: 700 !important;
      color: rgba(255, 255, 255, 0.35) !important;
      padding: 1.25rem 1.25rem 0.35rem 1.25rem !important;
    }
    .sidebar-dark .nav-item .nav-link {
      display: flex !important;
      align-items: center !important;
      padding: 0.7rem 1rem !important;
      margin: 0.15rem 0.75rem !important;
      border-radius: 10px !important;
      color: #94a3b8 !important;
      font-weight: 500 !important;
      font-size: 0.865rem !important;
      letter-spacing: 0.01em;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .sidebar-dark .nav-item .nav-link i {
      font-size: 0.95rem !important;
      width: 1.65rem !important;
      margin-right: 0.65rem !important;
      text-align: center !important;
      color: #64748b !important;
      transition: all 0.2s ease !important;
    }
    .sidebar-dark .nav-item .nav-link span {
      flex: 1;
      font-size: 0.865rem !important;
    }
    .sidebar-dark .nav-item .nav-link:hover {
      color: #ffffff !important;
      background-color: rgba(255, 255, 255, 0.07) !important;
      transform: translateX(3px);
    }
    .sidebar-dark .nav-item .nav-link:hover i {
      color: #38bdf8 !important;
      transform: scale(1.15);
    }
    .sidebar-dark .nav-item.active .nav-link,
    .sidebar-dark .nav-item .nav-link[aria-expanded="true"] {
      color: #ffffff !important;
      background: linear-gradient(90deg, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0.05) 100%) !important;
      border-left: 3px solid #38bdf8 !important;
    }
    .sidebar-dark .nav-item.active .nav-link i,
    .sidebar-dark .nav-item .nav-link[aria-expanded="true"] i {
      color: #38bdf8 !important;
    }

    /* Submenu Accordion Dropdown - Seamlessly Integrated Inline */
    .sidebar .collapse, 
    .sidebar .collapsing {
      position: static !important;
      padding: 0 0.75rem !important;
      width: 100% !important;
    }
    .sidebar .collapse .collapse-inner {
      background: rgba(0, 0, 0, 0.25) !important;
      border: 1px solid rgba(255, 255, 255, 0.06) !important;
      border-radius: 12px !important;
      box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3) !important;
      padding: 0.45rem 0.35rem !important;
      margin: 0.25rem 0 0.6rem 0 !important;
    }
    .sidebar .collapse-header {
      font-size: 0.68rem !important;
      text-transform: uppercase !important;
      letter-spacing: 0.08em !important;
      color: #64748b !important;
      font-weight: 700 !important;
      padding: 0.45rem 0.75rem 0.2rem 0.75rem !important;
      margin-bottom: 0 !important;
    }
    .sidebar .collapse-item {
      font-family: var(--font-main) !important;
      padding: 0.48rem 0.75rem 0.48rem 1.85rem !important;
      color: #94a3b8 !important;
      font-weight: 500 !important;
      font-size: 0.825rem !important;
      display: flex !important;
      align-items: center !important;
      position: relative !important;
      transition: all 0.18s ease !important;
      border-radius: 8px !important;
      margin: 0.12rem 0 !important;
      text-decoration: none !important;
    }
    .sidebar .collapse-item::before {
      content: '';
      position: absolute;
      left: 0.8rem;
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background-color: #475569;
      transition: all 0.2s ease;
    }
    .sidebar .collapse-item:hover, 
    .sidebar .collapse-item.active {
      background-color: rgba(255, 255, 255, 0.08) !important;
      color: #38bdf8 !important;
      font-weight: 600 !important;
      transform: translateX(3px) !important;
    }
    .sidebar .collapse-item:hover::before,
    .sidebar .collapse-item.active::before {
      background-color: #38bdf8 !important;
      box-shadow: 0 0 6px #38bdf8;
      transform: scale(1.3);
    }

    /* FontAwesome 6 Chevron Arrow for Collapse Links */
    .sidebar .nav-item .nav-link[data-toggle="collapse"]::after {
      display: inline-block !important;
      font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
      font-weight: 900 !important;
      content: "\f107" !important;
      margin-left: auto !important;
      float: none !important;
      transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
      color: rgba(255, 255, 255, 0.45) !important;
      transform: rotate(0deg) !important;
      font-size: 0.8rem !important;
    }
    .sidebar .nav-item .nav-link[data-toggle="collapse"].collapsed::after {
      transform: rotate(-90deg) !important;
      color: rgba(255, 255, 255, 0.25) !important;
    }

    /* Toggled (Minimized) State Behavior */
    @media (min-width: 768px) {
      .sidebar.toggled {
        width: 5.5rem !important;
        min-width: 5.5rem !important;
      }
      .sidebar.toggled .sidebar-brand {
        justify-content: center !important;
        padding: 1.25rem 0 !important;
      }
      .sidebar.toggled .sidebar-brand .sidebar-brand-icon {
        margin-right: 0 !important;
      }
      .sidebar.toggled .sidebar-brand .sidebar-brand-text {
        display: none !important;
      }
      .sidebar.toggled .nav-item .nav-link {
        text-align: center !important;
        justify-content: center !important;
        padding: 0.75rem 0.5rem !important;
        margin: 0.2rem auto !important;
      }
      .sidebar.toggled .nav-item .nav-link i {
        margin-right: 0 !important;
        font-size: 1.15rem !important;
      }
      .sidebar.toggled .nav-item .nav-link span {
        display: none !important;
      }
      .sidebar.toggled .nav-item .nav-link[data-toggle="collapse"]::after {
        display: none !important;
      }
      .sidebar.toggled .nav-item .collapse {
        position: absolute !important;
        left: calc(5.5rem + 0.5rem) !important;
        width: 14rem !important;
        z-index: 1050 !important;
        padding: 0 !important;
      }
      .sidebar.toggled .nav-item .collapse .collapse-inner {
        background: #091a2e !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5) !important;
      }
    }

    /* Topbar Enhancements */
    .topbar {
      height: 4.75rem !important;
      background: #091a2e !important;
      background-image: linear-gradient(90deg, #071526 0%, #0c233c 60%, #091a2e 100%) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
      padding: 0 1.5rem !important;
    }

    /* Scrollbars */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Preloader */
    #preloader {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background-color: #ffffff;
      z-index: 99999;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .spinner-container { text-align: center; }
    .spinner {
      width: 44px; height: 44px;
      border: 3px solid rgba(14, 165, 233, 0.15);
      border-top-color: var(--accent-color);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      margin: 0 auto 12px auto;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .preloader-text {
      font-weight: 700;
      color: var(--primary-color);
      font-size: 0.85rem;
      letter-spacing: 2px;
    }

    /* Dark Mode */
    body.dark-mode {
      background-color: #0b1120 !important;
      color: #f1f5f9 !important;
    }
    body.dark-mode #content-wrapper, body.dark-mode #wrapper {
      background-color: #0b1120 !important;
    }
    body.dark-mode .card {
      background-color: #1e293b !important;
      border-color: #334155 !important;
      box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3) !important;
    }
    body.dark-mode .card-header {
      border-bottom-color: #334155 !important;
    }
    body.dark-mode .text-gray-800, body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
      color: #f8fafc !important;
    }
    body.dark-mode .text-gray-600, body.dark-mode .text-gray-500, body.dark-mode .text-muted {
      color: #94a3b8 !important;
    }
    body.dark-mode .table thead th {
      background-color: #1e293b !important;
      color: #cbd5e1 !important;
      border-bottom-color: #334155 !important;
    }
    body.dark-mode .table td {
      border-color: #334155 !important;
      color: #e2e8f0 !important;
    }
    body.dark-mode .table tbody tr:hover {
      background-color: #1e293b !important;
    }
    body.dark-mode .form-control {
      background-color: #1e293b !important;
      border-color: #475569 !important;
      color: #f8fafc !important;
    }
    body.dark-mode .sidebar .collapse .collapse-inner {
      background-color: #1e293b !important;
      border: 1px solid #334155 !important;
    }
    body.dark-mode .sidebar .collapse-item {
      color: #cbd5e1 !important;
    }
    body.dark-mode .sidebar .collapse-item:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }
    body.dark-mode .dropdown-menu {
      background-color: #1e293b !important;
      border-color: #334155 !important;
    }
    body.dark-mode .dropdown-item {
      color: #e2e8f0 !important;
    }
    body.dark-mode .dropdown-item:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }
    body.dark-mode .modal-content {
      background-color: #1e293b !important;
      color: #f8fafc !important;
      border-color: #334155 !important;
    }
  </style>

</head>