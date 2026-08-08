<div align="center">
  <img src="assets/img/kpmh.png" alt="Logo Klinik" width="150"/>
  <h1>HRIS & Aplikasi Penggajian Karyawan</h1>
  <p>Sistem Manajemen Sumber Daya Manusia Terpadu untuk Klinik Pratama Dr. H.M. Hidayatullah.</p>

  <!-- Badges -->
  <p>
    <img src="https://img.shields.io/badge/CodeIgniter-3.1.11-DD4814?style=for-the-badge&logo=codeigniter&logoColor=white" alt="CodeIgniter">
    <img src="https://img.shields.io/badge/Bootstrap-4-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
    <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Status-Completed-success?style=for-the-badge" alt="Status">
  </p>
</div>

<br>

## 🚀 Tentang Proyek Ini
Aplikasi ini adalah **Sistem Informasi Kepegawaian (HRIS)** berbasis Web yang dibangun dengan *framework* CodeIgniter 3. Aplikasi ini dirancang tidak hanya untuk sekadar mencatat absensi dan gaji, tetapi didesain dengan standar **UI/UX tingkat tinggi (Enterprise Level)** untuk memberikan kenyamanan dan pengalaman interaktif yang modern bagi Admin (HRD) maupun Pegawai.

---

## ✨ Fitur Unggulan UI/UX (Frontend)
Aplikasi ini dipersenjatai dengan modifikasi *Frontend* mutakhir untuk memastikan pengalaman pengguna yang sempurna:
- 🌌 **Login Interaktif:** Desain layar terbelah (*split-screen*) modern dengan efek latar belakang konstelasi bintang responsif menggunakan **Particles.js**. Serta fitur *Show/Hide Password*.
- 🌓 **Dark Mode Global:** Mode Gelap elegan dengan transisi warna mulus (*gapless*) yang preferensinya tersimpan secara permanen melalui `localStorage`.
- 🔔 **Toast Notifications:** Meninggalkan *pop-up* kaku konvensional, aplikasi ini menggunakan notifikasi **SweetAlert2** bertipe *Top-Down Colored Toast* yang meluncur elegan dari atas layar.
- 🌀 **Full-screen Preloader:** Indikator *loading* memutar yang mencegah layar putih (*blank*) saat perpindahan halaman yang berat.
- 💼 **UI/UX Data Master Kelas Enterprise:** Transformasi desain *form* Tambah/Edit (Pegawai & Jabatan) menggunakan *Grid System 2 Kolom*, *Card* bersudut membulat (*rounded*), dan injeksi *Input Icons* (FontAwesome).
- 📊 **Tabel Data Interaktif & Informatif:** Penggunaan *Badge* warna untuk membedakan status/hak akses, foto profil bulat (*rounded-circle*), dan perataan kanan (*right-aligned*) khusus untuk angka/nominal uang agar standar akuntansi terpenuhi.
- 🎨 **Modern Micro-interactions:** *Custom Scrollbar* elegan bergaya macOS, *Hover Effect* pada baris tabel dan kartu, serta panel navigasi modern yang menyatu.

---

## 🛠️ Fitur Utama (Backend)
- 👥 **Manajemen Pegawai & Jabatan:** Pendataan lengkap karyawan, jabatan, dan struktur gaji pokok beserta tunjangannya.
- ⏱️ **Sistem Absensi Cerdas:** Perekaman jam masuk/pulang secara akurat berdasarkan zona waktu *real-time* (`Asia/Jakarta`).
- 🏝️ **Sistem Pengajuan Cuti/Izin:** Pegawai dapat mengajukan cuti, dan Admin/HRD dapat memberikan persetujuan (Setuju/Tolak) yang disertai dengan **Catatan/Pesan Feedback** langsung dari HRD.
- 📅 **Sinkronisasi Hari Libur Nasional API:** Data tanggal merah dan cuti bersama ditarik secara otomatis *(Real-time Sync)* dari server statis **GitHub APIHariLibur_V2**, bebas dari konfigurasi manual.
- 💰 **Kalkulasi & Laporan Penggajian:** Penghitungan gaji otomatis berdasarkan kehadiran, keterlambatan, dan potongan Alpha, yang siap dicetak ke dalam Slip Gaji resmi.

---

## 🛡️ Standar Keamanan (Security Hardening)
Aplikasi ini telah diperkeras perlindungannya dari serangan siber umum yang sering menjadi kelemahan sistem konvensional:
- **BCRYPT Hashing & Password Protection:** Menggantikan MD5 usang dengan BCRYPT murni. Terdapat lapisan keamanan tambahan yang mencegah *hijacking* (*form* Edit Pegawai tidak akan mereset password secara diam-diam jika dibiarkan kosong, dan pengguna wajib memasukkan Password Lama saat merubah *password* pribadi).
- **Anti CSRF (Cross-Site Request Forgery):** Token pelindung dinamis disuntikkan secara otomatis di seluruh *form* aplikasi, mencegah penyerang mengirimkan permintaan palsu dari luar domain.
- **Global XSS Filtering:** Sistem pembersih otomatis (Sanitization) yang melucuti skrip jahat (*Javascript / HTML injection*) dari input pengguna maupun parameter URL (`$_GET`).
- **SQL Injection Prevention:** Penerapan *Query Binding* (`?`) secara ketat di seluruh fitur Filter, Laporan, dan Pencarian untuk melindungi *database* dari ancaman peretasan *URL Spoofing* dan *Union-Based Injection*.

---

## 💻 Panduan Instalasi
Untuk menjalankan aplikasi ini secara lokal (*localhost*):

1. **Clone Repositori ini:**
   ```bash
   git clone https://github.com/NorisukiNZk/penggajian.git
   ```
2. **Siapkan Database:**
   - Buka XAMPP / Laragon, jalankan Apache dan MySQL.
   - Buka phpMyAdmin, buat *database* baru (misal: `penggajian`).
   - Import file SQL yang tersedia di folder proyek (jika ada, biasanya `penggajian.sql`) ke dalam database tersebut.
3. **Konfigurasi Database CodeIgniter:**
   - Buka file `application/config/database.php`.
   - Sesuaikan *username*, *password*, dan *nama database*.
4. **Jalankan Aplikasi:**
   - Buka browser dan ketik: `http://localhost/penggajian/`
   - *Login* sebagai Admin atau Pegawai untuk mulai menjelajah.

---

## 📸 Cuplikan Layar (Screenshots)
*(Tambahkan gambar cuplikan layar aplikasi di sini agar HRD bisa langsung melihat visual aplikasi tanpa harus meng-install-nya)*

- **Halaman Login:** `![Login](link-gambar-login.jpg)`
- **Dashboard Admin:** `![Dashboard](link-gambar-dashboard.jpg)`
- **Notifikasi Toast:** `![Toast](link-gambar-toast.jpg)`

---
<div align="center">
  Dibuat untuk Portofolio & Tugas Akhir. <br>
  <strong>NorisukiNZK</strong>
</div>
