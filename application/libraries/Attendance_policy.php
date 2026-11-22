<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Aturan murni kalender kerja, hari libur akhir pekan/nasional, dan gerbang absensi
 * (termasuk pengecualian khusus untuk jadwal lembur disetujui pada hari libur).
 */
class Attendance_policy
{
    public static $dayNamesId = array(
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    );

    /**
     * Parse konfigurasi hari libur mingguan (format CSV ISO-8601, misal "6,7" = Sabtu & Minggu).
     * Fallback aman ke [6, 7] jika kosong atau belum termigrasi.
     */
    public static function parseWeekendDays($setting)
    {
        $raw = null;
        if (is_object($setting) && isset($setting->hari_libur_mingguan)) {
            $raw = trim((string)$setting->hari_libur_mingguan);
        } elseif (is_array($setting) && isset($setting['hari_libur_mingguan'])) {
            $raw = trim((string)$setting['hari_libur_mingguan']);
        } elseif (is_string($setting)) {
            $raw = trim($setting);
        }

        if ($raw === null || $raw === '') {
            return array(6, 7);
        }

        $days = array();
        foreach (explode(',', $raw) as $part) {
            $n = (int)trim($part);
            if ($n >= 1 && $n <= 7) {
                $days[$n] = $n;
            }
        }
        if (empty($days)) {
            return array(6, 7);
        }
        ksort($days);
        return array_values($days);
    }

    /**
     * Format daftar nomor hari [6, 7] menjadi label manusia ("Sabtu & Minggu").
     */
    public static function formatWeekendLabel(array $days)
    {
        $names = array();
        foreach ($days as $d) {
            if (isset(self::$dayNamesId[$d])) {
                $names[] = self::$dayNamesId[$d];
            }
        }
        if (empty($names)) {
            return 'Tidak ada';
        }
        if (count($names) === 1) {
            return $names[0];
        }
        $last = array_pop($names);
        return implode(', ', $names) . ' & ' . $last;
    }

    /**
     * Cek apakah suatu tanggal (Y-m-d) jatuh pada hari libur mingguan atau tanggal merah nasional.
     */
    public static function evaluateHoliday($tanggal, $setting = null, $holidayRow = null)
    {
        $ts = strtotime($tanggal);
        $isoDay = (int)date('N', $ts);
        $dayName = isset(self::$dayNamesId[$isoDay]) ? self::$dayNamesId[$isoDay] : '';
        $weekendDays = self::parseWeekendDays($setting);

        if ($holidayRow) {
            $ket = is_object($holidayRow) ? (string)$holidayRow->keterangan : (string)(isset($holidayRow['keterangan']) ? $holidayRow['keterangan'] : 'Hari Libur Nasional');
            return array(
                'is_libur'   => true,
                'jenis'      => 'nasional',
                'hari'       => $dayName,
                'keterangan' => 'Tanggal Merah: ' . $ket
            );
        }

        if (in_array($isoDay, $weekendDays, true)) {
            return array(
                'is_libur'   => true,
                'jenis'      => 'akhir_pekan',
                'hari'       => $dayName,
                'keterangan' => 'Hari Libur Akhir Pekan (' . $dayName . ')'
            );
        }

        return array(
            'is_libur'   => false,
            'jenis'      => null,
            'hari'       => $dayName,
            'keterangan' => 'Hari Kerja'
        );
    }

    /**
     * Evaluasi lengkap gerbang absensi masuk & pulang untuk tanggal + jam tertentu.
     * Pada hari libur, absensi ditutup KECUALI ada jadwal data_lembur berstatus Disetujui.
     */
    public static function evaluateAttendanceGate($tanggal, $jamSekarang, $setting, $holidayRow = null, $approvedOvertime = null)
    {
        $holiday = self::evaluateHoliday($tanggal, $setting, $holidayRow);

        $mulaiMasuk  = (is_object($setting) && !empty($setting->mulai_absen_masuk)) ? $setting->mulai_absen_masuk : '06:00:00';
        $batasBerat  = (is_object($setting) && !empty($setting->batas_terlambat_berat)) ? $setting->batas_terlambat_berat : '09:00:00';
        $mulaiPulang = (is_object($setting) && !empty($setting->mulai_absen_pulang)) ? $setting->mulai_absen_pulang : '15:00:00';

        // 1. Jika Hari Libur (Akhir Pekan atau Tanggal Merah)
        if ($holiday['is_libur']) {
            $hasOvertime = false;
            $otMulai = null;
            $otSelesai = null;
            $otKet = '';

            if (is_object($approvedOvertime) && isset($approvedOvertime->status) && $approvedOvertime->status === 'Disetujui') {
                $hasOvertime = true;
                $otMulai     = $approvedOvertime->jam_mulai;
                $otSelesai   = $approvedOvertime->jam_selesai;
                $otKet       = isset($approvedOvertime->keterangan) ? (string)$approvedOvertime->keterangan : '';
            } elseif (is_array($approvedOvertime) && isset($approvedOvertime['status']) && $approvedOvertime['status'] === 'Disetujui') {
                $hasOvertime = true;
                $otMulai     = $approvedOvertime['jam_mulai'];
                $otSelesai   = $approvedOvertime['jam_selesai'];
                $otKet       = isset($approvedOvertime['keterangan']) ? (string)$approvedOvertime['keterangan'] : '';
            }

            if (!$hasOvertime) {
                return array(
                    'is_libur'          => true,
                    'jenis_libur'       => $holiday['jenis'],
                    'keterangan_libur'  => $holiday['keterangan'],
                    'mode_lembur_libur' => false,
                    'lembur'            => null,
                    'boleh_absen_masuk' => false,
                    'boleh_absen_pulang'=> false,
                    'alasan_masuk'      => 'Absensi ditutup karena hari ini adalah ' . $holiday['keterangan'] . '.',
                    'alasan_pulang'     => 'Absensi pulang tidak aktif pada ' . $holiday['keterangan'] . '.'
                );
            }

            // Pengecualian Lembur Disetujui pada Hari Libur:
            // Gerbang masuk buka 30 menit sebelum jam_mulai lembur s/d jam_selesai (atau 23:59:59 jika lintas tengah malam)
            $mulaiTs = strtotime($tanggal . ' ' . $otMulai);
            $bukaLembur = date('H:i:s', max(strtotime($tanggal . ' 00:00:00'), $mulaiTs - 1800));
            $tutupLembur = ($otSelesai > $otMulai) ? $otSelesai : '23:59:59';

            $bolehMasuk = ($jamSekarang >= $bukaLembur && $jamSekarang <= $tutupLembur);
            $alasanMasuk = '';
            if (!$bolehMasuk) {
                if ($jamSekarang < $bukaLembur) {
                    $alasanMasuk = 'Absen masuk lembur hari libur dibuka mulai pukul ' . substr($bukaLembur, 0, 5) . ' WITA (30 menit sebelum jadwal ' . substr($otMulai, 0, 5) . ').';
                } else {
                    $alasanMasuk = 'Jadwal lembur hari libur (' . substr($otMulai, 0, 5) . ' - ' . substr($otSelesai, 0, 5) . ' WITA) telah berakhir.';
                }
            }

            return array(
                'is_libur'          => true,
                'jenis_libur'       => $holiday['jenis'],
                'keterangan_libur'  => $holiday['keterangan'],
                'mode_lembur_libur' => true,
                'lembur'            => array(
                    'jam_mulai'   => $otMulai,
                    'jam_selesai' => $otSelesai,
                    'buka_masuk'  => $bukaLembur,
                    'keterangan'  => $otKet
                ),
                'boleh_absen_masuk' => $bolehMasuk,
                'boleh_absen_pulang'=> true,
                'alasan_masuk'      => $alasanMasuk,
                'alasan_pulang'     => ''
            );
        }

        // 2. Hari Kerja Normal
        $bolehMasuk = ($jamSekarang >= $mulaiMasuk && $jamSekarang <= $batasBerat);
        $alasanMasuk = '';
        if (!$bolehMasuk) {
            if ($jamSekarang < $mulaiMasuk) {
                $alasanMasuk = 'Belum waktunya masuk (dibuka jam ' . substr($mulaiMasuk, 0, 5) . ' WITA).';
            } else {
                $alasanMasuk = 'Gerbang absen masuk ditutup (batas ' . substr($batasBerat, 0, 5) . ' WITA).';
            }
        }

        $bolehPulang = ($jamSekarang >= $mulaiPulang);
        $alasanPulang = $bolehPulang ? '' : 'Absen pulang dibuka jam ' . substr($mulaiPulang, 0, 5) . ' WITA.';

        return array(
            'is_libur'          => false,
            'jenis_libur'       => null,
            'keterangan_libur'  => '',
            'mode_lembur_libur' => false,
            'lembur'            => null,
            'boleh_absen_masuk' => $bolehMasuk,
            'boleh_absen_pulang'=> $bolehPulang,
            'alasan_masuk'      => $alasanMasuk,
            'alasan_pulang'     => $alasanPulang
        );
    }
}
