-- Migrasi: Konfigurasi Hari Libur Mingguan pada tabel setting_absensi
-- Format ISO-8601 (1=Senin .. 6=Sabtu, 7=Minggu). Default: '6,7' (Sabtu & Minggu libur)

ALTER TABLE `setting_absensi`
  ADD COLUMN IF NOT EXISTS `hari_libur_mingguan` VARCHAR(20) NOT NULL DEFAULT '6,7' AFTER `tarif_lembur_per_jam`;

UPDATE `setting_absensi`
  SET `hari_libur_mingguan` = '6,7'
  WHERE `id` = 1 AND (`hari_libur_mingguan` IS NULL OR `hari_libur_mingguan` = '');
