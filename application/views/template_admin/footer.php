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
<!-- Modern Chart.js v4.4+ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<!-- Modern DataTables 2.x -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script>
$(document).ready(function() {
  if ($.fn.DataTable && $('#dataTable').length > 0 && !$.fn.DataTable.isDataTable('#dataTable')) {
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

  // Adjust table widths when toggling tabs
  $('a[data-toggle="tab"], a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
    if ($.fn.DataTable) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }
  });
});
</script>


<!-- Modern SweetAlert2 v11.17+ -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    function isDarkMode() {
        return document.body.classList.contains('dark-mode');
    }

    // =========================================================
    // BERSIH & TENANG: Konfirmasi Tindakan Kritis (SweetAlert2)
    // Flashdata alert tetap tampil tenang sebagai Bootstrap Alert asli di halaman
    // =========================================================
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const nama = $(this).data('nama') || $(this).attr('title') || 'data ini';

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus ' + nama + '? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });

    $(document).on('click', '.btn-konfirmasi', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        const form = $(this).closest('form');
        const judul = $(this).data('judul') || 'Konfirmasi Tindakan';
        const pesan = $(this).data('pesan') || 'Apakah Anda yakin ingin melanjutkan proses ini?';
        const tipe = $(this).data('tipe') || 'question';

        Swal.fire({
            title: judul,
            text: pesan,
            icon: tipe,
            showCancelButton: true,
            confirmButtonColor: '#0c2b4d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
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

    // =========================================================
    // MODERN SWEETALERT2: Konfirmasi Logout Premium & Profesional
    // =========================================================
    $(document).on('click', '.btn-logout-swal, [data-target="#logoutModal"], a[href*="login/logout"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ($('#logoutModal').length) {
            $('#logoutModal').modal('hide');
        }

        const logoutUrl = $(this).attr('href') && $(this).attr('href') !== '#' ? $(this).attr('href') : '<?php echo base_url("login/logout"); ?>';
        const userName = $(this).data('user') || '<?php echo htmlspecialchars($this->session->userdata("nama_pegawai") ?? "Administrator"); ?>';
        const userRole = $(this).data('role') || 'Administrator';
        const isDark = isDarkMode();

        Swal.fire({
            html: `
                <div class="logout-modal-content">
                    <div class="logout-badge-circle">
                        <i class="fas fa-power-off"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}" style="font-size: 1.25rem;">
                        Konfirmasi Logout
                    </h4>
                    <p class="text-muted small mb-2" style="font-size: 0.9rem; line-height: 1.5;">
                        Halo <strong class="${isDark ? 'text-light' : 'text-dark'}">${userName}</strong>, apakah Anda yakin ingin mengakhiri sesi kerja sebagai <strong>${userRole}</strong>?
                    </p>
                    <div class="logout-info-box">
                        <i class="fas fa-shield-alt text-primary fa-lg mr-2"></i>
                        <span class="small">Sesi autentikasi Anda di sistem Klinik Pratama Dr. H.M. Hidayatullah akan ditutup secara aman.</span>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-sign-out-alt mr-2"></i> Ya, Logout',
            cancelButtonText: '<i class="fas fa-times mr-2"></i> Tetap di Sini',
            customClass: {
                popup: 'swal2-logout-popup shadow-lg',
                actions: 'swal2-logout-actions',
                confirmButton: 'btn btn-danger px-4 py-2 font-weight-bold shadow-sm',
                cancelButton: 'btn btn-light border px-4 py-2 font-weight-bold shadow-sm text-secondary'
            },
            buttonsStyling: false,
            reverseButtons: true,
            focusCancel: true,
            width: 440,
            background: isDark ? '#1e293b' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    html: `
                        <div class="logout-loading-content py-3 text-center">
                            <div class="logout-spinner-container mb-3 position-relative d-inline-block">
                                <div class="spinner-border text-danger" style="width: 3.5rem; height: 3.5rem; border-width: 3.5px;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%); color: #ef4444; font-size: 1.25rem;">
                                    <i class="fas fa-power-off"></i>
                                </div>
                            </div>
                            <h5 class="font-weight-bold mb-2 ${isDark ? 'text-white' : 'text-gray-900'}" style="font-size: 1.2rem; letter-spacing: -0.01em;">
                                Mengakhiri Sesi...
                            </h5>
                            <p class="text-muted small mb-0" style="font-size: 0.88rem; line-height: 1.4;">
                                Membersihkan sesi aman dan mengalihkan ke halaman login...
                            </p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    width: 390,
                    background: isDark ? '#1e293b' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#0f172a',
                    customClass: {
                        popup: 'swal2-logout-popup shadow-lg'
                    }
                });
                setTimeout(function() {
                    window.location.href = logoutUrl;
                }, 750);
            }
        });
    });
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

  // Preloader Fast & Non-Blocking Dismissal
  (function() {
      // Fix Sidebar on Mobile
      if ($(window).width() <= 768) {
          $("body").addClass("sidebar-toggled");
          $(".sidebar").addClass("toggled");
      }

      var preloader = document.getElementById('preloader');
      if (!preloader) return;

      function dismissPreloader() {
          if (!preloader.classList.contains('loaded')) {
              preloader.classList.add('loaded');
              preloader.style.pointerEvents = 'none';
              preloader.style.opacity = '0';
              setTimeout(function() {
                  if (preloader) preloader.style.display = 'none';
              }, 200);
          }
      }

      // Hide immediately as soon as DOM is interactive or loaded
      if (document.readyState === 'interactive' || document.readyState === 'complete') {
          setTimeout(dismissPreloader, 60);
      } else {
          document.addEventListener('DOMContentLoaded', function() {
              setTimeout(dismissPreloader, 60);
          });
          window.addEventListener('load', dismissPreloader);
      }

      // Hard safety timeout: under no circumstance let the preloader trap clicks for >300ms
      setTimeout(dismissPreloader, 300);
  })();

  // Prevent Bootstrap Accordion Transition Lock Bug on Rapid Clicking
  $(document).on('click', '.sidebar .nav-link[data-toggle="collapse"]', function() {
      var target = $(this).attr('data-target') || $(this).attr('href');
      if (target) {
          var $target = $(target);
          if ($target.hasClass('collapsing')) {
              $target.removeClass('collapsing').addClass('collapse');
          }
      }
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