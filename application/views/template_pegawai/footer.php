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

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>

<!-- Modern Chart.js v4.4+ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<!-- Modern DataTables 2.x -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
$(document).ready(function() {
  if ($.fn.DataTable && $('#dataTable').length > 0) {
    $('#dataTable').DataTable({
      responsive: true,
      pageLength: 10,
      language: {
        search: "",
        searchPlaceholder: "🔍 Cari data...",
        lengthMenu: "Tampilkan _MENU_ baris",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
        infoEmpty: "Menampilkan 0 entri",
        infoFiltered: "(filter dari _MAX_ total data)",
        zeroRecords: "Data tidak ditemukan",
        paginate: {
          first: '<i class="fas fa-angles-left"></i>',
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>',
          last: '<i class="fas fa-angles-right"></i>'
        }
      }
    });
  }

  // Chart handlers with v4 syntax if canvas exists
  var ctxPie = document.getElementById("myPieChart");
  if (ctxPie) {
    new Chart(ctxPie, {
      type: 'doughnut',
      data: {
        labels: ["HRD", "Manager", "Staff Marketing", "Direktur"],
        datasets: [{
          data: [
            <?php echo $this->db->query("select jabatan from data_pegawai where jabatan='HRD'")->num_rows(); ?>,
            <?php echo $this->db->query("select jabatan from data_pegawai where jabatan='Manager'")->num_rows(); ?>,
            <?php echo $this->db->query("select jabatan from data_pegawai where jabatan='Staff Marketing'")->num_rows(); ?>,
            <?php echo $this->db->query("select jabatan from data_pegawai where jabatan='Direktur'")->num_rows(); ?>
          ],
          backgroundColor: ['#0c2b4d', '#0ea5e9', '#10b981', '#f59e0b'],
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        cutout: '75%'
      }
    });
  }

  var ctxBar = document.getElementById("myBarChart");
  if (ctxBar) {
    new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: ["Laki - Laki", "Perempuan"],
        datasets: [{
          label: "Jenis Kelamin",
          backgroundColor: ['#0ea5e9', '#ec4899'],
          borderRadius: 8,
          data: [
            <?php echo $this->db->query("select jenis_kelamin from data_pegawai where jenis_kelamin='Laki-laki'")->num_rows(); ?>,
            <?php echo $this->db->query("select jenis_kelamin from data_pegawai where jenis_kelamin='Perempuan'")->num_rows(); ?>
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }
});
</script>


<!-- Modern SweetAlert2 v11.17+ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    function isDarkMode() {
        return document.body.classList.contains('dark-mode');
    }

    // Modern Toast Mixin with Animate.css
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500,
      timerProgressBar: true,
      showClass: {
        popup: 'animate__animated animate__fadeInDown animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp animate__faster'
      },
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
    });

    // Welcome Greeting Toast
    <?php if($this->session->flashdata('welcome_msg')): ?>
        Toast.fire({
          icon: 'info',
          title: '<?php echo $this->session->flashdata("welcome_msg"); ?>',
          background: isDarkMode() ? '#1e293b' : '#ffffff',
          color: isDarkMode() ? '#f8fafc' : '#0f172a'
        });
    <?php endif; ?>

    // Success Flashdata Interceptor
    if ($('.alert-success').length > 0) {
        var msg = $('.alert-success').text().replace('×', '').replace('Berhasil!', '').replace('Sync API Berhasil!', '').trim();
        if (!msg) msg = "Operasi berhasil diproses!";
        $('.alert-success').remove();
        Toast.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: msg,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a'
        });
    }

    // Danger / Error Flashdata Interceptor
    if ($('.alert-danger').length > 0) {
        var msg = $('.alert-danger').text().replace('×', '').replace('Gagal!', '').trim();
        if (!msg) msg = "Terjadi kesalahan pada sistem!";
        $('.alert-danger').remove();
        Toast.fire({
            icon: 'error',
            title: 'Oops!',
            text: msg,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a'
        });
    }

    // Warning Flashdata Interceptor
    if ($('.alert-warning').length > 0) {
        var msg = $('.alert-warning').text().replace('×', '').replace('Peringatan!', '').trim();
        if (!msg) msg = "Perhatikan data yang Anda masukkan!";
        $('.alert-warning').remove();
        Toast.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: msg,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a'
        });
    }

    // Info Flashdata Interceptor
    if ($('.alert-info').length > 0) {
        var msg = $('.alert-info').text().replace('×', '').trim();
        $('.alert-info').remove();
        Toast.fire({
            icon: 'info',
            title: 'Informasi',
            text: msg,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a'
        });
    }

    // 1. Konfirmasi Hapus Data Modern (SweetAlert2)
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const nama = $(this).data('nama') || $(this).attr('title') || 'data ini';

        Swal.fire({
            title: 'Hapus Data Ini?',
            html: `Data <span class="badge badge-light border text-danger font-weight-bold px-2 py-1 mx-1" style="font-size: 0.95em;">${nama}</span> akan dihapus permanen dari sistem dan tidak dapat dipulihkan!`,
            icon: 'warning',
            iconColor: '#f43f5e',
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonText: '<i class="fas fa-trash-can mr-2"></i> Ya, Hapus Sekarang!',
            cancelButtonText: '<i class="fas fa-xmark mr-2"></i> Batal',
            customClass: {
                popup: 'swal2-modern-popup',
                confirmButton: 'btn btn-danger px-4 py-2 shadow-sm',
                cancelButton: 'btn btn-light border px-4 py-2 shadow-sm'
            },
            buttonsStyling: false,
            reverseButtons: true,
            focusCancel: true,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a',
            showClass: {
                popup: 'animate__animated animate__zoomIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menghapus data dari sistem',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    background: isDarkMode() ? '#1e293b' : '#ffffff',
                    color: isDarkMode() ? '#f8fafc' : '#0f172a'
                });
                document.location.href = href;
            }
        });
    });

    // 2. Konfirmasi Aksi Umum (Presensi / Pengajuan / Konfirmasi)
    $(document).on('click', '.btn-konfirmasi', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const form = $(this).closest('form');
        const judul = $(this).data('judul') || 'Konfirmasi Tindakan';
        const pesan = $(this).data('pesan') || 'Apakah Anda yakin ingin melanjutkan proses ini?';
        const tipe = $(this).data('tipe') || 'question';
        const warnaBtn = $(this).data('warna') || '#0284c7';
        const teksBtn = $(this).data('btn-teks') || '<i class="fas fa-check mr-2"></i> Ya, Lanjutkan!';

        Swal.fire({
            title: judul,
            html: pesan,
            icon: tipe,
            showCancelButton: true,
            confirmButtonText: teksBtn,
            cancelButtonText: '<i class="fas fa-xmark mr-2"></i> Batal',
            customClass: {
                popup: 'swal2-modern-popup',
                confirmButton: 'btn btn-primary px-4 py-2 shadow-sm',
                cancelButton: 'btn btn-light border px-4 py-2 shadow-sm'
            },
            buttonsStyling: false,
            reverseButtons: true,
            background: isDarkMode() ? '#1e293b' : '#ffffff',
            color: isDarkMode() ? '#f8fafc' : '#0f172a',
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
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

    // Global AppAlert Utility
    window.AppAlert = {
        toast: (icon, title, text) => Toast.fire({ icon, title, text, background: isDarkMode() ? '#1e293b' : '#ffffff', color: isDarkMode() ? '#f8fafc' : '#0f172a' }),
        success: (title, text) => window.AppAlert.toast('success', title, text),
        error: (title, text) => window.AppAlert.toast('error', title, text),
        warning: (title, text) => window.AppAlert.toast('warning', title, text),
        info: (title, text) => window.AppAlert.toast('info', title, text),
        confirm: (title, html, onConfirm) => {
            Swal.fire({
                title,
                html,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check mr-2"></i> Ya',
                cancelButtonText: '<i class="fas fa-xmark mr-2"></i> Batal',
                customClass: {
                    popup: 'swal2-modern-popup',
                    confirmButton: 'btn btn-primary px-4 py-2 shadow-sm',
                    cancelButton: 'btn btn-light border px-4 py-2 shadow-sm'
                },
                buttonsStyling: false,
                reverseButtons: true,
                background: isDarkMode() ? '#1e293b' : '#ffffff',
                color: isDarkMode() ? '#f8fafc' : '#0f172a'
            }).then((result) => {
                if (result.isConfirmed && typeof onConfirm === 'function') onConfirm();
            });
        }
    };
});
</script>

<script>
  // =========================================================
  // SEAMLESS & GAPLESS DARK MODE ENGINE (View Transitions API)
  // =========================================================
  const darkModeToggle = document.getElementById('darkModeToggle');
  const darkModeIcon = document.getElementById('darkModeIcon');

  function updateDarkModeState(isDark) {
      if (isDark) {
          document.documentElement.classList.add('dark-mode');
          document.body.classList.add('dark-mode');
          localStorage.setItem('darkMode', 'enabled');
          if (darkModeIcon) {
              darkModeIcon.classList.remove('fa-moon', 'text-light');
              darkModeIcon.classList.add('fa-sun', 'text-warning');
          }
      } else {
          document.documentElement.classList.remove('dark-mode');
          document.body.classList.remove('dark-mode');
          localStorage.setItem('darkMode', 'disabled');
          if (darkModeIcon) {
              darkModeIcon.classList.remove('fa-sun', 'text-warning');
              darkModeIcon.classList.add('fa-moon', 'text-light');
          }
      }
  }

  // Initial Sync on load
  if (localStorage.getItem('darkMode') === 'enabled') {
      updateDarkModeState(true);
  }

  if (darkModeToggle) {
      darkModeToggle.addEventListener('click', () => {
          const willBeDark = !document.body.classList.contains('dark-mode');

          // Icon Micro-interaction rotation
          if (darkModeIcon) {
              darkModeIcon.style.transform = 'rotate(180deg) scale(0.65)';
          }

          // Native View Transitions API for GPU-accelerated morph
          if (document.startViewTransition) {
              document.startViewTransition(() => {
                  updateDarkModeState(willBeDark);
              }).finished.finally(() => {
                  if (darkModeIcon) {
                      darkModeIcon.style.transform = 'rotate(0deg) scale(1)';
                  }
              });
          } else {
              // Fallback smooth transition
              document.documentElement.classList.add('theme-transitioning');
              updateDarkModeState(willBeDark);
              setTimeout(() => {
                  if (darkModeIcon) {
                      darkModeIcon.style.transform = 'rotate(0deg) scale(1)';
                  }
                  setTimeout(() => {
                      document.documentElement.classList.remove('theme-transitioning');
                  }, 380);
              }, 40);
          }
      });
  }

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