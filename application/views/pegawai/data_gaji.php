<?php
  $alpha_deduction = 0;
  if (!empty($potongan)) {
    foreach ($potongan as $p) {
      if (strtolower($p->potongan) == 'alpha') {
        $alpha_deduction = $p->jml_potongan;
      }
    }
  }

  $bulanIndo = array(
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
  );

  $latest_thp = 0;
  $latest_tunjangan = 0;
  $latest_potongan = 0;
  $latest_periode = '-';

  if (!empty($gaji) && isset($gaji[0])) {
    $g0 = $gaji[0];
    $m0 = substr($g0->bulan, 0, 2);
    $y0 = substr($g0->bulan, 2, 4);
    $latest_periode = (isset($bulanIndo[$m0]) ? $bulanIndo[$m0] : $m0) . ' ' . $y0;

    $tj_lain0  = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['tunjangan']['total'] : 0;
    $pot_lain0 = isset($komponen_per_bulan[$g0->bulan]) ? $komponen_per_bulan[$g0->bulan]['potongan']['total'] : 0;
    $pinjaman0 = isset($komponen_per_bulan[$g0->bulan]['pinjaman']) ? $komponen_per_bulan[$g0->bulan]['pinjaman']['total'] : 0;
    $lembur0   = isset($komponen_per_bulan[$g0->bulan]['uang_lembur']) ? $komponen_per_bulan[$g0->bulan]['uang_lembur'] : 0;
    $pot_gaji0 = $g0->alpha * $alpha_deduction;

    $latest_tunjangan = $g0->tj_transport + $g0->uang_makan + $tj_lain0 + $lembur0;
    $latest_potongan  = $pot_gaji0 + $pot_lain0 + $pinjaman0;
    $latest_thp       = $g0->gaji_pokok + $latest_tunjangan - $latest_potongan;
  }
?>

<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Riwayat penerimaan gaji pokok, tunjangan, lembur, potongan, dan cetak slip gaji resmi.</p>
  </div>
  <span class="emp-date-stamp">
    <i class="fas fa-receipt text-primary"></i>
    <span class="tabular-nums"><?php echo count($gaji); ?> Slip Tersedia</span>
  </span>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<!-- Ringkasan Remunerasi Periode Terakhir -->
<section class="emp-metric-strip mb-4" aria-label="Ringkasan slip gaji terakhir">
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Gaji Bersih Terakhir</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_thp, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Periode <?php echo htmlspecialchars($latest_periode, ENT_QUOTES, 'UTF-8'); ?></div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Tunjangan & Lembur</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_tunjangan, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Transport, makan, komponen & lembur</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Total Potongan</div>
    <div class="emp-metric-value">Rp <?php echo number_format($latest_potongan, 0, ',', '.'); ?></div>
    <div class="emp-metric-note">Alpha, cicilan kasbon & potongan lain</div>
  </div>
  <div class="emp-metric-tile">
    <div class="emp-metric-label">Arsip Slip Digital</div>
    <div class="emp-metric-value"><?php echo count($gaji); ?> <span class="small font-weight-normal text-muted">dokumen</span></div>
    <div class="emp-metric-note">Siap dicetak dalam format resmi</div>
  </div>
</section>

<?php
  $diffs_map = isset($diffs_per_bulan) && is_array($diffs_per_bulan) ? $diffs_per_bulan : array();
  $ld = isset($latest_diff) && is_array($latest_diff) ? $latest_diff : null;
  if ($ld) :
    $ld_dir = isset($ld['direction']) ? $ld['direction'] : 'baseline';
    $ld_pill_class = 'is-' . $ld_dir;
    if ($ld_dir === 'up') {
      $ld_icon = 'fa-arrow-trend-up';
      $ld_badge_text = Payroll_diff_explainer::formatRupiah($ld['net_delta'], true)
        . ($ld['net_delta_pct'] !== null ? ' (' . Payroll_diff_explainer::formatPercent($ld['net_delta_pct']) . ')' : '');
    } elseif ($ld_dir === 'down') {
      $ld_icon = 'fa-arrow-trend-down';
      $ld_badge_text = Payroll_diff_explainer::formatRupiah($ld['net_delta'], true)
        . ($ld['net_delta_pct'] !== null ? ' (' . Payroll_diff_explainer::formatPercent($ld['net_delta_pct']) . ')' : '');
    } elseif ($ld_dir === 'same') {
      $ld_icon = 'fa-equals';
      $ld_badge_text = 'Tetap (Rp 0)';
    } else {
      $ld_icon = 'fa-flag';
      $ld_badge_text = 'Periode Awal';
    }
?>
<!-- Panel Penjelas Selisih Gaji Otomatis -->
<section class="emp-diff-card mb-4" aria-label="Penjelasan perubahan gaji periode terakhir">
  <div class="emp-diff-head">
    <div>
      <h2 class="h6 font-weight-bold m-0">Kenapa Gaji Periode Ini Berubah?</h2>
      <div class="small text-muted">
        <?php if (!empty($ld['has_previous'])) : ?>
          Perbandingan otomatis <?php echo htmlspecialchars($ld['current_label'], ENT_QUOTES, 'UTF-8'); ?> terhadap <?php echo htmlspecialchars($ld['previous_label'], ENT_QUOTES, 'UTF-8'); ?>
        <?php else : ?>
          Acuan awal periode <?php echo htmlspecialchars($ld['current_label'], ENT_QUOTES, 'UTF-8'); ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="d-flex flex-wrap align-items-center" style="gap: 0.5rem;">
      <span class="emp-diff-pill <?php echo $ld_pill_class; ?>">
        <i class="fas <?php echo $ld_icon; ?>" aria-hidden="true"></i>
        <?php echo htmlspecialchars($ld_badge_text, ENT_QUOTES, 'UTF-8'); ?>
      </span>
      <?php if (!empty($ld['has_previous'])) : ?>
        <button type="button"
                class="btn btn-sm btn-light border btn-open-diff"
                data-bulan="<?php echo htmlspecialchars($ld['current_period'], ENT_QUOTES, 'UTF-8'); ?>">
          <i class="fas fa-scale-balanced" aria-hidden="true"></i> Bandingkan Rincian
        </button>
      <?php endif; ?>
    </div>
  </div>
  <div class="emp-diff-body">
    <p class="emp-diff-summary"><?php echo htmlspecialchars($ld['summary_sentence'], ENT_QUOTES, 'UTF-8'); ?></p>

    <?php if (!empty($ld['factors'])) : ?>
      <div class="emp-diff-factor-grid">
        <?php foreach (array_slice($ld['factors'], 0, 4) as $fc) :
          $is_pos = $fc['impact_on_net'] > 0;
        ?>
          <div class="emp-diff-factor-item">
            <div style="min-width: 0;">
              <div class="emp-diff-factor-title"><?php echo htmlspecialchars($fc['label'], ENT_QUOTES, 'UTF-8'); ?></div>
              <div class="emp-diff-factor-reason"><?php echo htmlspecialchars($fc['reason'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="emp-diff-factor-impact <?php echo $is_pos ? 'is-up' : 'is-down'; ?>">
              <?php echo htmlspecialchars(Payroll_diff_explainer::formatRupiah($fc['impact_on_net'], true), ENT_QUOTES, 'UTF-8'); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- Tabel Riwayat Slip Gaji -->
<div class="emp-card">
  <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
      <h2 class="h6 font-weight-bold m-0">Rincian Gaji Bulanan</h2>
      <span class="small text-muted">Klinik Pratama Dr. H.M. Hidayatullah</span>
    </div>
    <?php if (!empty($available_years)) : ?>
      <form method="GET" action="<?php echo base_url('pegawai/data_gaji'); ?>" class="form-inline">
        <label for="filterTahun" class="small font-weight-bold text-muted mr-2">Filter Tahun:</label>
        <select id="filterTahun" name="tahun" class="form-control form-control-sm" onchange="this.form.submit()">
          <option value="">Semua Tahun</option>
          <?php foreach ($available_years as $yr) : ?>
            <option value="<?php echo htmlspecialchars($yr, ENT_QUOTES, 'UTF-8'); ?>" <?php echo (isset($tahun_filter) && $tahun_filter === $yr) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($yr, ENT_QUOTES, 'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    <?php endif; ?>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0" width="100%">
        <thead>
          <tr>
            <th class="text-center" style="width: 52px;">No</th>
            <th>Periode</th>
            <th class="text-right">Gaji Pokok</th>
            <th class="text-right">Tunjangan</th>
            <th class="text-right">Lembur</th>
            <th class="text-right">Potongan</th>
            <th class="text-right">Gaji Bersih</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($gaji)) : ?>
            <?php $no = 1; foreach ($gaji as $g) :
              $pot_gaji    = $g->alpha * $alpha_deduction;
              $tj_lain     = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['tunjangan']['total'] : 0;
              $pot_lain    = isset($komponen_per_bulan[$g->bulan]) ? $komponen_per_bulan[$g->bulan]['potongan']['total'] : 0;
              $pinjaman    = isset($komponen_per_bulan[$g->bulan]['pinjaman']) ? $komponen_per_bulan[$g->bulan]['pinjaman']['total'] : 0;
              $uang_lembur = isset($komponen_per_bulan[$g->bulan]['uang_lembur']) ? $komponen_per_bulan[$g->bulan]['uang_lembur'] : 0;
              $jam_lembur  = isset($komponen_per_bulan[$g->bulan]['jam_lembur']) ? $komponen_per_bulan[$g->bulan]['jam_lembur'] : 0;

              $total_tunjangan = $g->tj_transport + $g->uang_makan + $tj_lain;
              $total_potongan  = $pot_gaji + $pot_lain + $pinjaman;
              $total_gaji      = $g->gaji_pokok + $total_tunjangan + $uang_lembur - $total_potongan;

              $m = substr($g->bulan, 0, 2);
              $y = substr($g->bulan, 2, 4);
              $namaBulan = isset($bulanIndo[$m]) ? $bulanIndo[$m] : $m;
              $row_diff = isset($diffs_map[$g->bulan]) ? $diffs_map[$g->bulan] : null;
              $rd_dir   = $row_diff ? $row_diff['direction'] : 'baseline';
            ?>
              <tr>
                <td class="text-center text-muted tabular-nums"><?php echo $no++; ?></td>
                <td class="font-weight-bold"><?php echo $namaBulan . ' ' . $y; ?></td>
                <td class="text-right tabular-nums">Rp <?php echo number_format($g->gaji_pokok, 0, ',', '.'); ?></td>
                <td class="text-right tabular-nums">+Rp <?php echo number_format($total_tunjangan, 0, ',', '.'); ?></td>
                <td class="text-right tabular-nums">
                  <?php if ($uang_lembur > 0) : ?>
                    <div>+Rp <?php echo number_format($uang_lembur, 0, ',', '.'); ?></div>
                    <div class="small text-muted"><?php echo (int)$jam_lembur; ?> jam</div>
                  <?php else : ?>
                    <span class="text-muted">Rp 0</span>
                  <?php endif; ?>
                </td>
                <td class="text-right tabular-nums">
                  <?php if ($total_potongan > 0) : ?>
                    <div style="color: var(--emp-danger);">-Rp <?php echo number_format($total_potongan, 0, ',', '.'); ?></div>
                    <?php if ($pinjaman > 0) : ?>
                      <div class="small text-muted">Kasbon Rp <?php echo number_format($pinjaman, 0, ',', '.'); ?></div>
                    <?php endif; ?>
                  <?php else : ?>
                    <span class="text-muted">Rp 0</span>
                  <?php endif; ?>
                </td>
                <td class="text-right font-weight-bold tabular-nums text-primary">
                  <div>Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></div>
                  <?php if ($row_diff) : ?>
                    <?php if ($rd_dir === 'up') : ?>
                      <div class="emp-diff-inline is-up">
                        <i class="fas fa-arrow-trend-up" aria-hidden="true"></i>
                        <?php echo htmlspecialchars(Payroll_diff_explainer::formatRupiah($row_diff['net_delta'], true), ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                    <?php elseif ($rd_dir === 'down') : ?>
                      <div class="emp-diff-inline is-down">
                        <i class="fas fa-arrow-trend-down" aria-hidden="true"></i>
                        <?php echo htmlspecialchars(Payroll_diff_explainer::formatRupiah($row_diff['net_delta'], true), ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                    <?php elseif ($rd_dir === 'same') : ?>
                      <div class="emp-diff-inline is-same">
                        <i class="fas fa-equals" aria-hidden="true"></i> Tetap
                      </div>
                    <?php else : ?>
                      <div class="emp-diff-inline is-baseline">Periode awal</div>
                    <?php endif; ?>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="d-inline-flex flex-wrap gap-1 justify-content-center">
                    <?php if ($row_diff) : ?>
                      <button type="button"
                              class="btn btn-sm btn-outline-primary btn-open-diff"
                              data-bulan="<?php echo htmlspecialchars($g->bulan, ENT_QUOTES, 'UTF-8'); ?>"
                              title="Lihat penjelasan selisih gaji periode ini">
                        <i class="fas fa-scale-balanced" aria-hidden="true"></i> Selisih
                      </button>
                    <?php endif; ?>
                    <a class="btn btn-sm btn-primary" target="_blank" href="<?php echo base_url('pegawai/data_gaji/cetak_slip/' . $g->id_kehadiran); ?>">
                      <i class="fas fa-print"></i> Cetak Slip
                    </a>
                    <a class="btn btn-sm btn-light border" href="<?php echo base_url('pegawai/data_gaji/download_pdf/' . $g->id_kehadiran); ?>">
                      <i class="fas fa-file-pdf"></i> PDF
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <div class="font-weight-bold mb-1">Belum ada data slip gaji tersedia</div>
                <p class="small mb-0">Slip gaji akan muncul otomatis setelah periode payroll diproses oleh HRD.</p>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Penjelas Selisih Gaji (Reusable) -->
<div class="modal fade" id="modalDiffGaji" tabindex="-1" role="dialog" aria-labelledby="modalDiffGajiTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="background: var(--emp-surface); color: var(--emp-ink); border: 1px solid var(--emp-border);">
      <div class="modal-header" style="border-bottom: 1px solid var(--emp-border);">
        <div>
          <h5 class="modal-title font-weight-bold mb-0" id="modalDiffGajiTitle">Analisis Selisih Gaji</h5>
          <div class="small text-muted" id="modalDiffSubtitle">Perbandingan antar periode</div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup" style="color: var(--emp-ink);">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="emp-diff-modal-summary">
          <div class="emp-diff-modal-box">
            <div class="small text-muted" id="modalDiffPrevLabel">Periode Sebelumnya</div>
            <div class="h6 font-weight-bold mb-0 tabular-nums" id="modalDiffPrevNet">-</div>
          </div>
          <div class="emp-diff-modal-box">
            <div class="small text-muted" id="modalDiffCurrLabel">Periode Ini</div>
            <div class="h6 font-weight-bold mb-0 tabular-nums" id="modalDiffCurrNet">-</div>
          </div>
          <div class="emp-diff-modal-box">
            <div class="small text-muted">Selisih Bersih (THP)</div>
            <div class="h6 font-weight-bold mb-0 tabular-nums" id="modalDiffDeltaNet">-</div>
          </div>
        </div>

        <div class="p-3 rounded mb-3" style="background: var(--emp-surface-alt); border: 1px solid var(--emp-border);">
          <div class="small font-weight-bold text-uppercase text-muted mb-1" style="letter-spacing: 0.04em;">Ringkasan Otomatis</div>
          <p class="small mb-0" id="modalDiffSentence" style="color: var(--emp-ink); line-height: 1.55;"></p>
        </div>

        <div class="table-responsive">
          <table class="table table-sm mb-0" aria-label="Rincian faktor perubahan gaji">
            <thead>
              <tr>
                <th>Komponen</th>
                <th class="text-right">Periode Lalu</th>
                <th class="text-right">Periode Ini</th>
                <th class="text-right">Dampak ke THP</th>
              </tr>
            </thead>
            <tbody id="modalDiffTableBody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer d-flex flex-wrap justify-content-between align-items-center" style="border-top: 1px solid var(--emp-border);">
        <div class="small text-muted tabular-nums" id="modalDiffReconcile"></div>
        <button type="button" class="btn btn-light btn-sm border" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  var diffMap = <?php echo json_encode($diffs_map, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

  function formatRp(val, signed) {
    var num = Number(val || 0);
    var abs = Math.abs(Math.round(num));
    var text = 'Rp ' + abs.toLocaleString('id-ID');
    if (signed) {
      if (num > 0.001) return '+' + text;
      if (num < -0.001) return '-' + text;
      return 'Rp 0';
    }
    return (num < -0.001 ? '-' : '') + text;
  }

  function formatPct(pct) {
    if (pct === null || typeof pct === 'undefined') return '';
    var num = Number(pct);
    var sign = num > 0 ? '+' : '';
    return ' (' + sign + num.toFixed(1).replace('.', ',') + '%)';
  }

  function openDiffModal(bulanCode) {
    var d = diffMap ? diffMap[bulanCode] : null;
    if (!d) return;

    document.getElementById('modalDiffGajiTitle').textContent = d.headline || 'Analisis Selisih Gaji';
    document.getElementById('modalDiffSubtitle').textContent = d.has_previous
      ? ('Perbandingan ' + d.current_label + ' terhadap ' + d.previous_label)
      : ('Periode awal: ' + d.current_label);

    document.getElementById('modalDiffPrevLabel').textContent = d.has_previous ? d.previous_label : 'Periode Sebelumnya';
    document.getElementById('modalDiffPrevNet').textContent   = d.has_previous ? formatRp(d.previous_net, false) : 'Belum tersedia';
    document.getElementById('modalDiffCurrLabel').textContent = d.current_label || 'Periode Ini';
    document.getElementById('modalDiffCurrNet').textContent   = formatRp(d.current_net, false);

    var deltaEl = document.getElementById('modalDiffDeltaNet');
    if (d.has_previous) {
      deltaEl.textContent = formatRp(d.net_delta, true) + formatPct(d.net_delta_pct);
      deltaEl.style.color = d.net_delta > 0 ? 'var(--emp-success)' : (d.net_delta < 0 ? 'var(--emp-danger)' : 'var(--emp-ink)');
    } else {
      deltaEl.textContent = 'Periode Awal';
      deltaEl.style.color = 'var(--emp-muted)';
    }

    document.getElementById('modalDiffSentence').textContent = d.summary_sentence || '';

    var tbody = document.getElementById('modalDiffTableBody');
    while (tbody.firstChild) tbody.removeChild(tbody.firstChild);

    if (!d.has_previous) {
      var trBase = document.createElement('tr');
      var tdBase = document.createElement('td');
      tdBase.colSpan = 4;
      tdBase.className = 'text-center text-muted py-3 small';
      tdBase.textContent = 'Belum ada periode pembanding sebelumnya untuk slip ini.';
      trBase.appendChild(tdBase);
      tbody.appendChild(trBase);
    } else if (!d.factors || d.factors.length === 0) {
      var trSame = document.createElement('tr');
      var tdSame = document.createElement('td');
      tdSame.colSpan = 4;
      tdSame.className = 'text-center text-muted py-3 small';
      tdSame.textContent = 'Seluruh komponen penerimaan dan potongan identik dengan periode sebelumnya.';
      trSame.appendChild(tdSame);
      tbody.appendChild(trSame);
    } else {
      d.factors.forEach(function(fc) {
        var tr = document.createElement('tr');

        var tdLabel = document.createElement('td');
        var divName = document.createElement('div');
        divName.className = 'font-weight-bold';
        divName.textContent = fc.label;
        var divReason = document.createElement('div');
        divReason.className = 'small text-muted';
        divReason.textContent = fc.reason;
        tdLabel.appendChild(divName);
        tdLabel.appendChild(divReason);

        var tdPrev = document.createElement('td');
        tdPrev.className = 'text-right tabular-nums';
        tdPrev.textContent = formatRp(fc.prev_amount, false);

        var tdCurr = document.createElement('td');
        tdCurr.className = 'text-right tabular-nums';
        tdCurr.textContent = formatRp(fc.curr_amount, false);

        var tdImpact = document.createElement('td');
        tdImpact.className = 'text-right font-weight-bold tabular-nums';
        tdImpact.style.color = fc.impact_on_net >= 0 ? 'var(--emp-success)' : 'var(--emp-danger)';
        tdImpact.textContent = formatRp(fc.impact_on_net, true);

        tr.appendChild(tdLabel);
        tr.appendChild(tdPrev);
        tr.appendChild(tdCurr);
        tr.appendChild(tdImpact);
        tbody.appendChild(tr);
      });
    }

    var recEl = document.getElementById('modalDiffReconcile');
    if (d.has_previous) {
      recEl.textContent = 'Penambah: ' + formatRp(d.positive_total, true)
        + ' | Pengurang: ' + formatRp(d.negative_total, true)
        + ' | Selisih Bersih: ' + formatRp(d.net_delta, true);
    } else {
      recEl.textContent = 'Acuan awal riwayat gaji Anda.';
    }

    if (window.jQuery && typeof window.jQuery('#modalDiffGaji').modal === 'function') {
      window.jQuery('#modalDiffGaji').modal('show');
    }
  }

  document.addEventListener('click', function(ev) {
    var btn = ev.target.closest ? ev.target.closest('.btn-open-diff') : null;
    if (!btn) return;
    var code = btn.getAttribute('data-bulan');
    if (code) openDiffModal(code);
  });
})();
</script>
