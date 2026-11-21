<section class="emp-page-head">
  <div>
    <h1 class="emp-page-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="emp-page-sub">Perbarui kata sandi login Anda secara berkala untuk menjaga keamanan data kepegawaian.</p>
  </div>
</section>

<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <?php echo $this->session->flashdata('pesan'); ?>

    <div class="emp-card">
      <div class="card-header">
        <h2 class="h6 font-weight-bold m-0">Pembaruan Kata Sandi Akun</h2>
      </div>
      <div class="card-body">
        <form method="POST" action="<?php echo base_url('pegawai/ganti_password/ganti_password_aksi'); ?>">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label for="passLama" class="small font-weight-bold">Kata Sandi Lama</label>
            <div class="input-group">
              <input type="password" name="passLama" id="passLama" class="form-control" placeholder="Masukkan kata sandi saat ini" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-light toggle-password" data-target="#passLama" aria-label="Tampilkan kata sandi lama">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <?php echo form_error('passLama', '<div class="small text-danger mt-1">', '</div>'); ?>
          </div>

          <hr class="my-3">

          <div class="form-group">
            <label for="passBaru" class="small font-weight-bold">Kata Sandi Baru <span class="text-muted font-weight-normal">(Min. 8 karakter)</span></label>
            <div class="input-group">
              <input type="password" name="passBaru" id="passBaru" class="form-control" placeholder="Buat kata sandi baru minimal 8 karakter" minlength="8" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-light toggle-password" data-target="#passBaru" aria-label="Tampilkan kata sandi baru">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <?php echo form_error('passBaru', '<div class="small text-danger mt-1">', '</div>'); ?>

            <div class="progress mt-2" style="height: 6px; display: none;" id="strengthMeterContainer">
              <div class="progress-bar" id="strengthMeter" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small id="strengthText" class="form-text text-muted mt-1" style="display: none;"></small>
          </div>

          <div class="form-group mb-4">
            <label for="ulangPass" class="small font-weight-bold">Konfirmasi Kata Sandi Baru</label>
            <div class="input-group">
              <input type="password" name="ulangPass" id="ulangPass" class="form-control" placeholder="Ulangi kata sandi baru" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-light toggle-password" data-target="#ulangPass" aria-label="Tampilkan konfirmasi kata sandi">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <small id="matchMessage" class="form-text mt-1"></small>
            <?php echo form_error('ulangPass', '<div class="small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo base_url('pegawai/dashboard'); ?>" class="btn btn-light btn-sm">Kembali</a>
            <button type="submit" class="btn btn-primary" id="btnSubmit">
              <i class="fas fa-shield-halved"></i> Simpan Kata Sandi Baru
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.toggle-password').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
      var input = document.querySelector(this.getAttribute('data-target'));
      var icon  = this.querySelector('i');
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    });
  });

  var passBaru          = document.getElementById('passBaru');
  var strengthContainer = document.getElementById('strengthMeterContainer');
  var strengthMeter     = document.getElementById('strengthMeter');
  var strengthText      = document.getElementById('strengthText');
  var ulangPass         = document.getElementById('ulangPass');
  var matchMessage      = document.getElementById('matchMessage');

  function checkMatch() {
    if (ulangPass.value.length > 0) {
      if (passBaru.value === ulangPass.value) {
        matchMessage.textContent = 'Kata sandi cocok.';
        matchMessage.className = 'form-text text-success font-weight-bold mt-1';
      } else {
        matchMessage.textContent = 'Konfirmasi kata sandi tidak cocok.';
        matchMessage.className = 'form-text text-danger mt-1';
      }
    } else {
      matchMessage.textContent = '';
    }
  }

  if (passBaru) {
    passBaru.addEventListener('input', function() {
      var val = passBaru.value;
      if (val.length > 0) {
        strengthContainer.style.display = 'flex';
        strengthText.style.display = 'block';
        var strength = 0;
        if (val.length > 5) strength += 20;
        if (val.length > 7) strength += 20;
        if (/[A-Z]/.test(val)) strength += 20;
        if (/[0-9]/.test(val)) strength += 20;
        if (/[^a-zA-Z0-9]/.test(val)) strength += 20;
        strengthMeter.style.width = strength + '%';
        if (strength <= 40) {
          strengthMeter.className = 'progress-bar bg-danger';
          strengthText.textContent = 'Lemah: tambahkan angka dan huruf besar.';
          strengthText.className = 'form-text text-danger mt-1';
        } else if (strength <= 80) {
          strengthMeter.className = 'progress-bar bg-warning';
          strengthText.textContent = 'Sedang: cukup baik, tambahkan simbol agar makin aman.';
          strengthText.className = 'form-text text-warning mt-1';
        } else {
          strengthMeter.className = 'progress-bar bg-success';
          strengthText.textContent = 'Kuat: kombinasi kata sandi aman.';
          strengthText.className = 'form-text text-success mt-1';
        }
      } else {
        strengthContainer.style.display = 'none';
        strengthText.style.display = 'none';
      }
      checkMatch();
    });
  }

  if (ulangPass) {
    ulangPass.addEventListener('input', checkMatch);
  }
});
</script>
