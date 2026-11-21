<section class="exec-brief-head">
  <div>
    <h1 class="exec-brief-title">Keamanan & Kata Sandi</h1>
    <p class="exec-brief-sub">Perbarui kata sandi akun Pimpinan secara berkala untuk menjaga kerahasiaan otorisasi dan laporan klinik.</p>
  </div>
</section>

<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <?php echo $this->session->flashdata('pesan'); ?>

    <div class="exec-panel">
      <div class="exec-panel-header">
        <h2 class="exec-panel-title">Formulir Pembaruan Kata Sandi</h2>
      </div>
      <div class="exec-panel-body">
        <form method="POST" action="<?php echo base_url('pimpinan/ganti_password/ganti_password_aksi'); ?>">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label for="passLama" class="small font-weight-bold">Kata Sandi Saat Ini</label>
            <div class="input-group">
              <input type="password" name="passLama" id="passLama" class="form-control" placeholder="Masukkan kata sandi saat ini" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-exec-outline toggle-pw" data-target="#passLama" aria-label="Tampilkan kata sandi lama">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <?php echo form_error('passLama', '<div class="small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group">
            <label for="passBaru" class="small font-weight-bold">Kata Sandi Baru</label>
            <div class="input-group">
              <input type="password" name="passBaru" id="passBaru" class="form-control" placeholder="Minimal 8 karakter dengan huruf & angka" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-exec-outline toggle-pw" data-target="#passBaru" aria-label="Tampilkan kata sandi baru">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <?php echo form_error('passBaru', '<div class="small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="form-group mb-4">
            <label for="ulangPass" class="small font-weight-bold">Konfirmasi Kata Sandi Baru</label>
            <div class="input-group">
              <input type="password" name="ulangPass" id="ulangPass" class="form-control" placeholder="Ulangi kata sandi baru" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-exec-outline toggle-pw" data-target="#ulangPass" aria-label="Tampilkan konfirmasi kata sandi">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <small id="matchMsg" class="form-text mt-1"></small>
            <?php echo form_error('ulangPass', '<div class="small text-danger mt-1">', '</div>'); ?>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo base_url('pimpinan/dashboard'); ?>" class="btn btn-exec-outline btn-sm">Kembali</a>
            <button type="submit" class="btn btn-exec-primary btn-sm">
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
  document.querySelectorAll('.toggle-pw').forEach(function(btn) {
    btn.addEventListener('click', function() {
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

  var p1 = document.getElementById('passBaru');
  var p2 = document.getElementById('ulangPass');
  var msg = document.getElementById('matchMsg');
  function check() {
    if (!p2.value) { msg.textContent = ''; return; }
    if (p1.value === p2.value) {
      msg.textContent = 'Kata sandi cocok.';
      msg.className = 'form-text text-success font-weight-bold mt-1';
    } else {
      msg.textContent = 'Konfirmasi kata sandi belum cocok.';
      msg.className = 'form-text text-danger mt-1';
    }
  }
  if (p1 && p2) {
    p1.addEventListener('input', check);
    p2.addEventListener('input', check);
  }
});
</script>
