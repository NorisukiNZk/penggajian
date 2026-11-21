-- =========================================================================
-- Migrasi Role Pimpinan (hak_akses = 3)
-- HRIS Klinik Pratama Dr. H.M. Hidayatullah
-- =========================================================================

-- 1. Tambahkan hak akses Pimpinan (3) ke tabel hak_akses secara aman (idempoten)
INSERT INTO `hak_akses` (`id`, `keterangan`, `hak_akses`)
SELECT 3, 'pimpinan', 3
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM `hak_akses` WHERE `hak_akses` = 3
);

-- 2. (Opsional) Tambahkan akun demo Pimpinan / Direktur Utama jika belum ada
-- Username : pimpinan
-- Password : pimpinan123  (BCRYPT hash)
INSERT INTO `data_pegawai` (`nik`, `nama_pegawai`, `username`, `password`, `jenis_kelamin`, `jabatan`, `tanggal_masuk`, `status`, `photo`, `hak_akses`)
SELECT '198001010001', 'dr. H.M. Hidayatullah', 'pimpinan', '$2y$10$vfHgI4t1l/FrRWq/rDI/C.qW2wuTPTWgpewZQautkq01srsuk0MEK', 'Laki-Laki', 'Direktur', '2020-01-01', 'Karyawan Tetap', 'kpmh.jpg', 3
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM `data_pegawai` WHERE `username` = 'pimpinan'
);
