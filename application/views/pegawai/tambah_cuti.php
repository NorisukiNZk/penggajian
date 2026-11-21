<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Lengkapi periode cuti, rekan pengganti shift, serta berkas pendukung agar siap diverifikasi HRD dan Pimpinan.</p>
  </div>
  <a href="<?php echo base_url('pegawai/cuti'); ?>" class="btn btn-light btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
  </a>
</section>

<?php echo $this->session->flashdata('pesan'); ?>

<div class="row">
  <!-- Formulir Pengajuan -->
  <div class="col-lg-7 mb-4">
    <div class="emp-card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h6 font-weight-bold m-0">Formulir Permohonan & Delegasi Shift</h2>
        <span class="small text-muted">SOP Klinik Hidayatullah</span>
      </div>
      <div class="card-body">
        <form id="formPengajuanCuti" method="POST" action="<?php echo base_url('pegawai/cuti/tambah_aksi'); ?>" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-row">
            <div class="col-md-6 form-group">
              <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="tanggal_akhir" class="small font-weight-bold">Tanggal Akhir <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>

          <div id="durasi-alert" class="alert alert-warning py-2 small d-none mb-3">
            <i class="fas fa-exclamation-triangle mr-1"></i> <span id="durasi-alert-msg"></span>
          </div>

          <div class="form-group">
            <label for="jenis_cuti" class="small font-weight-bold">Kategori Cuti / Izin <span class="text-danger">*</span></label>
            <select name="jenis_cuti" id="jenis_cuti" class="form-control" required>
              <option value="">-- Pilih Kategori Cuti / Izin --</option>
              <option value="Tahunan">Cuti Tahunan (Hak 12 Hari Kerja)</option>
              <option value="Sakit">Cuti Sakit (Wajib Unggah Surat Dokter / SKD)</option>
              <option value="Melahirkan">Cuti Melahirkan (Khusus Pegawai Wanita)</option>
              <option value="Izin Penting">Izin Khusus / Keperluan Mendesak</option>
            </select>
          </div>

          <div class="form-group">
            <label for="alasan" class="small font-weight-bold">Alasan & Kondisi Pengajuan <span class="text-danger">*</span></label>
            <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Jelaskan keperluan cuti secara jelas untuk bahan telaah HRD dan Pimpinan" required></textarea>
          </div>

          <!-- Pilar 1: Delegasi Shift -->
          <div class="p-3 my-4 rounded border" style="background: var(--emp-surface-alt);">
            <div class="small font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 0.04em;">1. Pendelegasian Tugas & Pengganti Shift</div>
            <p class="small text-muted mb-3">Tunjuk rekan kerja yang mem-backup tugas agar pelayanan pasien tetap berjalan.</p>

            <div class="form-group">
              <label for="nik_pengganti" class="small font-weight-bold">Rekan Kerja Pengganti <span class="text-danger">*</span></label>
              <select name="nik_pengganti" id="nik_pengganti" class="form-control" required>
                <option value="">-- Pilih Rekan Pengganti Shift --</option>
                <?php if (!empty($rekan_kerja)) : ?>
                  <?php foreach ($rekan_kerja as $rk) : ?>
                    <option value="<?php echo htmlspecialchars($rk->nik, ENT_QUOTES, 'UTF-8'); ?>">
                      <?php echo htmlspecialchars($rk->nama_pegawai . ' - ' . $rk->jabatan . ' (NIK: ' . $rk->nik . ')', ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="form-group mb-0">
              <label for="tugas_pengganti" class="small font-weight-bold">Rincian Tugas yang Didelegasikan <span class="text-danger">*</span></label>
              <textarea name="tugas_pengganti" id="tugas_pengganti" class="form-control" rows="2" placeholder="Contoh: Menggantikan shift pagi di Poli Umum dan pencatatan rekam medis" required></textarea>
            </div>
          </div>

          <!-- Pilar 2: Lampiran -->
          <div class="p-3 my-4 rounded border" style="background: var(--emp-surface-alt);">
            <div class="small font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 0.04em;">2. Berkas Bukti Pendukung / SKD</div>
            <p class="small text-muted mb-3" id="lampiran-keterangan">Untuk Cuti Sakit wajib mengunggah Surat Keterangan Dokter resmi (JPG, PNG, atau PDF maks. 3 MB).</p>

            <div class="custom-file">
              <input type="file" name="file_lampiran" id="file_lampiran" class="custom-file-input" accept=".jpg,.jpeg,.png,.pdf">
              <label class="custom-file-label text-truncate" id="file_lampiran_label" for="file_lampiran">Pilih file Surat Dokter / Berkas Bukti...</label>
            </div>
          </div>

          <!-- Pilar 3: Kontak Darurat -->
          <div class="p-3 my-4 rounded border" style="background: var(--emp-surface-alt);">
            <div class="small font-weight-bold text-primary text-uppercase mb-2" style="letter-spacing: 0.04em;">3. Kontak Darurat Selama Cuti</div>
            <div class="form-row">
              <div class="col-md-6 form-group mb-md-0">
                <label for="kontak_darurat" class="small font-weight-bold">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="08xxxxxxxxxx" required>
              </div>
              <div class="col-md-6 form-group mb-0">
                <label for="alamat_cuti" class="small font-weight-bold">Kota / Alamat Selama Cuti</label>
                <input type="text" name="alamat_cuti" id="alamat_cuti" class="form-control" placeholder="Opsional jika berada di luar kota">
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-2">
            <a href="<?php echo base_url('pegawai/cuti'); ?>" class="btn btn-light btn-sm">Batal</a>
            <button type="submit" id="btn-submit-cuti" class="btn btn-primary">
              <i class="fas fa-paper-plane"></i> Kirim Permohonan Cuti
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Kalkulator Durasi & Saldo Kuota -->
  <div class="col-lg-5 mb-4">
    <div class="emp-attendance-hero mb-4 text-center">
      <div class="emp-hero-label">Kalkulator Durasi Cuti</div>
      <div class="emp-attendance-clock my-2" id="display-durasi-angka">0 <span style="font-size: 1.2rem; font-weight: 500;">Hari</span></div>
      <p class="small mb-0" style="color: #CCFBF1;" id="display-durasi-teks">Pilih tanggal mulai dan tanggal akhir untuk menghitung durasi.</p>
    </div>

    <div class="emp-card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h6 font-weight-bold m-0">Saldo Cuti (<?php echo htmlspecialchars(isset($mode_kuota) ? $mode_kuota : 'Kombinasi', ENT_QUOTES, 'UTF-8'); ?>)</h2>
        <span class="emp-status emp-status-ok tabular-nums"><?php echo isset($sisa_cuti) ? (int)$sisa_cuti : 12; ?> Hari Tersedia</span>
      </div>
      <div class="card-body">
        <div class="row text-center mb-3">
          <div class="col-4 border-right">
            <div class="small text-muted">Hak Kuota</div>
            <div class="h5 font-weight-bold mb-0 tabular-nums"><?php echo isset($hak_cuti_total) ? (int)$hak_cuti_total : 12; ?></div>
          </div>
          <div class="col-4 border-right">
            <div class="small text-muted">Terpakai</div>
            <div class="h5 font-weight-bold mb-0 tabular-nums"><?php echo isset($cuti_terpakai) ? (int)$cuti_terpakai : 0; ?></div>
          </div>
          <div class="col-4">
            <div class="small text-muted">Sisa Saldo</div>
            <div class="h5 font-weight-bold text-primary mb-0 tabular-nums" id="val-sisa-kuota"><?php echo isset($sisa_cuti) ? (int)$sisa_cuti : 12; ?></div>
          </div>
        </div>

        <?php
          $pct_terpakai = (isset($hak_cuti_total) && $hak_cuti_total > 0) ? round(($cuti_terpakai / $hak_cuti_total) * 100) : 0;
          $bar_color    = ($pct_terpakai >= 80) ? 'bg-danger' : (($pct_terpakai >= 50) ? 'bg-warning' : 'bg-success');
        ?>
        <div class="mb-3">
          <div class="d-flex justify-content-between small mb-1">
            <span class="text-muted">Penggunaan (<?php echo htmlspecialchars(isset($label_periode) ? $label_periode : '', ENT_QUOTES, 'UTF-8'); ?>)</span>
            <span class="font-weight-bold tabular-nums"><?php echo $pct_terpakai; ?>%</span>
          </div>
          <div class="progress" style="height: 8px;">
            <div class="progress-bar <?php echo $bar_color; ?>" role="progressbar" style="width: <?php echo $pct_terpakai; ?>%;" aria-valuenow="<?php echo $pct_terpakai; ?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>

        <?php if (isset($saldo_cuti) && ($saldo_cuti['mode'] == 'Kombinasi' || $saldo_cuti['mode'] == 'Bulanan')) : ?>
          <div class="p-2 px-3 rounded border small mb-2" style="background: var(--emp-surface-alt);">
            Batas bulanan: <strong>maks. <?php echo (int)$saldo_cuti['kuota_bulanan']; ?> hari/bulan</strong>. Sisa bulan ini: <strong><span id="val-sisa-bulanan"><?php echo (int)$saldo_cuti['sisa_bulanan']; ?></span> hari</strong>.
          </div>
        <?php endif; ?>

        <?php if (!empty($saldo_cuti['keterangan_kebijakan'])) : ?>
          <div class="small text-muted mt-2">
            <strong>Kebijakan HRD:</strong> <?php echo htmlspecialchars($saldo_cuti['keterangan_kebijakan'], ENT_QUOTES, 'UTF-8'); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="emp-card p-4">
      <div class="small font-weight-bold text-uppercase text-muted mb-2">Standar Verifikasi</div>
      <ul class="pl-3 small text-muted mb-0" style="line-height: 1.65;">
        <li>Konfirmasi terlebih dahulu ke rekan kerja yang ditunjuk sebagai pengganti shift.</li>
        <li>Lampirkan Surat Keterangan Dokter resmi untuk pengajuan cuti sakit.</li>
        <li>Pengajuan ditelaah oleh HRD dan disahkan oleh Pimpinan Klinik.</li>
      </ul>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var inputMulai  = document.getElementById('tanggal_mulai');
  var inputAkhir  = document.getElementById('tanggal_akhir');
  var selectJenis = document.getElementById('jenis_cuti');
  var dispAngka   = document.getElementById('display-durasi-angka');
  var dispTeks    = document.getElementById('display-durasi-teks');
  var alertBox    = document.getElementById('durasi-alert');
  var alertMsg    = document.getElementById('durasi-alert-msg');
  var btnSubmit   = document.getElementById('btn-submit-cuti');
  var inputFile   = document.getElementById('file_lampiran');
  var fileLabel   = document.getElementById('file_lampiran_label');

  var modeKuota   = '<?php echo isset($mode_kuota) ? $mode_kuota : "Kombinasi"; ?>';
  var sisaTahunan = <?php echo isset($saldo_cuti['sisa_tahunan']) ? (int)$saldo_cuti['sisa_tahunan'] : 12; ?>;
  var sisaBulanan = <?php echo isset($saldo_cuti['sisa_bulanan']) ? (int)$saldo_cuti['sisa_bulanan'] : 5; ?>;
  var maxBulanan  = <?php echo isset($saldo_cuti['kuota_bulanan']) ? (int)$saldo_cuti['kuota_bulanan'] : 5; ?>;
  var maxTahunan  = <?php echo isset($saldo_cuti['kuota_tahunan']) ? (int)$saldo_cuti['kuota_tahunan'] : 12; ?>;

  if (inputFile) {
    inputFile.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        fileLabel.innerText = this.files[0].name;
      } else {
        fileLabel.innerText = 'Pilih file Surat Dokter / Berkas Bukti...';
      }
    });
  }

  function calculateDuration() {
    var valMulai = inputMulai.value;
    var valAkhir = inputAkhir.value;
    var jenis    = selectJenis.value;

    if (!valMulai || !valAkhir) {
      dispAngka.innerHTML = '0 <span style="font-size: 1.2rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Pilih tanggal mulai dan tanggal akhir untuk menghitung durasi.';
      alertBox.classList.add('d-none');
      btnSubmit.removeAttribute('disabled');
      return;
    }

    var dMulai = new Date(valMulai + 'T00:00:00');
    var dAkhir = new Date(valAkhir + 'T00:00:00');
    if (isNaN(dMulai) || isNaN(dAkhir)) return;

    var diffDays = Math.round((dAkhir.getTime() - dMulai.getTime()) / (1000 * 3600 * 24)) + 1;

    if (diffDays < 1) {
      dispAngka.innerHTML = '!';
      dispTeks.innerText = 'Rentang tanggal tidak valid.';
      alertMsg.innerText = 'Tanggal akhir tidak boleh lebih awal dari tanggal mulai cuti.';
      alertBox.className = 'alert alert-danger py-2 small mb-3';
      alertBox.classList.remove('d-none');
      btnSubmit.setAttribute('disabled', 'disabled');
    } else {
      dispAngka.innerHTML = diffDays + ' <span style="font-size: 1.2rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Total durasi permohonan: ' + diffDays + ' hari.';

      if (jenis === 'Tahunan') {
        if ((modeKuota === 'Bulanan' || modeKuota === 'Kombinasi') && diffDays > sisaBulanan) {
          alertMsg.innerText = 'Pengajuan ' + diffDays + ' hari melebihi sisa batas kuota bulanan Anda (' + sisaBulanan + ' hari tersisa dari maks. ' + maxBulanan + ' hari/bulan).';
          alertBox.className = 'alert alert-danger py-2 small mb-3';
          alertBox.classList.remove('d-none');
          btnSubmit.setAttribute('disabled', 'disabled');
        } else if ((modeKuota === 'Tahunan' || modeKuota === 'Kombinasi') && diffDays > sisaTahunan) {
          alertMsg.innerText = 'Pengajuan ' + diffDays + ' hari melebihi sisa hak cuti tahunan Anda (' + sisaTahunan + ' hari tersisa dari ' + maxTahunan + ' hari/tahun).';
          alertBox.className = 'alert alert-danger py-2 small mb-3';
          alertBox.classList.remove('d-none');
          btnSubmit.setAttribute('disabled', 'disabled');
        } else {
          alertBox.classList.add('d-none');
          btnSubmit.removeAttribute('disabled');
        }
      } else {
        alertBox.classList.add('d-none');
        btnSubmit.removeAttribute('disabled');
      }
    }
  }

  inputMulai.addEventListener('change', function() {
    if (this.value) {
      inputAkhir.min = this.value;
      if (inputAkhir.value && inputAkhir.value < this.value) {
        inputAkhir.value = this.value;
      }
    }
    calculateDuration();
  });

  inputAkhir.addEventListener('change', calculateDuration);
  selectJenis.addEventListener('change', calculateDuration);
  calculateDuration();
});
</script>
