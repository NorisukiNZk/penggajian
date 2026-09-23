# Sistem Informasi Penggajian & Kepegawaian (HRIS)
### Klinik Pratama Dr. H.M. Hidayatullah

Aplikasi berbasis web untuk pengelolaan administrasi kepegawaian, pencatatan presensi, pengajuan cuti dan lembur, serta perhitungan penggajian (*payroll*) pada Klinik Pratama Dr. H.M. Hidayatullah.

---

## Prasyarat Sistem

Sebelum melakukan instalasi, pastikan lingkungan server lokal telah memenuhi spesifikasi berikut:

- **Web Server**: Apache (XAMPP, Laragon, atau sejenisnya)
- **Bahasa Pemrograman**: PHP versi 7.4 s/d 8.2
- **Basis Data**: MySQL 5.7+ atau MariaDB 10.x
- **Ekstensi PHP Aktif**: `mysqli`, `curl`, `mbstring`, `json`
- **Peramban Web**: Google Chrome, Mozilla Firefox, atau Microsoft Edge versi terbaru

---

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk memasang dan menjalankan aplikasi:

### 1. Kloning Repositori
Tempatkan berkas proyek pada direktori server lokal (contoh pada XAMPP):
```bash
cd c:/xampp/htdocs/
git clone https://github.com/NorisukiNZk/penggajian.git
```
Atau ekstrak berkas proyek langsung ke dalam folder `c:/xampp/htdocs/penggajian`.

### 2. Impor Basis Data
1. Buka browser dan buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Buat database baru dengan nama `penggajian`.
3. Buka tab **Import**, pilih berkas database:
   ```
   db database/penggajian.sql
   ```
4. Klik tombol **Go** / **Kirim** dan tunggu hingga proses impor selesai.

### 3. Konfigurasi Koneksi Database
Buka berkas `application/config/database.php` dan sesuaikan pengaturan koneksi:
```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'penggajian',
    'dbdriver' => 'mysqli',
    // ...
);
```

### 4. Konfigurasi Base URL
Buka berkas `application/config/config.php` dan pastikan direktori `base_url` sudah sesuai:
```php
$config['base_url'] = 'http://localhost/penggajian/';
```

### 5. Akses Aplikasi
Buka peramban web dan akses alamat:
```
http://localhost/penggajian/
```

---

## Kredensial Pengujian Bawaan

Sistem menggunakan pembagian hak akses (*Role-Based Access Control*):

| Peran (Role) | Username | Password Default | Keterangan Akses |
| :--- | :--- | :--- | :--- |
| **Administrator** | `waffa` | `12345` | Akses penuh: master data, transaksi penggajian, persetujuan cuti/lembur/pinjaman, dan laporan. |
| **Pegawai** | `anya` | `12345` | Akses mandiri (ESS): presensi harian, pengajuan cuti, lembur, pinjaman, dan slip gaji pribadi. |

> **Catatan**: Kredensial di atas digunakan untuk keperluan uji coba awal. Disarankan segera memperbarui kata sandi setelah sistem digunakan di lingkungan produksi melalui menu **Ganti Password**.

---

## Hak Cipta

Dokumentasi dan sistem ini dikembangkan untuk operasional **Klinik Pratama Dr. H.M. Hidayatullah**.

&copy; 2026 NorisukiNZk. Seluruh hak cipta dilindungi.
