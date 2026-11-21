<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$root_url = function_exists('base_url') ? base_url() : '/penggajian/';
$logo_url = $root_url . 'assets/img/kpmh.png';
$is_prod  = (defined('ENVIRONMENT') && ENVIRONMENT === 'production');
?><!DOCTYPE html>
<html lang="id">
<head>
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gangguan Koneksi Data | HRIS Klinik Pratama Dr. H.M. Hidayatullah</title>
  <link rel="icon" type="image/png" href="<?php echo htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8'); ?>">
  <style>
    :root {
      --err-bg: #F6F4EF;
      --err-surface: #FFFDF9;
      --err-border: #C9BFAE;
      --err-ink: #141D26;
      --err-muted: #525E6B;
      --err-navy: #18293D;
      --err-danger: #991B1B;
      --err-danger-bg: #FDE8E8;
    }
    html.dark-mode {
      --err-bg: #0F141B;
      --err-surface: #171F2A;
      --err-border: #3C4D63;
      --err-ink: #F1EFEA;
      --err-muted: #A4B0BD;
      --err-navy: #26415E;
      --err-danger: #FCA5A5;
      --err-danger-bg: rgba(239, 68, 68, 0.16);
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      min-height: 100dvh;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--err-bg);
      color: var(--err-ink);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .err-card {
      width: 100%;
      max-width: 620px;
      background: var(--err-surface);
      border: 1px solid var(--err-border);
      border-radius: 12px;
      padding: 2rem;
    }
    .err-brand {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--err-border);
    }
    .err-brand img {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      object-fit: contain;
      background: #FFFDF9;
      padding: 3px;
      border: 1px solid var(--err-border);
    }
    .err-brand-title { font-size: 0.9rem; font-weight: 700; }
    .err-brand-sub { font-size: 0.78rem; color: var(--err-muted); }
    .err-code {
      display: inline-block;
      padding: 0.25rem 0.65rem;
      border-radius: 4px;
      background: var(--err-danger-bg);
      color: var(--err-danger);
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      margin-bottom: 0.75rem;
    }
    h1 {
      font-family: 'Source Serif 4', Georgia, serif;
      font-size: 1.65rem;
      line-height: 1.25;
      margin: 0 0 0.75rem;
    }
    .err-msg {
      color: var(--err-muted);
      font-size: 0.92rem;
      line-height: 1.6;
      overflow-x: auto;
    }
    .err-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 0.65rem;
      margin-top: 1.5rem;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 44px;
      padding: 0.55rem 1.15rem;
      border-radius: 6px;
      font-size: 0.88rem;
      font-weight: 700;
      text-decoration: none;
    }
    .btn-primary {
      background-color: var(--err-navy);
      color: #FFFFFF;
      border: 1px solid var(--err-navy);
    }
    .btn-outline {
      background-color: transparent;
      color: var(--err-ink);
      border: 1px solid var(--err-border);
    }
  </style>
</head>
<body>
  <main class="err-card" role="main">
    <div class="err-brand">
      <img src="<?php echo htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8'); ?>" alt="Logo Klinik Hidayatullah">
      <div>
        <div class="err-brand-title">HRIS Klinik Pratama Dr. H.M. Hidayatullah</div>
        <div class="err-brand-sub">Layanan Sistem Kepegawaian</div>
      </div>
    </div>
    <span class="err-code">GANGGUAN BASIS DATA</span>
    <h1><?php echo $is_prod ? 'Layanan Data Sedang Tidak Tersedia' : htmlspecialchars(strip_tags((string)$heading), ENT_QUOTES, 'UTF-8'); ?></h1>
    <div class="err-msg">
      <?php if ($is_prod) : ?>
        <p>Sistem sedang mengalami kendala saat memproses permintaan ke basis data klinik. Silakan coba muat ulang beberapa saat lagi atau hubungi administrator TI klinik.</p>
      <?php else : ?>
        <?php echo $message; ?>
      <?php endif; ?>
    </div>
    <div class="err-actions">
      <a href="<?php echo htmlspecialchars($root_url . 'landing_page', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Kembali ke Beranda</a>
      <a href="<?php echo htmlspecialchars($root_url . 'login', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-outline">Portal Login</a>
    </div>
  </main>
</body>
</html>
