<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard | Penggajian</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <style>
    /* Modernize DataTables & Standard Tables (Apple/Google Style) */
    .table-bordered { border: none !important; }
    .table-bordered td, .table-bordered th {
        border-left: none !important;
        border-right: none !important;
        border-top: 1px solid #edf2f7 !important;
        border-bottom: 1px solid #edf2f7 !important;
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .table thead th {
        background-color: #f8f9fc !important;
        color: #4a5568 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        border-bottom: 2px solid #e2e8f0 !important;
    }
    .table tbody tr { transition: all 0.2s ease; }
    .table tbody tr:hover { background-color: #f1f5f9 !important; }
    
    /* Pagination Styling */
    .page-item.active .page-link {
        background-color: #0c2b4d !important;
        border-color: #0c2b4d !important;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(12, 43, 77, 0.3);
    }
    .page-link {
        border: none !important;
        color: #4a5568;
        margin: 0 4px;
        border-radius: 6px;
        font-weight: 600;
    }
    .page-link:hover { background-color: #e2e8f0; }
    
    /* Search Box Customization */
    div.dataTables_wrapper div.dataTables_filter input {
        border-radius: 20px !important;
        padding: 0.4rem 1rem !important;
        border: 1px solid #d1d3e2 !important;
        outline: none;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus {
        border-color: #0c2b4d !important;
        box-shadow: 0 0 0 0.2rem rgba(12, 43, 77, 0.25) !important;
    }
    
    /* Dashboard Cards & Button Animations (Micro-interactions) */
    .border-left-primary, .border-left-success, .border-left-info, .border-left-warning, .border-left-danger {
        transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        border-radius: 10px;
    }
    .border-left-primary:hover, .border-left-success:hover, .border-left-info:hover, .border-left-warning:hover, .border-left-danger:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(12, 43, 77, 0.15) !important;
    }
    .btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(12, 43, 77, 0.2);
    }

    /* Custom Modern Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f8f9fc; 
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #3a5cb8; 
    }
    
    /* Preloader CSS */
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ffffff;
        z-index: 99999;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    .spinner-container {
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(78, 115, 223, 0.2);
        border-top-color: #4e73df;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .preloader-text {
        font-weight: 800;
        color: #4e73df;
        letter-spacing: 3px;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { opacity: 0.5; }
        50% { opacity: 1; }
        100% { opacity: 0.5; }
    }

    /* Page Fade-In Animation */
    body {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    /* Dark Mode Global Styles */
    body, #content-wrapper, #wrapper, .card, .collapse-inner, .table, .table td, .table th, .form-control, .dropdown-menu, .modal-content, .page-link {
        transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease !important;
    }
    
    body.dark-mode #preloader {
        background-color: #121212 !important;
    }

    body.dark-mode, body.dark-mode #content-wrapper, body.dark-mode #wrapper {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }
    body.dark-mode .card, body.dark-mode .collapse-inner {
        background-color: #1e1e1e !important;
        border-color: #2c2c2c !important;
    }
    body.dark-mode .card-header {
        background-color: #252525 !important;
        border-bottom: 1px solid #333 !important;
    }
    body.dark-mode .text-gray-800, body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
        color: #f1f1f1 !important;
    }
    body.dark-mode .text-gray-600, body.dark-mode .text-gray-500, body.dark-mode .text-muted {
        color: #b0b0b0 !important;
    }
    body.dark-mode .table td, body.dark-mode .table th {
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    body.dark-mode .table thead th {
        background-color: #252525 !important;
        color: #e0e0e0 !important;
        border-bottom: 2px solid #333 !important;
    }
    body.dark-mode .table tbody tr:hover {
        background-color: #2a2a2a !important;
    }
    body.dark-mode .bg-white {
        background-color: #1e1e1e !important;
    }
    body.dark-mode .form-control {
        background-color: #2c2c2c !important;
        border-color: #444 !important;
        color: #f1f1f1 !important;
    }
    body.dark-mode .dropdown-menu {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
    }
    body.dark-mode .dropdown-item {
        color: #e0e0e0 !important;
    }
    body.dark-mode .dropdown-item:hover {
        background-color: #333 !important;
        color: #fff !important;
    }
    body.dark-mode .modal-content {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
    }
    body.dark-mode .modal-header, body.dark-mode .modal-footer {
        border-color: #333 !important;
    }
    body.dark-mode .page-link {
        background-color: #2c2c2c !important;
        color: #f1f1f1 !important;
    }
    body.dark-mode .page-link:hover {
        background-color: #444 !important;
    }
    body.dark-mode div.dataTables_wrapper div.dataTables_filter input {
        background-color: #2c2c2c !important;
        color: #f1f1f1 !important;
        border-color: #444 !important;
    }
  </style>

</head>