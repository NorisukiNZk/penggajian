<?php
  $bulan_indo = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
  $nama_pimpinan = $this->session->userdata('nama_pegawai') ?: 'Pimpinan';
?>

<section class="exec-brief-head">
  <div>
    <h1 class="exec-brief-title">Ringkasan Operasional Klinik</h1>
    <p class="exec-brief-sub">
      Ikhtisar kehadiran staf hari ini, komitmen remunerasi bulan <?php echo $bulan_indo[date('m')] . ' ' . date('Y'); ?>, dan berkas yang menunggu pengesahan <?php echo htmlspecialchars($nama_pimpinan, ENT_QUOTES, 'UTF-8'); ?>.
    </p>
  </div>
  <div class="d-flex flex-wrap" style="gap: 0.5rem;">
    <a href="<?php echo base_url('pimpinan/persetujuan'); ?>" class="btn btn-exec-primary btn-sm">
      <i class="fas fa-stamp"></i> Buka Meja Persetujuan
    </a>
    <a href="<?php echo base_url('pimpinan/laporan'); ?>" class="btn btn-exec-outline btn-sm">
      <i class="fas fa-print"></i> Cetak Laporan
    </a>
  </div>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- BAND 1: Asymmetric 7/5 Split: Operational Pulse + Decision Queue -->
<div class="row mb-4">
  <div class="col-lg-7 mb-4 mb-lg-0">
    <div class="exec-brief-banner h-100 d-flex flex-column justify-content-between">
      <div>
        <div class="exec-banner-kicker">Denyut Kehadiran Hari Ini &middot; <?php echo date('d M Y'); ?></div>
        <div class="d-flex flex-wrap align-items-baseline" style="gap: 0.75rem;">
          <div class="exec-banner-figure"><?php echo $persen_hadir; ?>%</div>
          <div style="color: #DCE5EE; font-size: 0.95rem;">
            <strong class="text-white tabular-nums"><?php echo $hadir_hari_ini; ?></strong> dari <strong class="text-white tabular-nums"><?php echo $total_pegawai; ?></strong> pegawai tercatat masuk hari ini
          </div>
        </div>
      </div>

      <div class="row mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.16);">
        <div class="col-4">
          <div class="small" style="color: #CBD5E1;">Tepat Waktu</div>
          <div class="h4 exec-serif font-weight-bold text-white mb-0 tabular-nums"><?php echo $tepat_waktu_hari_ini; ?></div>
        </div>
        <div class="col-4">
          <div class="small" style="color: #CBD5E1;">Terlambat</div>
          <div class="h4 exec-serif font-weight-bold mb-0 tabular-nums" style="color: #FCD34D;"><?php echo $terlambat_hari_ini; ?></div>
        </div>
        <div class="col-4">
          <div class="small" style="color: #CBD5E1;">Sakit / Izin</div>
          <div class="h4 exec-serif font-weight-bold text-white mb-0 tabular-nums"><?php echo $sakit_izin_hari_ini; ?></div>
        </div>
      </div>

      <div class="mt-4 d-flex flex-wrap align-items-center justify-content-between" style="gap: 0.5rem;">
        <span class="small" style="color: #CBD5E1;">Data ditarik langsung dari presensi harian klinik.</span>
        <a href="<?php echo base_url('pimpinan/monitoring?tab=hari_ini'); ?>" class="btn btn-sm" style="background: rgba(255,255,255,0.14); color: #FFFFFF; border: 1px solid rgba(255,255,255,0.28);">
          Pantau Daftar Kehadiran
        </a>
      </div>
    </div>
  </div>

  <!-- Decision Queue Panel -->
  <div class="col-lg-5">
    <div class="exec-panel h-100 d-flex flex-column">
      <div class="exec-panel-header">
        <h2 class="exec-panel-title">Antrean Keputusan</h2>
        <?php if ($total_pending > 0) : ?>
          <span class="exec-tag exec-tag-pending tabular-nums"><?php echo $total_pending; ?> Menunggu</span>
        <?php else : ?>
          <span class="exec-tag exec-tag-ok">Semua Selesai</span>
        <?php endif; ?>
      </div>

      <div class="exec-panel-body flex-grow-1">
        <?php if ($total_pending === 0) : ?>
          <div class="py-4 text-center">
            <div class="font-weight-bold mb-1">Tidak ada berkas tertunda</div>
            <p class="small text-muted mb-0">Seluruh pengajuan cuti, lembur, dan pinjaman pegawai sudah diproses.</p>
          </div>
        <?php else : ?>
          <div class="small">
            <a href="<?php echo base_url('pimpinan/persetujuan?tab=cuti'); ?>" class="d-flex justify-content-between align-items-center py-2 border-bottom text-decoration-none" style="color: var(--exec-ink);">
              <div>
                <div class="font-weight-bold">Permohonan Cuti & Izin</div>
                <div class="text-muted">Termasuk berkas dengan telaah HRD</div>
              </div>
              <span class="exec-tag <?php echo $count_pending_cuti > 0 ? 'exec-tag-pending' : 'exec-tag-ok'; ?> tabular-nums">
                <?php echo $count_pending_cuti; ?> berkas
              </span>
            </a>

            <a href="<?php echo base_url('pimpinan/persetujuan?tab=lembur'); ?>" class="d-flex justify-content-between align-items-center py-2 border-bottom text-decoration-none" style="color: var(--exec-ink);">
              <div>
                <div class="font-weight-bold">Pengajuan Jam Lembur</div>
                <div class="text-muted">Menunggu pengesahan jam tambahan</div>
              </div>
              <span class="exec-tag <?php echo $count_pending_lembur > 0 ? 'exec-tag-pending' : 'exec-tag-ok'; ?> tabular-nums">
                <?php echo $count_pending_lembur; ?> berkas
              </span>
            </a>

            <a href="<?php echo base_url('pimpinan/persetujuan?tab=pinjaman'); ?>" class="d-flex justify-content-between align-items-center py-2 text-decoration-none" style="color: var(--exec-ink);">
              <div>
                <div class="font-weight-bold">Permohonan Kasbon / Pinjaman</div>
                <div class="text-muted">Evaluasi kelayakan plafon & cicilan</div>
              </div>
              <span class="exec-tag <?php echo $count_pending_pinjaman > 0 ? 'exec-tag-pending' : 'exec-tag-ok'; ?> tabular-nums">
                <?php echo $count_pending_pinjaman; ?> berkas
              </span>
            </a>
          </div>

          <?php if (!empty($pending_cuti_list)) : ?>
            <div class="mt-3 pt-3 border-top">
              <div class="small font-weight-bold text-muted mb-2 text-uppercase" style="letter-spacing: 0.04em;">Prioritas Terbaru</div>
              <?php foreach (array_slice($pending_cuti_list, 0, 2) as $pc) : ?>
                <div class="d-flex justify-content-between align-items-center py-1 small">
                  <div>
                    <strong><?php echo htmlspecialchars($pc->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span class="text-muted">&middot; Cuti <?php echo htmlspecialchars($pc->jenis_cuti, ENT_QUOTES, 'UTF-8'); ?></span>
                  </div>
                  <span class="text-muted tabular-nums"><?php echo date('d M', strtotime($pc->tanggal_mulai)); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- BAND 2: Editorial Ruled Ledger Strip -->
<section class="exec-ledger mb-4" aria-label="Indikator keuangan dan kepegawaian">
  <div class="exec-ledger-cell">
    <div class="exec-ledger-label">Total Personel Aktif</div>
    <div class="exec-ledger-figure"><?php echo $total_pegawai; ?> <span class="small font-weight-normal text-muted">orang</span></div>
    <div class="exec-ledger-note">Terdaftar pada master pegawai klinik</div>
  </div>
  <div class="exec-ledger-cell">
    <div class="exec-ledger-label">Komitmen Gaji Dasar / Bln</div>
    <div class="exec-ledger-figure">Rp <?php echo number_format($estimasi_payroll, 0, ',', '.'); ?></div>
    <div class="exec-ledger-note">Gaji pokok, transport & uang makan</div>
  </div>
  <div class="exec-ledger-cell">
    <div class="exec-ledger-label">Saldo Kasbon Berjalan</div>
    <div class="exec-ledger-figure">Rp <?php echo number_format($kasbon_aktif_dana, 0, ',', '.'); ?></div>
    <div class="exec-ledger-note"><?php echo $kasbon_aktif_jumlah; ?> pinjaman aktif dipotong payroll</div>
  </div>
  <div class="exec-ledger-cell">
    <div class="exec-ledger-label">Lembur Disetujui Bln Ini</div>
    <div class="exec-ledger-figure"><?php echo $lembur_bulan_jam; ?> <span class="small font-weight-normal text-muted">jam</span></div>
    <div class="exec-ledger-note">Periode <?php echo $bulan_indo[date('m')] . ' ' . date('Y'); ?></div>
  </div>
</section>

<!-- BAND 3: Asymmetric 8/4 Split: 6-Month Attendance Question Chart + Composition & Holidays -->
<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="exec-panel h-100">
      <div class="exec-panel-header">
        <div>
          <h2 class="exec-panel-title">Bagaimana tren kehadiran staf dalam 6 bulan terakhir?</h2>
          <div class="small text-muted">Perbandingan total hari hadir, sakit, dan alpha dari rekap kehadiran bulanan.</div>
        </div>
        <a href="<?php echo base_url('pimpinan/monitoring?tab=rekap'); ?>" class="small font-weight-bold" style="color: var(--exec-accent);">
          Lihat Rekap Bulanan
        </a>
      </div>
      <div class="exec-panel-body">
        <?php if ($label_bulan === '[]') : ?>
          <div class="py-5 text-center text-muted">
            <div class="font-weight-bold mb-1">Belum ada data historis kehadiran bulanan</div>
            <p class="small mb-0">Grafik akan terisi otomatis setelah data kehadiran bulanan disinkronkan oleh HRD.</p>
          </div>
        <?php else : ?>
          <div style="position: relative; height: 290px;">
            <canvas id="execAttendanceChart" aria-label="Grafik tren kehadiran 6 bulan terakhir"></canvas>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-4">
    <div class="exec-panel mb-4">
      <div class="exec-panel-header">
        <h2 class="exec-panel-title">Komposisi Jabatan</h2>
        <span class="small text-muted tabular-nums"><?php echo count($komposisi_jabatan); ?> unit</span>
      </div>
      <div class="exec-panel-body">
        <?php if (empty($komposisi_jabatan)) : ?>
          <p class="small text-muted mb-0">Belum ada data jabatan pegawai tercatat.</p>
        <?php else : ?>
          <?php foreach ($komposisi_jabatan as $kj) :
            $pct = $total_pegawai > 0 ? round(($kj->jumlah / $total_pegawai) * 100) : 0;
          ?>
            <div class="mb-3">
              <div class="d-flex justify-content-between small mb-1">
                <span class="font-weight-bold"><?php echo htmlspecialchars($kj->jabatan, ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="text-muted tabular-nums"><?php echo (int)$kj->jumlah; ?> orang (<?php echo $pct; ?>%)</span>
              </div>
              <div style="height: 6px; border-radius: 3px; background: var(--exec-surface-alt); overflow: hidden;">
                <div style="width: <?php echo $pct; ?>%; height: 100%; background: var(--exec-primary);"></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="exec-panel">
      <div class="exec-panel-header">
        <h2 class="exec-panel-title">Hari Libur Terdekat</h2>
      </div>
      <div class="exec-panel-body">
        <?php if (empty($hari_libur)) : ?>
          <p class="small text-muted mb-0">Tidak ada jadwal hari libur nasional terdekat.</p>
        <?php else : ?>
          <?php foreach ($hari_libur as $hl) : ?>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom small">
              <span class="font-weight-bold"><?php echo htmlspecialchars($hl->keterangan, ENT_QUOTES, 'UTF-8'); ?></span>
              <span class="text-muted tabular-nums"><?php echo date('d M Y', strtotime($hl->tanggal)); ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var canvas = document.getElementById('execAttendanceChart');
  if (!canvas || typeof Chart === 'undefined') return;

  var isDark = document.documentElement.classList.contains('dark-mode');
  var tickColor = isDark ? '#A4B0BD' : '#525E6B';
  var gridColor = isDark ? 'rgba(164, 176, 189, 0.14)' : 'rgba(82, 94, 107, 0.12)';

  new Chart(canvas, {
    type: 'bar',
    data: {
      labels: <?php echo $label_bulan; ?>,
      datasets: [
        {
          label: 'Hadir',
          data: <?php echo $trend_hadir; ?>,
          backgroundColor: '#18293D',
          borderRadius: 4
        },
        {
          label: 'Sakit',
          data: <?php echo $trend_sakit; ?>,
          backgroundColor: '#854D0E',
          borderRadius: 4
        },
        {
          label: 'Alpha',
          data: <?php echo $trend_alpha; ?>,
          backgroundColor: '#991B1B',
          borderRadius: 4
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { color: tickColor, boxWidth: 12, padding: 16 }
        }
      },
      scales: {
        x: {
          ticks: { color: tickColor },
          grid: { display: false }
        },
        y: {
          beginAtZero: true,
          ticks: { color: tickColor },
          grid: { color: gridColor }
        }
      }
    }
  });
});
</script>
