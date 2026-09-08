<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Header -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800">
        <i class="fas fa-file-signature text-primary mr-2"></i><?php echo $title; ?>
      </h1>
      <p class="text-muted small mb-0">Isi formulir cuti & delegasi tugas dengan lengkap dan akurat agar siap diverifikasi HRD dan disetujui Direktur Utama.</p>
    </div>
    <div class="mt-3 mt-sm-0">
      <a href="<?php echo base_url('pegawai/cuti'); ?>" class="btn btn-secondary btn-sm px-3 py-2 font-weight-bold shadow-sm rounded-pill">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Riwayat
      </a>
    </div>
  </div>

  <!-- Flash Message Session -->
  <?php echo $this->session->flashdata('pesan'); ?>

  <!-- Two Column Layout: Formulir Kiri + Ringkasan & Kalkulator Kanan -->
  <div class="row">
    
    <!-- Kolom Kiri: Formulir Pengajuan -->
    <div class="col-lg-7 mb-4">
      <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-header py-3 bg-transparent border-bottom d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-pen-fancy mr-2"></i>Formulir Permohonan & Delegasi Tugas
          </h6>
          <span class="badge badge-light border text-muted px-2 py-1 small">
            Standar SOP Klinik Hidayatullah
          </span>
        </div>
        <div class="card-body p-4">
          <form id="formPengajuanCuti" method="POST" action="<?php echo base_url('pegawai/cuti/tambah_aksi'); ?>" enctype="multipart/form-data">
            
            <!-- CSRF Token Protection -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <!-- 1. Rentang Tanggal Cuti -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="font-weight-bold text-gray-800 small">
                    <i class="fas fa-calendar-plus text-info mr-1"></i> Tanggal Mulai <span class="text-danger">*</span>
                  </label>
                  <input type="date" 
                         name="tanggal_mulai" 
                         id="tanggal_mulai" 
                         class="form-control" 
                         required 
                         min="<?php echo date('Y-m-d'); ?>">
                  <small class="form-text text-muted">Awal mulai hari cuti/izin.</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="font-weight-bold text-gray-800 small">
                    <i class="fas fa-calendar-check text-info mr-1"></i> Tanggal Akhir <span class="text-danger">*</span>
                  </label>
                  <input type="date" 
                         name="tanggal_akhir" 
                         id="tanggal_akhir" 
                         class="form-control" 
                         required 
                         min="<?php echo date('Y-m-d'); ?>">
                  <small class="form-text text-muted">Hari terakhir masa cuti/izin.</small>
                </div>
              </div>
            </div>

            <!-- Pesan Peringatan Durasi Realtime -->
            <div id="durasi-alert" class="alert alert-warning py-2 small d-none mb-3">
              <i class="fas fa-exclamation-triangle mr-1"></i> <span id="durasi-alert-msg"></span>
            </div>

            <!-- 2. Jenis Cuti / Izin -->
            <div class="form-group mb-3">
              <label class="font-weight-bold text-gray-800 small">
                <i class="fas fa-layer-group text-info mr-1"></i> Kategori Cuti / Izin <span class="text-danger">*</span>
              </label>
              <select name="jenis_cuti" id="jenis_cuti" class="form-control font-weight-bold text-dark" required>
                <option value="">-- Pilih Kategori Cuti / Izin --</option>
                <option value="Tahunan" data-icon="🏖️">🏖️ Cuti Tahunan (Hak 12 Hari Kerja)</option>
                <option value="Sakit" data-icon="🏥">🏥 Cuti Sakit (Wajib Unggah Surat Dokter/SKD)</option>
                <option value="Melahirkan" data-icon="👶">👶 Cuti Melahirkan (Khusus Pegawai Wanita)</option>
                <option value="Izin Penting" data-icon="⚡">⚡ Izin Khusus / Keperluan Mendesak</option>
              </select>
            </div>

            <!-- 3. Alasan Pengajuan -->
            <div class="form-group mb-3">
              <label class="font-weight-bold text-gray-800 small">
                <i class="fas fa-align-left text-info mr-1"></i> Alasan & Kondisi Pengajuan <span class="text-danger">*</span>
              </label>
              <textarea name="alasan" 
                        id="alasan" 
                        class="form-control" 
                        rows="3" 
                        placeholder="Jelaskan keperluan cuti/kondisi medis secara jelas dan objektif untuk bahan telaah HRD & Direktur Utama..." 
                        required></textarea>
            </div>

            <!-- Section Divider: Delegasi Tugas / Shift Handover -->
            <div class="p-3 my-4 rounded border" style="background-color: #f8fafc; border-left: 4px solid #0284c7 !important;">
              <h6 class="font-weight-bold text-primary mb-2 small text-uppercase" style="letter-spacing: 0.05em;">
                <i class="fas fa-people-arrows mr-1"></i> Pilar 1: Pendelegasian Tugas & Pengganti Shift
              </h6>
              <p class="small text-muted mb-3">
                Direktur Utama mewajibkan adanya rekan kerja yang mem-backup operasional klinik agar pelayanan pasien tetap lancar tanpa hambatan.
              </p>

              <!-- Dropdown Rekan Kerja Pengganti -->
              <div class="form-group mb-3">
                <label class="font-weight-bold text-gray-800 small">
                  Pilih Rekan Kerja Pengganti (*Handover Officer*) <span class="text-danger">*</span>
                </label>
                <select name="nik_pengganti" id="nik_pengganti" class="form-control" required>
                  <option value="">-- Pilih Rekan Pengganti Shift --</option>
                  <?php if (!empty($rekan_kerja)) : ?>
                    <?php foreach ($rekan_kerja as $rk) : ?>
                      <option value="<?php echo $rk->nik; ?>">
                        <?php echo htmlspecialchars($rk->nama_pegawai, ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($rk->jabatan, ENT_QUOTES, 'UTF-8'); ?> (NIK: <?php echo $rk->nik; ?>)
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <!-- Rincian Serah Terima Tugas -->
              <div class="form-group mb-0">
                <label class="font-weight-bold text-gray-800 small">
                  Rincian Tugas & Shift yang Didelegasikan <span class="text-danger">*</span>
                </label>
                <textarea name="tugas_pengganti" 
                          id="tugas_pengganti" 
                          class="form-control" 
                          rows="2" 
                          placeholder="Contoh: Menggantikan shift jaga pagi di Poli Umum, penginputan rekam medis harian, dan monitoring stok obat..." 
                          required></textarea>
                <small class="form-text text-muted">Tuliskan ruang lingkup pekerjaan yang diserahterimakan selama masa cuti.</small>
              </div>
            </div>

            <!-- Section Divider: Bukti Otentik / SKD -->
            <div class="p-3 my-4 rounded border" style="background-color: #f8fafc; border-left: 4px solid #10b981 !important;">
              <h6 class="font-weight-bold text-success mb-2 small text-uppercase" style="letter-spacing: 0.05em;">
                <i class="fas fa-file-medical mr-1"></i> Pilar 2: Upload Berkas Bukti Pendukung / SKD
              </h6>
              <p class="small text-muted mb-3" id="lampiran-keterangan">
                Untuk Cuti Sakit, <strong>wajib mengunggah Surat Keterangan Dokter (SKD)</strong> resmi dengan cap faskes. Untuk cuti lain, berkas pendukung (undangan, surat rujukan) sangat disarankan.
              </p>

              <div class="custom-file mb-2">
                <input type="file" 
                       name="file_lampiran" 
                       id="file_lampiran" 
                       class="custom-file-input" 
                       accept=".jpg,.jpeg,.png,.pdf">
                <label class="custom-file-label text-truncate" id="file_lampiran_label" for="file_lampiran">
                  Pilih file Surat Dokter / Berkas Bukti (JPG, PNG, PDF maks 3MB)...
                </label>
              </div>
              <small class="form-text text-muted">
                Format yang diterima: JPG, PNG, atau PDF. Ukuran berkas maksimal 3MB.
              </small>
            </div>

            <!-- Section Divider: Kontak Darurat & Alamat Cuti -->
            <div class="p-3 my-4 rounded border" style="background-color: #f8fafc; border-left: 4px solid #f59e0b !important;">
              <h6 class="font-weight-bold text-warning mb-2 small text-uppercase" style="letter-spacing: 0.05em;">
                <i class="fas fa-phone-volume mr-1"></i> Pilar 3: Kesiapsiagaan Emergensi Selama Cuti
              </h6>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-gray-800 small">
                      Nomor WhatsApp / HP Aktif Darurat <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="kontak_darurat" 
                           id="kontak_darurat" 
                           class="form-control" 
                           placeholder="Contoh: 081234567890" 
                           required>
                    <small class="form-text text-muted">Wajib bisa dihubungi saat situasi darurat medis.</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label class="font-weight-bold text-gray-800 small">
                      Alamat / Kota Domisili Selama Cuti
                    </label>
                    <input type="text" 
                           name="alamat_cuti" 
                           id="alamat_cuti" 
                           class="form-control" 
                           placeholder="Contoh: Jl. Diponegoro No. 12, Surabaya">
                    <small class="form-text text-muted">Opsional jika berada di luar kota/tempat tinggal biasa.</small>
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-4">

            <!-- Action Buttons -->
            <div class="d-flex align-items-center justify-content-between">
              <a href="<?php echo base_url('pegawai/cuti'); ?>" class="btn btn-light border px-4 py-2 font-weight-bold shadow-sm rounded-pill">
                <i class="fas fa-arrow-left mr-1"></i> Batal
              </a>
              <button type="submit" id="btn-submit-cuti" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm rounded-pill">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Permohonan Cuti
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Live Calculator & Saldo Cuti Tracker -->
    <div class="col-lg-5 mb-4">
      
      <!-- Live Calculation Card -->
      <div class="card border-0 shadow-sm rounded-lg mb-4" style="background: linear-gradient(135deg, #0c2b4d 0%, #1e3a8a 100%); color: #ffffff;">
        <div class="card-body p-4 text-center position-relative overflow-hidden">
          <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; opacity: 0.08; pointer-events: none;">
            <i class="fas fa-calculator"></i>
          </div>

          <span class="badge badge-light text-primary font-weight-bold px-3 py-1 mb-3 rounded-pill text-uppercase" style="letter-spacing: 0.05em; font-size: 0.75rem;">
            <i class="fas fa-stopwatch mr-1"></i> Live Kalkulator Durasi
          </span>

          <h5 class="text-light opacity-80 mb-1" style="font-size: 0.95rem;">Estimasi Hari Cuti yang Diajukan:</h5>
          <div class="display-4 font-weight-bold text-white my-2" id="display-durasi-angka">
            0 <span style="font-size: 1.5rem; font-weight: 500;">Hari</span>
          </div>
          <p class="small text-light opacity-75 mb-0" id="display-durasi-teks">
            Tentukan tanggal mulai dan tanggal akhir untuk menghitung durasi.
          </p>
        </div>
      </div>

      <!-- Widget Audit Hak & Saldo Cuti Tahunan -->
      <!-- Widget Audit Hak & Saldo Cuti -->
      <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-header py-3 bg-transparent border-bottom d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-gray-800">
            <i class="fas fa-wallet text-info mr-2"></i>Saldo Cuti (Mode: <?php echo isset($mode_kuota) ? $mode_kuota : 'Kombinasi'; ?>)
          </h6>
          <span class="badge badge-primary px-2 py-1 font-weight-bold">
            <?php echo isset($sisa_cuti) ? $sisa_cuti : 12; ?> Hari Tersedia
          </span>
        </div>
        <div class="card-body p-4">
          <div class="row text-center mb-3">
            <div class="col-4 border-right">
              <span class="text-muted small d-block">Hak Kuota</span>
              <span class="h5 font-weight-bold text-dark"><?php echo isset($hak_cuti_total) ? $hak_cuti_total : 12; ?></span>
              <span class="small text-muted d-block">Hari</span>
            </div>
            <div class="col-4 border-right">
              <span class="text-muted small d-block">Terpakai</span>
              <span class="h5 font-weight-bold text-warning"><?php echo isset($cuti_terpakai) ? $cuti_terpakai : 0; ?></span>
              <span class="small text-muted d-block">Hari</span>
            </div>
            <div class="col-4">
              <span class="text-muted small d-block">Sisa Saldo</span>
              <span class="h5 font-weight-bold text-success" id="val-sisa-kuota"><?php echo isset($sisa_cuti) ? $sisa_cuti : 12; ?></span>
              <span class="small text-muted d-block">Hari</span>
            </div>
          </div>

          <?php 
            $pct_terpakai = ($hak_cuti_total > 0) ? round(($cuti_terpakai / $hak_cuti_total) * 100) : 0;
            $bar_color = ($pct_terpakai >= 80) ? 'bg-danger' : (($pct_terpakai >= 50) ? 'bg-warning' : 'bg-success');
          ?>
          <div class="mb-3">
            <div class="d-flex justify-content-between small mb-1">
              <span class="text-muted">Penggunaan Kuota (<?php echo isset($label_periode) ? $label_periode : ''; ?>)</span>
              <span class="font-weight-bold text-dark"><?php echo $pct_terpakai; ?>%</span>
            </div>
            <div class="progress" style="height: 8px; border-radius: 4px;">
              <div class="progress-bar <?php echo $bar_color; ?>" role="progressbar" style="width: <?php echo $pct_terpakai; ?>%;" aria-valuenow="<?php echo $pct_terpakai; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>

          <?php if(isset($saldo_cuti) && ($saldo_cuti['mode'] == 'Kombinasi' || $saldo_cuti['mode'] == 'Bulanan')): ?>
            <div class="p-2 rounded bg-light border text-dark small mb-2">
              <i class="fas fa-calendar-day text-info mr-1"></i> Batas Kuota Bulanan: <strong>Maks. <?php echo $saldo_cuti['kuota_bulanan']; ?> hari/bulan</strong>
              <div class="text-muted mt-1" style="font-size: 0.8rem;">
                Bulan ini terpakai: <?php echo $saldo_cuti['cuti_terpakai_bulan']; ?> hari &bull; Sisa jatah bulan ini: <strong><span id="val-sisa-bulanan"><?php echo $saldo_cuti['sisa_bulanan']; ?></span> hari</strong>
              </div>
            </div>
          <?php endif; ?>

          <?php if(!empty($saldo_cuti['keterangan_kebijakan'])): ?>
            <div class="text-muted small mt-2 p-2 border-left-info bg-light rounded" style="border-left: 3px solid #0ea5e9; font-size: 0.82rem;">
              <strong>Kebijakan HRD:</strong> <?php echo htmlspecialchars($saldo_cuti['keterangan_kebijakan']); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Ringkasan Pemohon & SOP -->
      <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-header py-3 bg-transparent border-bottom">
          <h6 class="m-0 font-weight-bold text-gray-800">
            <i class="fas fa-id-card-clip text-info mr-2"></i>Informasi Pemohon
          </h6>
        </div>
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="mr-3">
              <div class="avatar-circle rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                <i class="fas fa-user-tie fa-lg text-primary"></i>
              </div>
            </div>
            <div>
              <h6 class="font-weight-bold text-gray-800 mb-0">
                <?php echo isset($pegawai->nama_pegawai) ? $pegawai->nama_pegawai : $this->session->userdata('nama_pegawai'); ?>
              </h6>
              <span class="badge badge-light border text-muted">
                NIK: <?php echo isset($pegawai->nik) ? $pegawai->nik : $this->session->userdata('nik'); ?>
              </span>
              <span class="badge badge-info ml-1">
                <?php echo isset($pegawai->jabatan) ? $pegawai->jabatan : 'Pegawai'; ?>
              </span>
            </div>
          </div>

          <div class="border-top pt-3">
            <h6 class="font-weight-bold text-gray-800 small mb-2">
              <i class="fas fa-shield-halved text-success mr-1"></i> Standar Akuntabilitas ke Direktur Utama:
            </h6>
            <ul class="pl-3 small text-muted mb-0" style="line-height: 1.6;">
              <li><strong>Rekan Pengganti:</strong> Wajib mengonfirmasi ke rekan yang ditunjuk sebelum mengajukan cuti.</li>
              <li><strong>Surat Keterangan Dokter:</strong> Wajib asli dari faskes/klinik berizin dengan stempel resmi.</li>
              <li><strong>Verifikasi Dua Tingkat:</strong> Pengajuan akan ditelaah oleh HRD terlebih dahulu sebelum diteruskan dan disahkan oleh Direktur Utama.</li>
            </ul>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<!-- /.container-fluid -->

<!-- Live Duration & Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const inputMulai   = document.getElementById('tanggal_mulai');
  const inputAkhir   = document.getElementById('tanggal_akhir');
  const selectJenis  = document.getElementById('jenis_cuti');
  const dispAngka    = document.getElementById('display-durasi-angka');
  const dispTeks     = document.getElementById('display-durasi-teks');
  const alertBox     = document.getElementById('durasi-alert');
  const alertMsg     = document.getElementById('durasi-alert-msg');
  const btnSubmit    = document.getElementById('btn-submit-cuti');
  const inputFile    = document.getElementById('file_lampiran');
  const fileLabel    = document.getElementById('file_lampiran_label');

  // Nilai Kuota dari Backend
  const modeKuota    = '<?php echo isset($mode_kuota) ? $mode_kuota : "Kombinasi"; ?>';
  const sisaTahunan  = <?php echo isset($saldo_cuti['sisa_tahunan']) ? (int)$saldo_cuti['sisa_tahunan'] : 12; ?>;
  const sisaBulanan  = <?php echo isset($saldo_cuti['sisa_bulanan']) ? (int)$saldo_cuti['sisa_bulanan'] : 5; ?>;
  const maxBulanan   = <?php echo isset($saldo_cuti['kuota_bulanan']) ? (int)$saldo_cuti['kuota_bulanan'] : 5; ?>;
  const maxTahunan   = <?php echo isset($saldo_cuti['kuota_tahunan']) ? (int)$saldo_cuti['kuota_tahunan'] : 12; ?>;

  // Update label file saat dipilih
  if (inputFile) {
    inputFile.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        fileLabel.innerText = '📎 ' + this.files[0].name;
      } else {
        fileLabel.innerText = 'Pilih file Surat Dokter / Berkas Bukti (JPG, PNG, PDF maks 3MB)...';
      }
    });
  }

  function calculateDuration() {
    const valMulai = inputMulai.value;
    const valAkhir = inputAkhir.value;
    const jenis    = selectJenis.value;

    if (!valMulai || !valAkhir) {
      dispAngka.innerHTML = '0 <span style="font-size: 1.5rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Tentukan tanggal mulai dan tanggal akhir untuk menghitung durasi.';
      alertBox.classList.add('d-none');
      btnSubmit.removeAttribute('disabled');
      return;
    }

    const dMulai = new Date(valMulai + 'T00:00:00');
    const dAkhir = new Date(valAkhir + 'T00:00:00');

    if (isNaN(dMulai) || isNaN(dAkhir)) {
      return;
    }

    const diffTime = dAkhir.getTime() - dMulai.getTime();
    const diffDays = Math.round(diffTime / (1000 * 3600 * 24)) + 1;

    if (diffDays < 1) {
      dispAngka.innerHTML = '<span class="text-warning">!</span>';
      dispTeks.innerText = 'Rentang tanggal tidak valid.';
      alertMsg.innerText = 'Tanggal akhir tidak boleh lebih awal dari tanggal mulai cuti!';
      alertBox.classList.remove('d-none');
      alertBox.className = 'alert alert-danger py-2 small mb-3';
      btnSubmit.setAttribute('disabled', 'disabled');
    } else {
      dispAngka.innerHTML = diffDays + ' <span style="font-size: 1.5rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Total durasi permohonan: ' + diffDays + ' hari kerja.';
      
      // Validasi kuota jika cuti tahunan
      if (jenis === 'Tahunan') {
        if ((modeKuota === 'Bulanan' || modeKuota === 'Kombinasi') && diffDays > sisaBulanan) {
          alertMsg.innerText = 'Peringatan: Pengajuan ' + diffDays + ' hari melebihi sisa batas kuota bulanan Anda (' + sisaBulanan + ' hari tersisa dari batas maks. ' + maxBulanan + ' hari/bulan). Mohon sesuaikan durasi.';
          alertBox.className = 'alert alert-danger py-2 small mb-3';
          alertBox.classList.remove('d-none');
          btnSubmit.setAttribute('disabled', 'disabled');
        } else if ((modeKuota === 'Tahunan' || modeKuota === 'Kombinasi') && diffDays > sisaTahunan) {
          alertMsg.innerText = 'Peringatan: Pengajuan ' + diffDays + ' hari melebihi sisa hak cuti tahunan Anda (' + sisaTahunan + ' hari tersisa dari kuota ' + maxTahunan + ' hari/tahun). Mohon sesuaikan durasi.';
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

  // Inisialisasi awal
  calculateDuration();
});
</script>
