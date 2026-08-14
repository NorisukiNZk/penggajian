# Entity Relationship Diagram (Relasi Antar Tabel)

Berikut adalah *source code* Mermaid untuk membuat gambar desain ERD (Relasi Tabel) aplikasi penggajian klinik Anda. 

Anda dapat meng-_copy_ blok kode di bawah ini lalu melakukan _paste_ ke situs **[Mermaid Live Editor](https://mermaid.live/)** untuk mendapatkan gambar relasinya dalam bentuk JPG atau PNG yang sangat rapi.

```mermaid
erDiagram
    %% Tabel Master
    data_jabatan {
        int id_jabatan PK
        varchar nama_jabatan UK
        varchar gaji_pokok
        varchar tj_transport
        varchar uang_makan
    }
    
    hak_akses {
        int id PK
        int hak_akses UK
        varchar keterangan
    }

    data_pegawai {
        int id_pegawai PK
        varchar nik UK
        varchar nama_pegawai
        varchar jabatan FK "Merujuk nama_jabatan"
        int hak_akses FK "Merujuk id hak_akses"
        date tanggal_masuk
        varchar status
    }
    
    %% Tabel Transaksi Absensi
    absensi_harian {
        int id PK
        varchar nik FK "Merujuk NIK pegawai"
        date tanggal
        time jam_masuk
        time jam_pulang
        enum status
    }
    
    data_kehadiran {
        int id_kehadiran PK
        varchar nik FK "Merujuk NIK pegawai"
        varchar bulan
        int hadir
        int sakit
        int alpha
    }
    
    %% Tabel Master & Transaksi Komponen Gaji Baru
    komponen_gaji {
        int id_komponen PK
        varchar nama_komponen
        enum tipe
        int nominal
        tinyint is_persentase
    }
    
    komponen_gaji_pegawai {
        int id PK
        varchar nik FK "Merujuk NIK pegawai"
        int id_komponen FK "Merujuk id komponen"
        varchar bulan
        int nominal_override
    }
    
    %% Tabel Pengaturan (Konfigurasi Global - Tidak berelasi langsung dengan entitas tunggal)
    setting_absensi {
        int id PK
        time jam_masuk
        time jam_pulang
        int toleransi_menit
    }
    
    potongan_gaji {
        int id PK
        varchar potongan
        int jml_potongan
    }

    %% Definisi Relasi Kardinalitas (Garis Penghubung)
    
    data_jabatan ||--o{ data_pegawai : "Satu jabatan dimiliki oleh Banyak pegawai"
    hak_akses ||--o{ data_pegawai : "Satu Hak Akses diberikan ke Banyak pegawai"
    
    data_pegawai ||--o{ absensi_harian : "Satu Pegawai melakukan Banyak absensi harian"
    data_pegawai ||--o{ data_kehadiran : "Satu Pegawai memiliki Banyak rekap kehadiran (bulanan)"
    
    data_pegawai ||--o{ komponen_gaji_pegawai : "Satu Pegawai dikenakan/menerima Banyak komponen (BPJS/Pajak)"
    komponen_gaji ||--o{ komponen_gaji_pegawai : "Satu Komponen master dapat diberikan ke Banyak pegawai"

```
