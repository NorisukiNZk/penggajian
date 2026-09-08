<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Header -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 font-weight-bold text-gray-800">
        <i class="fas fa-file-signature text-primary mr-2"></i><?php echo $title; ?>
      </h1>
      <p class="text-muted small mb-0">Isi formulir berikut dengan teliti untuk mengajukan permohonan cuti atau izin kerja.</p>
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
        <div class="card-header py-3 bg-transparent border-bottom">
          <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-pen-fancy mr-2"></i>Formulir Permohonan Cuti / Izin
          </h6>
        </div>
        <div class="card-body p-4">
          <form id="formPengajuanCuti" method="POST" action="<?php echo base_url('pegawai/cuti/tambah_aksi'); ?>">
            
            <!-- CSRF Token Protection -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <!-- Tanggal Mulai & Tanggal Akhir -->
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

            <!-- Jenis Cuti / Izin -->
            <div class="form-group mb-3">
              <label class="font-weight-bold text-gray-800 small">
                <i class="fas fa-layer-group text-info mr-1"></i> Jenis Cuti / Izin <span class="text-danger">*</span>
              </label>
              <select name="jenis_cuti" id="jenis_cuti" class="form-control" required>
                <option value="">-- Pilih Kategori Cuti / Izin --</option>
                <option value="Tahunan">🏖️ Cuti Tahunan (Hak Cuti Tahunan Pegawai)</option>
                <option value="Sakit">🏥 Cuti Sakit (Disertai Surat Dokter)</option>
                <option value="Melahirkan">👶 Cuti Melahirkan (Khusus Pegawai Wanita)</option>
                <option value="Izin Penting">⚡ Izin Khusus / Keperluan Mendesak</option>
              </select>
            </div>

            <!-- Alasan Pengajuan -->
            <div class="form-group mb-4">
              <label class="font-weight-bold text-gray-800 small">
                <i class="fas fa-align-left text-info mr-1"></i> Alasan / Keterangan Lengkap <span class="text-danger">*</span>
              </label>
              <textarea name="alasan" 
                        id="alasan" 
                        class="form-control" 
                        rows="4" 
                        placeholder="Contoh: Mengambil hak cuti tahunan untuk acara keluarga di luar kota / Menjalani rawat jalan..." 
                        required></textarea>
              <small class="form-text text-muted">Jelaskan keperluan dan kondisi secara jelas untuk pertimbangan persetujuan HRD.</small>
            </div>

            <hr class="my-4">

            <!-- Action Buttons -->
            <div class="d-flex align-items-center justify-content-between">
              <a href="<?php echo base_url('pegawai/cuti'); ?>" class="btn btn-light border px-4 py-2 font-weight-bold shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Batal
              </a>
              <button type="submit" id="btn-submit-cuti" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Permohonan Cuti
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Live Calculator & Info Pemohon -->
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
            Silakan tentukan tanggal mulai dan tanggal akhir untuk menghitung durasi.
          </p>
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
              <i class="fas fa-info-circle text-warning mr-1"></i> Ketentuan Pengajuan Cuti:
            </h6>
            <ul class="pl-3 small text-muted mb-0" style="line-height: 1.6;">
              <li>Permohonan cuti tahunan disarankan diajukan minimal <strong>3 hari sebelumnya</strong>.</li>
              <li>Untuk cuti sakit lebih dari 2 hari, wajib menyerahkan surat keterangan dokter saat kembali bekerja.</li>
              <li>Sistem secara otomatis mencegah pengajuan bertumpuk (*anti-overlap*) pada periode yang sama.</li>
              <li>Persetujuan akan diverifikasi langsung oleh Admin / HRD melalui dashboard manajemen cuti.</li>
            </ul>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<!-- /.container-fluid -->

<!-- Live Duration Calculation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const inputMulai  = document.getElementById('tanggal_mulai');
  const inputAkhir  = document.getElementById('tanggal_akhir');
  const dispAngka   = document.getElementById('display-durasi-angka');
  const dispTeks    = document.getElementById('display-durasi-teks');
  const alertBox    = document.getElementById('durasi-alert');
  const alertMsg    = document.getElementById('durasi-alert-msg');
  const btnSubmit   = document.getElementById('btn-submit-cuti');

  function calculateDuration() {
    const valMulai = inputMulai.value;
    const valAkhir = inputAkhir.value;

    if (!valMulai || !valAkhir) {
      dispAngka.innerHTML = '0 <span style="font-size: 1.5rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Silakan tentukan tanggal mulai dan tanggal akhir untuk menghitung durasi.';
      alertBox.classList.add('d-none');
      btnSubmit.removeAttribute('disabled');
      return;
    }

    const dMulai = new Date(valMulai + 'T00:00:00');
    const dAkhir = new Date(valAkhir + 'T00:00:00');

    if (isNaN(dMulai) || isNaN(dAkhir)) {
      return;
    }

    // Hitung selisih hari inklusif (tanggal_mulai s/d tanggal_akhir)
    const diffTime = dAkhir.getTime() - dMulai.getTime();
    const diffDays = Math.round(diffTime / (1000 * 3600 * 24)) + 1;

    if (diffDays < 1) {
      dispAngka.innerHTML = '<span class="text-warning">!</span>';
      dispTeks.innerText = 'Rentang tanggal tidak valid.';
      alertMsg.innerText = 'Tanggal akhir tidak boleh lebih awal dari tanggal mulai cuti!';
      alertBox.classList.remove('d-none');
      btnSubmit.setAttribute('disabled', 'disabled');
    } else {
      dispAngka.innerHTML = diffDays + ' <span style="font-size: 1.5rem; font-weight: 500;">Hari</span>';
      dispTeks.innerText = 'Total durasi permohonan: ' + diffDays + ' hari kalender.';
      alertBox.classList.add('d-none');
      btnSubmit.removeAttribute('disabled');
    }
  }

  // Auto update minimum tanggal akhir saat tanggal mulai dipilih
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

  // Inisialisasi awal
  calculateDuration();
});
</script>
