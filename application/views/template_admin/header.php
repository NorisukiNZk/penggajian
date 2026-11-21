<!DOCTYPE html>
<html lang="id">

<head>
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistem Informasi HRIS dan Penggajian Klinik Pratama Dr. H.M. Hidayatullah">
  <meta name="author" content="Klinik Pratama Dr. H.M. Hidayatullah">

  <title><?php echo isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Dashboard'; ?> | HRIS Klinik Hidayatullah</title>

  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/kpmh.png'); ?>">
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/kpmh.png'); ?>">

  <!-- Typography: Source Serif 4 + Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- DataTables 2.x CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

  <!-- Base Grid & Admin Portal Stylesheet -->
  <link href="<?php echo base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/admin-portal.css'); ?>?v=20261121" rel="stylesheet">
</head>
