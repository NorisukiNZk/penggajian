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
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="description" content="Portal Mandiri Pegawai Klinik Pratama Dr. H.M. Hidayatullah">
  <meta name="author" content="Klinik Pratama Dr. H.M. Hidayatullah">

  <title><?php echo isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Portal Pegawai'; ?> | Portal Pegawai Klinik Hidayatullah</title>

  <link rel="shortcut icon" href="<?php echo base_url('assets/img/kpmh.png'); ?>" type="image/png">

  <!-- Typography: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- FontAwesome 6 Free -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Bootstrap 4.6 Core Grid & Components (No SB Admin 2) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- DataTables 2.x -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

  <!-- Dedicated Portal Pegawai Stylesheet -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/portal-pegawai.css'); ?>?v=20261123">
</head>
