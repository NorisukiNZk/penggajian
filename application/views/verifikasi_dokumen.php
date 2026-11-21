<!DOCTYPE html>
<html lang="id">
<head>
  <script>
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?> | Klinik Pratama Dr. H.M. Hidayatullah</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/kpmh.png'); ?>" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/landing-page.css'); ?>?v=20261121">
  <style>
    .verif-wrap {
      max-width: 820px;
      margin: 0 auto;
      padding: clamp(2rem, 5vw, 3.5rem) 1.25rem 4rem;
    }
    .verif-card {
      background: var(--lp-surface);
      border: 1px solid var(--lp-border-strong);
      border-radius: var(--lp-radius-md);
      padding: clamp(1.25rem, 3vw, 2rem);
      margin-bottom: 1.75rem;
    }
    .verif-banner {
      padding: 1rem 1.25rem;
      border-radius: var(--lp-radius-sm);
      margin-bottom: 1.25rem;
      display: flex;
      align-items: flex-start;
      gap: 0.85rem;
    }
    .verif-banner.is-valid {
      background: var(--lp-emerald-bg);
      color: var(--lp-emerald);
      border: 1px solid var(--lp-emerald);
    }
    .verif-banner.is-invalid {
      background: #FEE2E2;
      color: #991B1B;
      border: 1px solid #DC2626;
    }
    html.dark-mode .verif-banner.is-invalid {
      background: rgba(239, 68, 68, 0.16);
      color: #FCA5A5;
      border-color: rgba(252, 165, 165, 0.45);
    }
    .verif-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
    }
    .verif-table th,
    .verif-table td {
      padding: 0.7rem 0.5rem;
      border-bottom: 1px solid var(--lp-border);
      text-align: left;
      vertical-align: top;
    }
    .verif-table th {
      width: 38%;
      color: var(--lp-muted);
      font-weight: 600;
    }
    .verif-table td {
      color: var(--lp-ink);
      font-weight: 700;
    }
    .verif-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 0.9rem;
    }
    @media (min-width: 640px) {
      .verif-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    .verif-field label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      margin-bottom: 0.35rem;
      color: var(--lp-ink);
    }
    .verif-field input,
    .verif-field select {
      width: 100%;
      min-height: 44px;
      padding: 0.55rem 0.85rem;
      border-radius: var(--lp-radius-sm);
      border: 1.5px solid var(--lp-border-strong);
      background: var(--lp-ground);
      color: var(--lp-ink);
      font-family: var(--lp-sans);
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <header class="lp-header" role="banner">
    <div class="lp-nav-inner">
      <a class="lp-brand" href="<?php echo base_url(); ?>">
        <img class="lp-brand-logo" src="<?php echo base_url('assets/img/kpmh.png'); ?>" alt="Logo Klinik Hidayatullah">
        <div>
          <div class="lp-brand-title">Verifikasi Dokumen HRIS</div>
          <div class="lp-brand-sub">Klinik Pratama Dr. H.M. Hidayatullah</div>
        </div>
      </a>

      <div class="lp-nav-actions">
        <a class="lp-btn-outline" href="<?php echo base_url(); ?>" style="min-height: 44px; padding: 0.5rem 0.95rem;">Beranda</a>
        <a class="lp-btn-primary" href="<?php echo base_url('login'); ?>" style="min-height: 44px; padding: 0.5rem 0.95rem;">Masuk Portal</a>
      </div>
    </div>
  </header>

  <main class="verif-wrap">
    <div style="margin-bottom: 1.5rem;">
      <div class="lp-section-kicker">Keaslian Dokumen Digital</div>
      <h1 class="lp-section-title" style="margin-bottom: 0.4rem;">Verifikasi QR Code & Tanda Tangan Dokumen</h1>
      <p class="lp-section-desc">
        Pencocokan tanda tangan HMAC-SHA256 dan catatan database resmi untuk slip gaji, surat cuti, SPPK pinjaman, serta laporan resmi Klinik Pratama Dr. H.M. Hidayatullah.
      </p>
    </div>

    <?php if ($checked) : ?>
      <section class="verif-card" aria-live="polite">
        <?php if ($valid && !empty($detail)) : ?>
          <div class="verif-banner is-valid">
            <i class="fas fa-circle-check" style="font-size: 1.45rem; margin-top: 2px;"></i>
            <div>
              <div style="font-weight: 800; font-size: 1rem;">DOKUMEN TERVERIFIKASI SAH</div>
              <div style="font-size: 0.86rem;">Tanda tangan digital cocok dan catatan dokumen ditemukan pada sistem HRIS resmi klinik.</div>
            </div>
          </div>

          <table class="verif-table">
            <tr>
              <th>Jenis Dokumen</th>
              <td><?php echo htmlspecialchars($detail['jenis_dokumen'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
              <th>Kode Verifikasi</th>
              <td class="tabular-nums" style="font-family: monospace;"><?php echo htmlspecialchars($detail['kode_sah'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <?php foreach ($detail['ringkasan'] as $label => $val) : ?>
              <tr>
                <th><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></th>
                <td><?php echo htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <th>Pejabat Penandatangan</th>
              <td><?php echo htmlspecialchars($detail['penandatangan'], ENT_QUOTES, 'UTF-8'); ?><br><span style="font-weight: 500; font-size: 0.82rem; color: var(--lp-muted);"><?php echo htmlspecialchars($detail['sip'], ENT_QUOTES, 'UTF-8'); ?></span></td>
            </tr>
            <tr>
              <th>Waktu Pengecekan</th>
              <td class="tabular-nums"><?php echo htmlspecialchars($detail['waktu_cek'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          </table>
        <?php else : ?>
          <div class="verif-banner is-invalid">
            <i class="fas fa-circle-xmark" style="font-size: 1.45rem; margin-top: 2px;"></i>
            <div>
              <div style="font-weight: 800; font-size: 1rem;">VERIFIKASI GAGAL / TIDAK VALID</div>
              <div style="font-size: 0.86rem;"><?php echo htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
          </div>
        <?php endif; ?>
      </section>
    <?php endif; ?>

    <!-- Manual Verification Lookup Form -->
    <section class="verif-card">
      <h2 class="lp-serif" style="margin: 0 0 0.35rem 0; font-size: 1.25rem;">Pengecekan Manual Kode Dokumen</h2>
      <p style="margin: 0 0 1.25rem 0; font-size: 0.88rem; color: var(--lp-muted);">
        Jika QR Code pada kertas tidak dapat dipindai, masukkan data referensi dan kode singkat yang tertera tepat di bawah QR Code dokumen.
      </p>

      <form method="GET" action="<?php echo base_url('verifikasi/cek'); ?>">
        <div class="verif-grid" style="margin-bottom: 1.15rem;">
          <div class="verif-field">
            <label for="v_tipe">Jenis Dokumen</label>
            <select id="v_tipe" name="tipe" required>
              <option value="">-- Pilih Jenis Dokumen --</option>
              <option value="slip" <?php echo ($input['tipe'] === 'slip') ? 'selected' : ''; ?>>Slip Gaji Resmi Pegawai</option>
              <option value="cuti" <?php echo ($input['tipe'] === 'cuti') ? 'selected' : ''; ?>>Surat Keterangan Cuti / Izin</option>
              <option value="sppk" <?php echo ($input['tipe'] === 'sppk') ? 'selected' : ''; ?>>SPPK Pinjaman Karyawan</option>
              <option value="lap_gaji" <?php echo ($input['tipe'] === 'lap_gaji') ? 'selected' : ''; ?>>Laporan Gaji Bulanan</option>
              <option value="lap_tahun" <?php echo ($input['tipe'] === 'lap_tahun') ? 'selected' : ''; ?>>Laporan Gaji Tahunan</option>
              <option value="lap_absen" <?php echo ($input['tipe'] === 'lap_absen') ? 'selected' : ''; ?>>Laporan Absensi Bulanan</option>
              <option value="lap_cuti" <?php echo ($input['tipe'] === 'lap_cuti') ? 'selected' : ''; ?>>Laporan Cuti Pegawai</option>
              <option value="lap_lembur" <?php echo ($input['tipe'] === 'lap_lembur') ? 'selected' : ''; ?>>Laporan Lembur Karyawan</option>
              <option value="lap_potong" <?php echo ($input['tipe'] === 'lap_potong') ? 'selected' : ''; ?>>Laporan Potongan Gaji</option>
              <option value="lap_peg" <?php echo ($input['tipe'] === 'lap_peg') ? 'selected' : ''; ?>>Laporan Data Pegawai</option>
              <option value="lap_jab" <?php echo ($input['tipe'] === 'lap_jab') ? 'selected' : ''; ?>>Laporan Standar Jabatan</option>
            </select>
          </div>

          <div class="verif-field">
            <label for="v_ref">Referensi (NIK / ID Cuti / ID Pinjaman / Cakupan)</label>
            <input type="text" id="v_ref" name="ref" value="<?php echo htmlspecialchars($input['ref'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Misal: 76788 atau KLINIK" required>
          </div>

          <div class="verif-field">
            <label for="v_periode">Periode (mmYYYY / Tahun, kosongkan jika tidak ada)</label>
            <input type="text" id="v_periode" name="periode" value="<?php echo htmlspecialchars($input['periode'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Misal: 112026 atau 2026">
          </div>

          <div class="verif-field">
            <label for="v_sig">Kode Tanda Tangan (di bawah QR Code)</label>
            <input type="text" id="v_sig" name="sig" value="<?php echo htmlspecialchars($input['sig'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Misal: SLIP-A1B2C3D4E5F6" required>
          </div>
        </div>

        <button type="submit" class="lp-btn-primary">
          <i class="fas fa-shield-check"></i> Verifikasi Dokumen Sekarang
        </button>
      </form>
    </section>
  </main>
</body>
</html>
