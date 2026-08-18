<div align="center">
  <img src="assets/img/kpmh.png" alt="Logo Klinik Pratama Hidayatullah" width="140"/>
  <h1>Enterprise HRIS & Payroll Management System</h1>
  <p><strong>Sistem Informasi Manajemen Sumber Daya Manusia & Penggajian Terpadu</strong><br>Klinik Pratama Dr. H.M. Hidayatullah</p>

  <!-- Badges -->
  <p>
    <img src="https://img.shields.io/badge/CodeIgniter-3.1.11-DD4814?style=for-the-badge&logo=codeigniter&logoColor=white" alt="CodeIgniter">
    <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Bootstrap-4.6-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
    <img src="https://img.shields.io/badge/SweetAlert2-Toast-FF6B6B?style=for-the-badge" alt="SweetAlert2">
    <img src="https://img.shields.io/badge/Status-Production--Ready-success?style=for-the-badge" alt="Status">
  </p>
</div>

---

## 📌 Ringkasan Proyek (*Executive Summary*)
Aplikasi **HRIS (Human Resource Information System) & Payroll Terpadu** ini dikembangkan untuk mengotomatisasi manajemen kepegawaian, absensi harian, permohonan lembur, pengajuan cuti, pinjaman karyawan (kasbon), hingga penghitungan gaji secara *stateless* dan pembuatan dokumen cetak resmi berstandar korporat (*Enterprise-grade*).

Sistem telah diuji secara menyeluruh (*Quality Assurance & User Testing*) dan dilengkapi validasi data berlapis, arsitektur keamanan modern, serta visualisasi analitik real-time.

---

## 🌟 Fitur Utama & Modul Sistem (*Core Modules*)

### 1. 👥 Manajemen Data Master & Hak Akses (RBAC)
- **Data Pegawai:** Pengelolaan identitas NIK unik, biodata, jabatan, status kerja (Tetap / Tidak Tetap), tanggal masuk dengan validasi tanggal aktual, dan upload foto profil.
- **Data Jabatan:** Pengaturan nama jabatan unik, standar gaji pokok, tunjangan transport, dan uang makan.
- **Data Potongan & Tunjangan Dinamis:** Fleksibilitas konfigurasi komponen penambah/pemotong gaji (nominal tetap maupun persentase).
- **Role-Based Access Control (RBAC):**
  - **Admin / HRD:** Hak akses menyeluruh (Data Master, Transaksi, Approval, Monitoring, dan Laporan).
  - **Pegawai (ESS - Employee Self-Service):** Akses mandiri untuk pengajuan cuti, lembur, pinjaman, monitoring absensi, serta cetak slip gaji pribadi.

---

### 2. 💸 Modul Pinjaman Karyawan / Kasbon (*Stateless Auto-Deduct*)
- **Employee Self-Service (ESS):** Pegawai dapat mengajukan pinjaman dengan menentukan nominal dan tenor cicilan (1 s/d 12 bulan).
- **HRD Approval Workflow:** Panel validasi bagi Admin untuk Menyetujui (*Approve*) atau Menolak (*Reject*) pengajuan pinjaman.
- **Stateless Time-Period Calculation:** Algoritma cerdas yang menghitung posisi cicilan aktif (`Cicilan ke-X dari Y bulan`) secara matematis berdasarkan periode bulan & tahun penggajian tanpa mengubah data riwayat saat slip dicetak berulang kali (*anti-double deduction*).
- **Slip Gaji Integration:** Potongan pinjaman terinci otomatis muncul di slip gaji dengan label status cicilan transparan.

---

### 3. ⏱️ Manajemen Absensi, Lembur & Cuti Pegawai
- **Monitoring Absensi Real-Time:** Pencatatan kehadiran harian (Tepat Waktu, Terlambat, Sakit, Izin, Alpha).
- **Fraud-Prevention pada Lembur:** Validasi silang yang membandingkan durasi jam lembur yang diajukan dengan jam kepulangan aktual pada sistem absensi harian.
- **Manajemen Cuti Terstruktur:** Siklus pengajuan cuti dengan verifikasi HRD beserta catatan/alasan penolakan/persetujuan.
- **Integrasi API Hari Libur Nasional:** Sinkronisasi otomatis data kalender libur nasional dan cuti bersama via *APIHariLibur_V2*.

---

### 4. 🖨️ Modul Dokumen Resmi & Cetak Laporan (*Smart Reporting*)
Sistem menyediakan **12+ Modul Cetak Laporan** berstandar dokumen resmi:

| Kategori Laporan | Jenis Laporan | Fitur Khusus |
| :--- | :--- | :--- |
| **Penggajian** | Slip Gaji (Admin & Pegawai) | QR Code, Watermark, Rincian Komponen & Pinjaman |
| **Penggajian** | Laporan Gaji Bulanan | Rekapitulasi per bulan dengan filter dinamis |
| **Penggajian** | Laporan Gaji Tahunan (*Annual Report*) | Akumulasi komputasi 12 bulan untuk seluruh pegawai |
| **Operasional** | Laporan Rekap Lembur | Filter periode dengan kalkulasi tarif lembur |
| **Operasional** | Laporan Rekap Potongan Gaji | Akumulasi denda alpha & potongan dinamis |
| **Operasional** | Laporan Rekapitulasi Absensi | Rekap kehadiran, sakit, izin, dan alpha |
| **Master Data** | Laporan Data Pegawai, Jabatan, & Cuti | Format cetak siap arsip (*Print-Ready*) |

#### ✨ Standar Dokumen Enterprise pada Semua Cetakan:
1. **Nomor Surat Otomatis:** Dihasilkan secara dinamis dengan penomoran Romawi bulan berjalan (Contoh: `Nomor : 260810/HRD-KPMH/VIII/2026`).
2. **Validasi QR Code Digital:** Tersemat QR Code otentikasi digital pada blok tanda tangan Pimpinan Klinik (**Dr. H. Muhammad Hidayatullah**).
3. **Transparent Watermark:** Injeksi logo instansi transparan (10% opacity) di tengah lembar dokumen untuk mencegah pemalsuan fisik.
4. **Grid-Based Kop Surat:** Struktur tabel presisi yang rapi di semua ukuran printer (A4, Letter, F4/Folio).

---

### 5. 📊 Dashboard Analytics & Interaktivitas UI/UX
- **Interactive KPI Cards:** Informasi cepat jumlah total pegawai aktif, hadir tepat waktu hari ini, terlambat, serta sakit/izin.
- **Tren Kehadiran 6 Bulan (Line Chart):** Visualisasi performa absensi dari waktu ke waktu.
- **Komposisi Jabatan (Doughnut Chart):** Distribusi persebaran pegawai berdasarkan unit jabatan.
- **Kalender Libur Terdekat:** Widget pengingat tanggal merah dan hari libur nasional mendatang.
- **Persistent Dark Mode:** Pengaturan tema gelap/terang yang tersimpan di `localStorage`.
- **Live Digital Clock:** Penunjuk jam digital real-time zona waktu WITA.
- **Mobile Responsive:** Optimasi tampilan perangkat bergerak dengan sidebar otomatis terlipat (*auto-collapse*) pada mode Android/iOS.

---

### 6. 🛡️ Keamanan Sistem & Integritas Data (*Security Hardening*)
- 🔑 **BCRYPT Password Hashing:** Menggunakan standar algoritma kriptografi modern `password_hash()` dan `password_verify()`.
- 🤖 **Google reCAPTCHA v2:** Perlindungan pada halaman login dari serangan *Brute-Force* dan *Automated Bot*.
- 🛡️ **Anti-CSRF & XSS Clean:** Proteksi token *Cross-Site Request Forgery* pada seluruh form serta penyaringan input data.
- ⚡ **Real-Time Session Synchronization:** Pembaruan data sesi login secara instan ketika Admin memperbarui profilnya sendiri tanpa perlu relogin.
- 🚫 **Validasi Bebas Duplikasi:** Pengecekan keunikan NIK dan Jabatan (*is_unique*) pada saat tambah maupun update data, serta perbaikan *restore select-box* form.
- 🔒 **Database Error Obfuscation:** Penonaktifan `db_debug` publik untuk mencegah kebocoran struktur query SQL (*Information Disclosure*).
- 🧹 **Anti-Spam Flashdata Notification:** Penghapusan elemen DOM notifikasi SweetAlert2 agar pesan sukses/gagal tidak muncul berulang saat refresh atau menggunakan tombol *Back* browser.

---

## 🛠️ Tumpukan Teknologi (*Technology Stack*)
- **Backend:** PHP 7.4+ dengan Framework CodeIgniter 3.1.11 (MVC Architecture)
- **Database:** MySQL / MariaDB
- **Frontend & UI:** HTML5, CSS3, JavaScript (ES6), Bootstrap 4.6, SB Admin 2
- **Libraries & Plugins:**
  - SweetAlert2 (Modern Alert & Toast Notifications)
  - Chart.js (Data Visualization)
  - DataTables (Interactive Data Grid)
  - FontAwesome 5 (Vector Icons)
  - Google reCAPTCHA v2 API
  - Public Holiday API (*APIHariLibur_V2*)

---

## 🚀 Panduan Instalasi (*Installation Guide*)

### 1. Prasyarat Sistem
- Web Server (Apache via XAMPP / Laragon / WampServer)
- PHP versi 7.4 atau lebih tinggi
- MySQL / MariaDB Server

### 2. Langkah-langkah Setup
1. **Clone repositori ke folder web server:**
   ```bash
   # Masuk ke folder htdocs
   cd c:/xampp/htdocs/
   
   # Clone repositori
   git clone https://github.com/NorisukiNZk/penggajian.git
   ```
2. **Import Database:**
   - Buka browser dan akses `http://localhost/phpmyadmin`.
   - Buat database baru bernama `penggajian`.
   - Import berkas SQL `db database/penggajian.sql` yang telah disediakan.
3. **Konfigurasi Database:**
   - Buka berkas `application/config/database.php`.
   - Sesuaikan konfigurasi koneksi:
     ```php
     'hostname' => 'localhost',
     'username' => 'root',
     'password' => '',
     'database' => 'penggajian',
     ```
4. **Konfigurasi Base URL:**
   - Buka berkas `application/config/config.php`.
   - Pastikan base URL mengarah ke folder instalasi:
     ```php
     $config['base_url'] = 'http://localhost/penggajian/';
     ```
5. **Jalankan Aplikasi:**
   - Buka browser dan akses: `http://localhost/penggajian/`

---

## 🔐 Kredensial Login Bawaan (*Default Accounts*)

| Role / Hak Akses | Username | Password | Akses Halaman |
| :--- | :--- | :--- | :--- |
| **Admin (HRD)** | `admin` | `admin` | `http://localhost/penggajian/admin/dashboard` |
| **Pegawai** | `pegawai` *(atau NIK Pegawai)* | `123456` *(atau sesuai database)* | `http://localhost/penggajian/pegawai/dashboard` |

> *Catatan: Untuk pengujian reCAPTCHA di lingkungan local, digunakan Google Test Key yang selalu valid.*

---

<div align="center">
  <sub>Sistem Informasi Penggajian & Kepegawaian &bull; Klinik Pratama Dr. H.M. Hidayatullah</sub><br>
  <strong>&copy; 2026 NorisukiNZk</strong>
</div>
