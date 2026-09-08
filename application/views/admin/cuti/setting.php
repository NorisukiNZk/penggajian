<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-sliders-h text-primary mr-2"></i><?php echo $title ?>
            </h1>
            <p class="text-muted small mb-0">Kelola dan tentukan batas kuota hak cuti pegawai secara dinamis (tahunan, bulanan, atau kombinasi).</p>
        </div>
        <div>
            <a href="<?php echo base_url('admin/data_cuti') ?>" class="btn btn-sm btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Daftar Cuti
            </a>
        </div>
    </div>

    <?php echo $this->session->flashdata('pesan'); ?>

    <div class="row">
        <!-- Form Kolom Kiri -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header py-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cog mr-1"></i> Formulir Kebijakan Kuota Cuti
                    </h6>
                    <span class="badge badge-info px-3 py-1 font-weight-bold">GLOBAL SETTING</span>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?php echo base_url('admin/data_cuti/update_setting') ?>">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <!-- Pilihan Mode Kuota -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-800 small mb-2">
                                Mode Skema Kuota Cuti <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="custom-control custom-radio card p-3 border h-100 shadow-none hover-border-primary" style="border-radius: 12px; cursor: pointer;">
                                        <input type="radio" id="modeKombinasi" name="mode_kuota_cuti" value="Kombinasi" class="custom-control-input" <?php echo ($setting->mode_kuota_cuti == 'Kombinasi') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label font-weight-bold text-dark w-100" for="modeKombinasi" style="cursor: pointer;">
                                            Kombinasi <span class="badge badge-success small ml-1">Saran</span>
                                            <span class="d-block text-muted small font-weight-normal mt-1">Kuota tahunan dibatasi maksimal ambil per bulan.</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="custom-control custom-radio card p-3 border h-100 shadow-none hover-border-primary" style="border-radius: 12px; cursor: pointer;">
                                        <input type="radio" id="modeBulanan" name="mode_kuota_cuti" value="Bulanan" class="custom-control-input" <?php echo ($setting->mode_kuota_cuti == 'Bulanan') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label font-weight-bold text-dark w-100" for="modeBulanan" style="cursor: pointer;">
                                            Bulanan
                                            <span class="d-block text-muted small font-weight-normal mt-1">Jatah dihitung dan direset murni per bulan kalender.</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="custom-control custom-radio card p-3 border h-100 shadow-none hover-border-primary" style="border-radius: 12px; cursor: pointer;">
                                        <input type="radio" id="modeTahunan" name="mode_kuota_cuti" value="Tahunan" class="custom-control-input" <?php echo ($setting->mode_kuota_cuti == 'Tahunan') ? 'checked' : ''; ?>>
                                        <label class="custom-control-label font-weight-bold text-dark w-100" for="modeTahunan" style="cursor: pointer;">
                                            Tahunan
                                            <span class="d-block text-muted small font-weight-normal mt-1">Jatah dihitung total 1 tahun kalender penuh.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Input Nilai Kuota -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3" id="wrapperTahunan">
                                <label class="font-weight-bold text-gray-800 small mb-1">
                                    <i class="fas fa-calendar-alt text-primary mr-1"></i> Jatah Kuota Tahunan
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="kuota_cuti_tahunan" id="inputTahunan" value="<?php echo $setting->kuota_cuti_tahunan; ?>" min="1" max="100" required style="border-radius: 10px 0 0 10px;">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light small font-weight-bold" style="border-radius: 0 10px 10px 0;">Hari / Tahun</span>
                                    </div>
                                </div>
                                <small class="text-muted">Total hak cuti tahunan pegawai (standar: 12 hari).</small>
                            </div>

                            <div class="col-md-6 mb-3" id="wrapperBulanan">
                                <label class="font-weight-bold text-gray-800 small mb-1">
                                    <i class="fas fa-calendar-day text-info mr-1"></i> Batas Kuota Bulanan
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="kuota_cuti_bulanan" id="inputBulanan" value="<?php echo $setting->kuota_cuti_bulanan; ?>" min="1" max="31" required style="border-radius: 10px 0 0 10px;">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light small font-weight-bold" style="border-radius: 0 10px 10px 0;">Hari / Bulan</span>
                                    </div>
                                </div>
                                <small class="text-muted">Batas maksimal pengambilan per bulan (misal: 5 hari).</small>
                            </div>
                        </div>

                        <!-- Keterangan Kebijakan -->
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-800 small mb-1">
                                Catatan Kebijakan HRD / Penjelasan Pegawai
                            </label>
                            <textarea class="form-control" name="keterangan_kebijakan" id="inputKeterangan" rows="3" style="border-radius: 10px;" placeholder="Tuliskan catatan kebijakan atau ketentuan khusus permohonan cuti..."><?php echo htmlspecialchars($setting->keterangan_kebijakan); ?></textarea>
                            <small class="text-muted">Catatan ini akan tampil sebagai panduan di halaman pengajuan cuti pegawai.</small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end align-items-center">
                            <a href="<?php echo base_url('admin/data_cuti') ?>" class="btn btn-light font-weight-bold mr-2 px-4 py-2" style="border-radius: 10px;">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 10px;">
                                <i class="fas fa-save mr-1"></i> Simpan Pengaturan Kuota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Live Simulation & Preview -->
        <div class="col-lg-5 mb-4">
            
            <!-- Live Preview Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; background: linear-gradient(135deg, #0c2b4d 0%, #174270 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge badge-pill badge-light text-primary font-weight-bold px-3 py-1">
                            <i class="fas fa-eye mr-1"></i> SIMULASI ATURAN LIVE
                        </span>
                        <i class="fas fa-shield-alt fa-lg text-info opacity-75"></i>
                    </div>
                    <h5 class="font-weight-bold text-white mb-2" id="previewJudulMode">
                        Mode: <?php echo $setting->mode_kuota_cuti; ?>
                    </h5>
                    <p class="text-light small opacity-90 mb-3" id="previewDeskripsiMode" style="line-height: 1.6;">
                        Memuat simulasi...
                    </p>

                    <div class="bg-white text-dark p-3 rounded shadow-sm" style="border-radius: 12px !important;">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="small text-muted font-weight-bold">Batas Maksimal Pengajuan:</span>
                            <span class="font-weight-bold text-primary" id="previewBatasHari">
                                <?php echo ($setting->mode_kuota_cuti == 'Bulanan') ? $setting->kuota_cuti_bulanan . ' Hari / Bulan' : $setting->kuota_cuti_tahunan . ' Hari / Tahun'; ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="small text-muted font-weight-bold">Batas Per Bulan:</span>
                            <span class="font-weight-bold text-info" id="previewBatasBulanan">
                                <?php echo ($setting->mode_kuota_cuti == 'Tahunan') ? 'Tidak Dibatasi' : 'Maks. ' . $setting->kuota_cuti_bulanan . ' Hari'; ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted font-weight-bold">Aksi Sistem Jika Melebihi:</span>
                            <span class="badge badge-danger px-2 py-1">Tolak Otomatis</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Edukasi Skema -->
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-info-circle text-info mr-1"></i> Penjelasan Skema Kebijakan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="media mb-3">
                        <div class="mr-3 text-success">
                            <i class="fas fa-check-double fa-lg"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 font-weight-bold small text-dark mb-1">Skema Kombinasi (Sangat Dianjurkan)</h6>
                            <p class="text-muted small mb-0">Pegawai memiliki hak cuti 12 hari setahun, namun diatur agar dalam 1 bulan kalender maksimal hanya boleh mengambil 5 hari kerja. Sangat ideal bagi klinik agar pelayanan pasien tetap berjalan normal.</p>
                        </div>
                    </div>

                    <div class="media mb-3">
                        <div class="mr-3 text-info">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 font-weight-bold small text-dark mb-1">Skema Bulanan</h6>
                            <p class="text-muted small mb-0">Pegawai dijatah kuota tetap per bulan (misal 5 hari/bulan). Pada pergantian bulan baru, sisa kuota bulan lalu di-reset kembali ke nilai awal.</p>
                        </div>
                    </div>

                    <div class="media">
                        <div class="mr-3 text-secondary">
                            <i class="fas fa-calendar fa-lg"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 font-weight-bold small text-dark mb-1">Skema Tahunan Murni</h6>
                            <p class="text-muted small mb-0">Pegawai bebas menggunakan kuota tahunannya (misal 12 hari) kapan saja tanpa pembatasan bulanan sepanjang sisa kuota tahun berjalan masih mencukupi.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioModes = document.querySelectorAll('input[name="mode_kuota_cuti"]');
    const inputTahunan = document.getElementById('inputTahunan');
    const inputBulanan = document.getElementById('inputBulanan');
    const previewJudulMode = document.getElementById('previewJudulMode');
    const previewDeskripsiMode = document.getElementById('previewDeskripsiMode');
    const previewBatasHari = document.getElementById('previewBatasHari');
    const previewBatasBulanan = document.getElementById('previewBatasBulanan');
    const wrapperTahunan = document.getElementById('wrapperTahunan');
    const wrapperBulanan = document.getElementById('wrapperBulanan');

    function updatePreview() {
        let selectedMode = 'Kombinasi';
        radioModes.forEach(r => {
            if (r.checked) selectedMode = r.value;
        });

        const tahunanVal = inputTahunan.value || 12;
        const bulananVal = inputBulanan.value || 5;

        previewJudulMode.textContent = 'Mode Aktif: ' + selectedMode;

        if (selectedMode === 'Kombinasi') {
            wrapperTahunan.style.opacity = '1';
            wrapperBulanan.style.opacity = '1';
            previewDeskripsiMode.innerHTML = 'Pegawai mendapatkan hak cuti <strong>' + tahunanVal + ' hari/tahun</strong>, dengan pembatasan maksimal pengambilan <strong>' + bulananVal + ' hari per bulan</strong>.';
            previewBatasHari.textContent = tahunanVal + ' Hari / Tahun';
            previewBatasBulanan.textContent = 'Maks. ' + bulananVal + ' Hari / Bln';
        } else if (selectedMode === 'Bulanan') {
            wrapperTahunan.style.opacity = '0.5';
            wrapperBulanan.style.opacity = '1';
            previewDeskripsiMode.innerHTML = 'Pegawai mendapatkan jatah <strong>' + bulananVal + ' hari per bulan</strong>. Kuota akan dihitung dan di-reset setiap pergantian bulan kalender.';
            previewBatasHari.textContent = bulananVal + ' Hari / Bulan';
            previewBatasBulanan.textContent = 'Maks. ' + bulananVal + ' Hari';
        } else if (selectedMode === 'Tahunan') {
            wrapperTahunan.style.opacity = '1';
            wrapperBulanan.style.opacity = '0.5';
            previewDeskripsiMode.innerHTML = 'Pegawai mendapatkan total hak cuti <strong>' + tahunanVal + ' hari per tahun</strong>. Tidak ada batasan per bulan.';
            previewBatasHari.textContent = tahunanVal + ' Hari / Tahun';
            previewBatasBulanan.textContent = 'Bebas (Tidak Dibatasi)';
        }
    }

    radioModes.forEach(r => r.addEventListener('change', updatePreview));
    inputTahunan.addEventListener('input', updatePreview);
    inputBulanan.addEventListener('input', updatePreview);

    updatePreview();
});
</script>
