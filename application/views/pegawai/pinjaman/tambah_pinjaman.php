<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Lengkapi data pengajuan kasbon beserta berkas identitas untuk evaluasi kelayakan cicilan.</p>
  </div>
  <a href="<?php echo base_url('pegawai/pinjaman'); ?>" class="btn btn-light btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
  </a>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<?php if (!empty($has_active_loan)) : ?>
  <div class="emp-card p-3 mb-4" style="background: var(--emp-accent-bg) !important; border-color: var(--emp-accent-border) !important;">
    <div class="font-weight-bold mb-1" style="color: var(--emp-accent);">Anda masih memiliki pinjaman aktif atau dalam antrean review</div>
    <p class="small mb-0">
      Tercatat permohonan dengan status <strong><?php echo htmlspecialchars($has_active_loan->status, ENT_QUOTES, 'UTF-8'); ?></strong> sebesar <strong>Rp <?php echo number_format($has_active_loan->jumlah_pinjaman, 0, ',', '.'); ?></strong>. Pengajuan baru hanya dapat dilakukan setelah pinjaman sebelumnya berstatus lunas.
    </p>
  </div>
<?php endif; ?>

<?php if (!$is_eligible_tenure) : ?>
  <div class="emp-card p-3 mb-4" style="background: var(--emp-danger-bg) !important;">
    <div class="font-weight-bold mb-1" style="color: var(--emp-danger);">Masa kerja belum memenuhi syarat minimal</div>
    <p class="small mb-0">
      Masa kerja Anda saat ini tercatat <strong><?php echo (int)$masa_kerja_tahun; ?> tahun <?php echo (int)$masa_kerja_bulan; ?> bulan</strong> (total <?php echo (int)$total_bulan_kerja; ?> bulan). Syarat minimal fasilitas pinjaman adalah 6 bulan masa kerja aktif.
    </p>
  </div>
<?php endif; ?>

<?php $is_blocked = (!empty($has_active_loan) || !$is_eligible_tenure); ?>

<div class="row">
  <!-- Formulir Pinjaman -->
  <div class="col-lg-7 mb-4">
    <div class="emp-card">
      <div class="card-header">
        <h2 class="h6 font-weight-bold m-0">Formulir Data Pinjaman & Dokumen Penjamin</h2>
      </div>
      <div class="card-body">
        <form id="formPinjaman" method="POST" action="<?php echo base_url('pegawai/pinjaman/tambah_aksi'); ?>" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-row">
            <div class="col-md-6 form-group">
              <label for="jumlah_pinjaman" class="small font-weight-bold">Nominal Pinjaman (Rp) <span class="text-danger">*</span></label>
              <input type="number" id="jumlah_pinjaman" name="jumlah_pinjaman" class="form-control" required placeholder="Contoh: 1500000" min="100000" max="<?php echo (int)$plafon_maksimal; ?>" step="50000" <?php echo $is_blocked ? 'disabled' : ''; ?>>
              <small class="form-text text-muted tabular-nums">Maksimal: Rp <?php echo number_format($plafon_maksimal, 0, ',', '.'); ?> (2x gaji pokok)</small>
            </div>
            <div class="col-md-6 form-group">
              <label for="tenor_bulan" class="small font-weight-bold">Tenor Angsuran <span class="text-danger">*</span></label>
              <select id="tenor_bulan" name="tenor_bulan" class="form-control" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
                <option value="">-- Pilih Lama Tenor --</option>
                <option value="1">1 Bulan (Potong gaji 1x)</option>
                <option value="2">2 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="4">4 Bulan</option>
                <option value="5">5 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="10">10 Bulan</option>
                <option value="12">12 Bulan (1 Tahun)</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="alasan_pinjaman" class="small font-weight-bold">Alasan / Keperluan Kasbon <span class="text-danger">*</span></label>
            <textarea name="alasan" id="alasan_pinjaman" class="form-control" rows="3" placeholder="Tuliskan keperluan pengajuan pinjaman secara jelas" required <?php echo $is_blocked ? 'disabled' : ''; ?>></textarea>
          </div>

          <hr class="my-3">
          <div class="small font-weight-bold text-primary text-uppercase mb-2">Kontak Darurat / Keluarga Penjamin</div>

          <div class="form-row">
            <div class="col-md-5 form-group">
              <label for="kontak_darurat_nama" class="small font-weight-bold">Nama Penjamin <span class="text-danger">*</span></label>
              <input type="text" id="kontak_darurat_nama" name="kontak_darurat_nama" class="form-control" placeholder="Nama keluarga" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
            </div>
            <div class="col-md-4 form-group">
              <label for="kontak_darurat_hp" class="small font-weight-bold">No. HP / WhatsApp <span class="text-danger">*</span></label>
              <input type="tel" id="kontak_darurat_hp" name="kontak_darurat_hp" class="form-control" placeholder="08xxxxxxxxxx" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
            </div>
            <div class="col-md-3 form-group">
              <label for="kontak_darurat_hubungan" class="small font-weight-bold">Hubungan <span class="text-danger">*</span></label>
              <select id="kontak_darurat_hubungan" name="kontak_darurat_hubungan" class="form-control" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
                <option value="Orang Tua">Orang Tua</option>
                <option value="Suami / Istri">Suami / Istri</option>
                <option value="Saudara Kandung">Saudara</option>
                <option value="Keluarga Lain">Lainnya</option>
              </select>
            </div>
          </div>

          <hr class="my-3">
          <div class="small font-weight-bold text-primary text-uppercase mb-2">Berkas Identitas & Jaminan</div>

          <div class="form-group">
            <label for="file_ktp" class="small font-weight-bold">Foto KTP Asli Pemohon <span class="text-danger">*</span></label>
            <input type="file" name="file_ktp" id="file_ktp" class="form-control-file border p-2 rounded" accept="image/jpeg,image/png,image/jpg,application/pdf" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
            <small class="form-text text-muted">Format JPG, PNG, atau PDF (maks. 3 MB).</small>
          </div>

          <div class="form-group">
            <label for="file_jaminan" class="small font-weight-bold">Dokumen Jaminan / Bukti Kebutuhan (Opsional)</label>
            <input type="file" name="file_jaminan" id="file_jaminan" class="form-control-file border p-2 rounded" accept="image/jpeg,image/png,image/jpg,application/pdf" <?php echo $is_blocked ? 'disabled' : ''; ?>>
            <small class="form-text text-muted">Foto ijazah terakhir, kwitansi medis, atau dokumen pendukung lain (maks. 5 MB).</small>
          </div>

          <div class="custom-control custom-checkbox mb-4 p-3 rounded border" style="background: var(--emp-surface-alt);">
            <input type="checkbox" class="custom-control-input" id="checkLegalConsent" required <?php echo $is_blocked ? 'disabled' : ''; ?>>
            <label class="custom-control-label small font-weight-bold" for="checkLegalConsent">
              Saya menyatakan data di atas benar dan memberi kuasa kepada Manajemen Klinik untuk memotong gaji bulanan guna pelunasan kasbon ini sesuai jadwal tenor.
            </label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo base_url('pegawai/pinjaman'); ?>" class="btn btn-light btn-sm">Batal</a>
            <button type="submit" id="btnSubmitPinjaman" class="btn btn-primary" <?php echo $is_blocked ? 'disabled data-blocked="1"' : ''; ?>>
              <i class="fas fa-paper-plane"></i> Kirim Permohonan Pinjaman
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Simulasi Cicilan & Kelayakan -->
  <div class="col-lg-5 mb-4">
    <div class="emp-attendance-hero mb-4 text-center">
      <div class="emp-hero-label">Simulasi Cicilan & Rasio DSR</div>
      <div class="emp-attendance-clock my-2" id="display-cicilan">Rp 0 <span style="font-size: 1.1rem; font-weight: 500;">/bln</span></div>
      <div class="emp-time-slot text-left mt-3">
        <div class="d-flex justify-content-between small mb-1" style="color: #CCFBF1;">
          <span>Beban Cicilan terhadap Gaji</span>
          <span class="font-weight-bold tabular-nums text-white" id="textDsrPercent">0%</span>
        </div>
        <div class="progress" style="height: 8px;">
          <div id="barDsr" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
        </div>
        <div class="small mt-2" style="color: #CCFBF1;" id="textRiskDesc">Batas aman cicilan maksimal 40% dari total penghasilan.</div>
      </div>
    </div>

    <div class="emp-card">
      <div class="card-header">
        <h2 class="h6 font-weight-bold m-0">Status Kelayakan Finansial</h2>
      </div>
      <div class="card-body">
        <div class="pb-3 mb-3 border-bottom">
          <div class="font-weight-bold"><?php echo htmlspecialchars($pegawai->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="small text-muted tabular-nums">NIK: <?php echo htmlspecialchars($pegawai->nik, ENT_QUOTES, 'UTF-8'); ?> &middot; <?php echo htmlspecialchars((string)$pegawai->nama_jabatan, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>

        <div class="small">
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Masa Kerja</span>
            <span class="font-weight-bold tabular-nums"><?php echo (int)$masa_kerja_tahun; ?> thn <?php echo (int)$masa_kerja_bulan; ?> bln</span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Gaji Pokok</span>
            <span class="font-weight-bold tabular-nums">Rp <?php echo number_format($gaji_pokok, 0, ',', '.'); ?></span>
          </div>
          <div class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Plafon Maksimal</span>
            <span class="font-weight-bold text-primary tabular-nums">Rp <?php echo number_format($plafon_maksimal, 0, ',', '.'); ?></span>
          </div>
          <div class="d-flex justify-content-between py-2">
            <span class="text-muted">Batas Cicilan / Bulan</span>
            <span class="font-weight-bold tabular-nums">Rp <?php echo number_format($cicilan_maksimal, 0, ',', '.'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var inputNominal = document.getElementById('jumlah_pinjaman');
  var selectTenor  = document.getElementById('tenor_bulan');
  var dispCicilan  = document.getElementById('display-cicilan');
  var textDsr      = document.getElementById('textDsrPercent');
  var barDsr       = document.getElementById('barDsr');
  var textRisk     = document.getElementById('textRiskDesc');
  var btnSubmit    = document.getElementById('btnSubmitPinjaman');

  var totalGaji  = <?php echo (float)$total_gaji; ?>;
  var maxCicilan = <?php echo (float)$cicilan_maksimal; ?>;
  var maxPlafon  = <?php echo (float)$plafon_maksimal; ?>;

  function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
  }

  function calculateFinance() {
    var nominal = parseFloat(inputNominal.value) || 0;
    var tenor   = parseInt(selectTenor.value, 10) || 0;

    if (nominal > 0 && tenor > 0) {
      var cicilan = Math.ceil(nominal / tenor);
      dispCicilan.innerHTML = formatRupiah(cicilan) + ' <span style="font-size: 1.1rem; font-weight: 500;">/bln</span>';

      var dsr = totalGaji > 0 ? ((cicilan / totalGaji) * 100).toFixed(1) : 0;
      textDsr.textContent = dsr + '%';
      barDsr.style.width  = Math.min(dsr, 100) + '%';

      if (nominal > maxPlafon) {
        barDsr.className = 'progress-bar bg-danger';
        textRisk.textContent = 'Nominal melebihi batas plafon 2x gaji pokok.';
        if (btnSubmit) btnSubmit.disabled = true;
      } else if (cicilan > maxCicilan || parseFloat(dsr) > 40) {
        barDsr.className = 'progress-bar bg-danger';
        textRisk.textContent = 'Cicilan melebihi 40% total gaji. Perpanjang tenor atau turunkan nominal.';
        if (btnSubmit) btnSubmit.disabled = true;
      } else if (parseFloat(dsr) > 25) {
        barDsr.className = 'progress-bar bg-warning';
        textRisk.textContent = 'Rasio cicilan wajar (' + dsr + '% dari total penghasilan).';
        if (btnSubmit && !btnSubmit.dataset.blocked) btnSubmit.disabled = false;
      } else {
        barDsr.className = 'progress-bar bg-success';
        textRisk.textContent = 'Rasio cicilan aman (' + dsr + '% dari total penghasilan).';
        if (btnSubmit && !btnSubmit.dataset.blocked) btnSubmit.disabled = false;
      }
    } else {
      dispCicilan.innerHTML = 'Rp 0 <span style="font-size: 1.1rem; font-weight: 500;">/bln</span>';
      textDsr.textContent = '0%';
      barDsr.style.width  = '0%';
      barDsr.className = 'progress-bar bg-success';
      textRisk.textContent = 'Batas aman cicilan maksimal 40% dari total penghasilan.';
    }
  }

  if (inputNominal && selectTenor) {
    inputNominal.addEventListener('input', calculateFinance);
    selectTenor.addEventListener('change', calculateFinance);
    calculateFinance();
  }
});
</script>
