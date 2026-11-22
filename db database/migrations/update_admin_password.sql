-- =====================================================
-- SQL: Fix Kolom Password & Update Admin (BCRYPT)
-- =====================================================

-- Masalah: Kolom password lama hanya menampung 32 karakter (untuk MD5).
-- BCRYPT membutuhkan 60 karakter. Oleh karena itu, kita harus memperlebar 
-- kolom password terlebih dahulu.

ALTER TABLE `data_pegawai` MODIFY `password` VARCHAR(255) NOT NULL;

-- Setelah diperlebar, baru kita update password 'fauzi' menjadi '12345'
UPDATE `data_pegawai`
SET `password` = '$2y$10$R0CpDLofYfV1hgYq5kHFA.sOo8KRWkjrDEeqL/7dXt3NpcQObu/Oq'
WHERE `username` = 'fauzi';

-- Update juga password 'dodi' menjadi '12345' agar bisa dicoba
UPDATE `data_pegawai`
SET `password` = '$2y$10$R0CpDLofYfV1hgYq5kHFA.sOo8KRWkjrDEeqL/7dXt3NpcQObu/Oq'
WHERE `username` = 'dodi';
