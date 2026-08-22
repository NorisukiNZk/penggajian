<!-- Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">

          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Chart script initialization moved to specific view -->

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top', // Top Down notification
      showConfirmButton: false,
      timer: 3500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });

    <?php if($this->session->flashdata('welcome_msg')): ?>
        Toast.fire({
          icon: 'info',
          title: '<?php echo $this->session->flashdata("welcome_msg"); ?>',
          iconColor: 'white',
          background: '#36b9cc',
          color: 'white'
        });
    <?php endif; ?>

    if ($('.alert-success').length > 0) {
        var msg = $('.alert-success').text().replace('×', '').replace('Berhasil!', '').replace('Sync API Berhasil!', '').trim();
        $('.alert-success').remove();
        Toast.fire({
            icon: 'success',
            title: 'Berhasil',
            text: msg,
            iconColor: 'white',
            background: '#1cc88a',
            color: 'white'
        });
    }

    if ($('.alert-danger').length > 0) {
        var msg = $('.alert-danger').text().replace('×', '').replace('Gagal!', '').trim();
        if (msg === "") msg = "Terjadi Kesalahan / Ditolak";
        $('.alert-danger').remove();
        Toast.fire({
            icon: 'error',
            title: 'Oops!',
            text: msg,
            iconColor: 'white',
            background: '#e74a3b',
            color: 'white'
        });
    }

    // 1. Konfirmasi Hapus Data Modern (SweetAlert2)
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const nama = $(this).data('nama') || 'data ini';

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            html: `Data <b>"${nama}"</b> akan dihapus permanen dari sistem!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus Data!',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });

    // 2. Konfirmasi Aksi Umum (Setujui / Tolak / Sinkronisasi)
    $(document).on('click', '.btn-konfirmasi', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const form = $(this).closest('form');
        const judul = $(this).data('judul') || 'Konfirmasi Aksi';
        const pesan = $(this).data('pesan') || 'Apakah Anda yakin ingin melanjutkan proses ini?';
        const tipe = $(this).data('tipe') || 'question';
        const warnaBtn = $(this).data('warna') || '#4e73df';
        const teksBtn = $(this).data('btn-teks') || 'Ya, Lanjutkan!';

        Swal.fire({
            title: judul,
            text: pesan,
            icon: tipe,
            showCancelButton: true,
            confirmButtonColor: warnaBtn,
            cancelButtonColor: '#858796',
            confirmButtonText: teksBtn,
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (href) {
                    document.location.href = href;
                } else if (form.length) {
                    form.submit();
                }
            }
        });
    });
});
</script>

<script>
  // Dark Mode Logic
  const darkModeToggle = document.getElementById('darkModeToggle');
  const darkModeIcon = document.getElementById('darkModeIcon');
  const body = document.body;

  if (localStorage.getItem('darkMode') === 'enabled') {
      body.classList.add('dark-mode');
      darkModeIcon.classList.remove('fa-moon');
      darkModeIcon.classList.add('fa-sun', 'text-warning');
      darkModeIcon.classList.remove('text-light');
  }

  darkModeToggle.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      if (body.classList.contains('dark-mode')) {
          localStorage.setItem('darkMode', 'enabled');
          darkModeIcon.classList.remove('fa-moon', 'text-light');
          darkModeIcon.classList.add('fa-sun', 'text-warning');
      } else {
          localStorage.setItem('darkMode', 'disabled');
          darkModeIcon.classList.remove('fa-sun', 'text-warning');
          darkModeIcon.classList.add('fa-moon', 'text-light');
      }
  });

  // Preloader Fade Out
  window.addEventListener('load', function() {
      // Fix Sidebar on Mobile
      if ($(window).width() <= 768) {
          $("body").addClass("sidebar-toggled");
          $(".sidebar").addClass("toggled");
      }
      
      setTimeout(function() {
          var preloader = document.getElementById('preloader');
          if (preloader) {
              preloader.style.opacity = '0';
              setTimeout(function() { preloader.style.display = 'none'; }, 500);
          }
      }, 300); // 300ms delay for smoothness
  });

  // Live Digital Clock
  function updateLiveClock() {
      var now = new Date();
      var h = String(now.getHours()).padStart(2, '0');
      var m = String(now.getMinutes()).padStart(2, '0');
      var s = String(now.getSeconds()).padStart(2, '0');
      var clockEl = document.getElementById('live-clock');
      if (clockEl) {
          clockEl.innerHTML = '<i class="fas fa-clock text-info"></i> ' + h + ':' + m + ':' + s + ' WITA';
      }
  }
  setInterval(updateLiveClock, 1000);
  updateLiveClock(); // initial call
</script>

</body>

</html>