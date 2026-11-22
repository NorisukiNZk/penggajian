<?php

class AttendancePolicyTest extends PHPUnit_Framework_TestCase
{
    private function defaultSetting($weekendCsv = '6,7')
    {
        return (object) array(
            'mulai_absen_masuk'     => '06:00:00',
            'jam_masuk'             => '08:00:00',
            'toleransi_menit'       => 15,
            'mulai_absen_pulang'    => '15:00:00',
            'jam_pulang'            => '17:00:00',
            'batas_terlambat_berat' => '09:00:00',
            'hari_libur_mingguan'   => $weekendCsv
        );
    }

    public function testBlocksSaturdayAndSundayWithoutApprovedOvertime()
    {
        $setting = $this->defaultSetting('6,7');

        // 2026-11-21 = Sabtu, 2026-11-22 = Minggu
        $sat = Attendance_policy::evaluateAttendanceGate('2026-11-21', '08:00:00', $setting);
        $this->assertTrue($sat['is_libur']);
        $this->assertEquals('akhir_pekan', $sat['jenis_libur']);
        $this->assertFalse($sat['boleh_absen_masuk']);
        $this->assertFalse($sat['boleh_absen_pulang']);

        $sun = Attendance_policy::evaluateAttendanceGate('2026-11-22', '08:00:00', $setting);
        $this->assertTrue($sun['is_libur']);
        $this->assertEquals('akhir_pekan', $sun['jenis_libur']);
        $this->assertFalse($sun['boleh_absen_masuk']);
        $this->assertFalse($sun['boleh_absen_pulang']);
    }

    public function testBlocksNationalHolidayOnWeekdayWithoutOvertime()
    {
        $setting = $this->defaultSetting('6,7');
        $holiday = (object) array('tanggal' => '2026-08-17', 'keterangan' => 'Hari Kemerdekaan RI');

        $res = Attendance_policy::evaluateAttendanceGate('2026-08-17', '08:00:00', $setting, $holiday);
        $this->assertTrue($res['is_libur']);
        $this->assertEquals('nasional', $res['jenis_libur']);
        $this->assertFalse($res['boleh_absen_masuk']);
        $this->assertTrue(strpos($res['alasan_masuk'], 'Hari Kemerdekaan RI') !== false);
    }

    public function testAllowsWeekendAttendanceWhenOvertimeIsApprovedWithinWindow()
    {
        $setting = $this->defaultSetting('6,7');
        $ot = (object) array(
            'jam_mulai'   => '10:00:00',
            'jam_selesai' => '14:00:00',
            'status'      => 'Disetujui',
            'keterangan'  => 'Jaga shift akhir pekan'
        );

        // Terlalu pagi sebelum H-30 menit (09:30)
        $early = Attendance_policy::evaluateAttendanceGate('2026-11-22', '08:30:00', $setting, null, $ot);
        $this->assertTrue($early['mode_lembur_libur']);
        $this->assertFalse($early['boleh_absen_masuk']);

        // Dalam rentang H-30 menit s/d selesai
        $ok = Attendance_policy::evaluateAttendanceGate('2026-11-22', '09:45:00', $setting, null, $ot);
        $this->assertTrue($ok['mode_lembur_libur']);
        $this->assertTrue($ok['boleh_absen_masuk']);
        $this->assertTrue($ok['boleh_absen_pulang']);
    }

    public function testRejectsPendingOvertimeOnHoliday()
    {
        $setting = $this->defaultSetting('6,7');
        $otPending = (object) array(
            'jam_mulai'   => '10:00:00',
            'jam_selesai' => '14:00:00',
            'status'      => 'Pending',
            'keterangan'  => 'Belum disetujui'
        );

        $res = Attendance_policy::evaluateAttendanceGate('2026-11-22', '10:15:00', $setting, null, $otPending);
        $this->assertFalse($res['mode_lembur_libur']);
        $this->assertFalse($res['boleh_absen_masuk']);
    }

    public function testAllowsRegularWorkdayAndSupportsCustomSixDayWorkweek()
    {
        // Senin normal
        $mon = Attendance_policy::evaluateAttendanceGate('2026-11-23', '08:05:00', $this->defaultSetting('6,7'));
        $this->assertFalse($mon['is_libur']);
        $this->assertTrue($mon['boleh_absen_masuk']);
        $this->assertFalse($mon['boleh_absen_pulang']);

        // Custom 6 hari kerja (hanya Minggu = 7 yang libur): Sabtu diizinkan reguler
        $satWork = Attendance_policy::evaluateAttendanceGate('2026-11-21', '08:05:00', $this->defaultSetting('7'));
        $this->assertFalse($satWork['is_libur']);
        $this->assertTrue($satWork['boleh_absen_masuk']);
    }
}
