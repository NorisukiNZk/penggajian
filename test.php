<?php
$conn = new mysqli('localhost', 'root', '', 'penggajian');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS `hari_libur` (
  `id_libur` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_libur`),
  UNIQUE KEY `idx_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "BERHASIL CREATE TABLE hari_libur!\n";
    
    // Insert some sample data for August 2026 and current month
    $conn->query("INSERT IGNORE INTO hari_libur (tanggal, keterangan) VALUES ('2026-08-17', 'Hari Kemerdekaan RI')");
    $conn->query("INSERT IGNORE INTO hari_libur (tanggal, keterangan) VALUES ('".date('Y')."-12-25', 'Hari Raya Natal')");
    $conn->query("INSERT IGNORE INTO hari_libur (tanggal, keterangan) VALUES ('".date('Y')."-01-01', 'Tahun Baru')");
} else {
    echo "ERROR: " . $conn->error . "\n";
}

$conn->close();
?>
