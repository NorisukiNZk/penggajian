<?php

class PayrollDiffExplainerTest extends PHPUnit_Framework_TestCase
{
    private function buildSlip(array $overrides = array())
    {
        $base = array(
            'bulan'             => '102026',
            'label_periode'     => 'Oktober 2026',
            'nik'               => '1234567890',
            'nama_pegawai'      => 'Siti Aminah',
            'nama_jabatan'      => 'Perawat',
            'gaji_pokok'        => 3500000.0,
            'tj_transport'      => 300000.0,
            'uang_makan'        => 250000.0,
            'uang_lembur'       => 100000.0,
            'jam_lembur'        => 5,
            'tarif_lembur'      => 20000.0,
            'tunjangan_dinamis' => 150000.0,
            'tunjangan_detail'  => array(
                array('id_komponen' => 1, 'nama_komponen' => 'Tunjangan Medis', 'nominal' => 150000.0, 'is_override' => false, 'is_persentase' => 0)
            ),
            'alpha'             => 0,
            'alpha_rate'        => 100000.0,
            'pot_alpha'         => 0.0,
            'potongan_dinamis'  => 50000.0,
            'potongan_detail'   => array(
                array('id_komponen' => 2, 'nama_komponen' => 'BPJS Kesehatan', 'nominal' => 50000.0, 'is_override' => false, 'is_persentase' => 0)
            ),
            'pot_pinjaman'      => 0.0,
            'pinjaman_detail'   => array()
        );

        $merged = array_merge($base, $overrides);
        $calc = Payroll_calculator::calculateSlip(array(
            'gaji_pokok'        => $merged['gaji_pokok'],
            'tj_transport'      => $merged['tj_transport'],
            'uang_makan'        => $merged['uang_makan'],
            'tunjangan_dinamis' => $merged['tunjangan_dinamis'],
            'uang_lembur'       => $merged['uang_lembur'],
            'alpha'             => $merged['alpha'],
            'alpha_rate'        => $merged['alpha_rate'],
            'potongan_dinamis'  => $merged['potongan_dinamis'],
            'potongan_pinjaman' => $merged['pot_pinjaman']
        ));
        $merged['pot_alpha']       = $calc['pot_alpha'];
        $merged['total_potongan']  = $calc['total_potongan'];
        $merged['gaji_bersih']     = $calc['gaji_bersih'];
        $merged['gaji_bersih_raw'] = $calc['gaji_bersih_raw'];

        return $merged;
    }

    public function testBaselinePeriodWhenNoPreviousSlip()
    {
        $curr = $this->buildSlip(array('bulan' => '112026', 'label_periode' => 'November 2026'));
        $diff = Payroll_diff_explainer::explainEmployeeDiff($curr, null);

        $this->assertFalse($diff['has_previous']);
        $this->assertEquals('baseline', $diff['direction']);
        $this->assertEquals(0.0, $diff['net_delta']);
        $this->assertEmpty($diff['factors']);
        $this->assertTrue($diff['reconciliation_ok']);
        $this->assertNotFalse(strpos($diff['summary_sentence'], 'November 2026'));
    }

    public function testIdenticalPeriodsProduceZeroDiff()
    {
        $prev = $this->buildSlip(array('bulan' => '102026', 'label_periode' => 'Oktober 2026'));
        $curr = $this->buildSlip(array('bulan' => '112026', 'label_periode' => 'November 2026'));

        $diff = Payroll_diff_explainer::explainEmployeeDiff($curr, $prev);

        $this->assertTrue($diff['has_previous']);
        $this->assertEquals('same', $diff['direction']);
        $this->assertEquals(0.0, $diff['net_delta']);
        $this->assertEmpty($diff['factors']);
        $this->assertTrue($diff['reconciliation_ok']);
        $this->assertNotFalse(strpos($diff['summary_sentence'], 'tetap sama'));
    }

    public function testMixedDecreaseExplainsLoanAlphaAndOvertimeWithExactReconciliation()
    {
        $prev = $this->buildSlip(array(
            'bulan'         => '102026',
            'label_periode' => 'Oktober 2026',
            'uang_lembur'   => 120000.0,
            'jam_lembur'    => 6,
            'alpha'         => 0,
            'pot_pinjaman'  => 0.0
        ));

        $curr = $this->buildSlip(array(
            'bulan'           => '112026',
            'label_periode'   => 'November 2026',
            'uang_lembur'     => 60000.0,
            'jam_lembur'      => 3,
            'alpha'           => 1,
            'pot_pinjaman'    => 250000.0,
            'pinjaman_detail' => array(
                array('keterangan' => 'Potongan Pinjaman (Cicilan 1/6)', 'nominal' => 250000.0)
            )
        ));

        $diff = Payroll_diff_explainer::explainEmployeeDiff($curr, $prev);

        $this->assertEquals('down', $diff['direction']);
        // -60k (lembur) -100k (alpha) -250k (pinjaman) = -410k
        $this->assertEquals(-410000.0, $diff['net_delta']);
        $this->assertTrue($diff['reconciliation_ok']);
        $this->assertCount(3, $diff['factors']);

        // Sorted by absolute impact descending: pinjaman (-250k), alpha (-100k), lembur (-60k)
        $this->assertEquals('pot_pinjaman', $diff['factors'][0]['key']);
        $this->assertEquals(-250000.0, $diff['factors'][0]['impact_on_net']);
        $this->assertEquals('pot_alpha', $diff['factors'][1]['key']);
        $this->assertEquals(-100000.0, $diff['factors'][1]['impact_on_net']);
        $this->assertEquals('uang_lembur', $diff['factors'][2]['key']);
        $this->assertEquals(-60000.0, $diff['factors'][2]['impact_on_net']);

        $this->assertNotFalse(strpos($diff['summary_sentence'], 'turun Rp 410.000'));
        $this->assertNotFalse(strpos($diff['factors'][0]['reason'], 'Cicilan 1/6'));
        $this->assertNotFalse(strpos($diff['factors'][1]['reason'], '1 hari alpha'));
        $this->assertNotFalse(strpos($diff['factors'][2]['reason'], 'berkurang 3 jam'));
    }

    public function testOffsettingChangesKeepNetZeroButListBothFactors()
    {
        $prev = $this->buildSlip(array(
            'bulan'         => '102026',
            'label_periode' => 'Oktober 2026',
            'uang_lembur'   => 0.0,
            'jam_lembur'    => 0,
            'alpha'         => 0
        ));

        $curr = $this->buildSlip(array(
            'bulan'         => '112026',
            'label_periode' => 'November 2026',
            'uang_lembur'   => 100000.0,
            'jam_lembur'    => 5,
            'alpha'         => 1
        ));

        $diff = Payroll_diff_explainer::explainEmployeeDiff($curr, $prev);

        $this->assertEquals('same', $diff['direction']);
        $this->assertEquals(0.0, $diff['net_delta']);
        $this->assertEquals(100000.0, $diff['positive_total']);
        $this->assertEquals(-100000.0, $diff['negative_total']);
        $this->assertCount(2, $diff['factors']);
        $this->assertTrue($diff['reconciliation_ok']);
        $this->assertNotFalse(strpos($diff['summary_sentence'], 'saling mengimbangi'));
    }

    public function testDynamicAllowanceAndDeductionChangesDetectedByName()
    {
        $prev = $this->buildSlip(array(
            'bulan'             => '102026',
            'label_periode'     => 'Oktober 2026',
            'tunjangan_dinamis' => 150000.0,
            'tunjangan_detail'  => array(
                array('id_komponen' => 1, 'nama_komponen' => 'Tunjangan Medis', 'nominal' => 150000.0, 'is_override' => false)
            ),
            'potongan_dinamis'  => 50000.0,
            'potongan_detail'   => array(
                array('id_komponen' => 2, 'nama_komponen' => 'BPJS Kesehatan', 'nominal' => 50000.0, 'is_override' => false)
            )
        ));

        $curr = $this->buildSlip(array(
            'bulan'             => '112026',
            'label_periode'     => 'November 2026',
            'tunjangan_dinamis' => 350000.0,
            'tunjangan_detail'  => array(
                array('id_komponen' => 1, 'nama_komponen' => 'Tunjangan Medis', 'nominal' => 200000.0, 'is_override' => true),
                array('id_komponen' => 3, 'nama_komponen' => 'Insentif Jaga', 'nominal' => 150000.0, 'is_override' => false)
            ),
            'potongan_dinamis'  => 0.0,
            'potongan_detail'   => array()
        ));

        $diff = Payroll_diff_explainer::explainEmployeeDiff($curr, $prev);

        // +50k (Tunjangan Medis) +150k (Insentif Jaga) +50k (BPJS berakhir) = +250k
        $this->assertEquals('up', $diff['direction']);
        $this->assertEquals(250000.0, $diff['net_delta']);
        $this->assertCount(3, $diff['factors']);
        $this->assertTrue($diff['reconciliation_ok']);
    }

    public function testClinicPeriodDiffHandlesHeadcountAndSameStoreDrivers()
    {
        $empA_prev = $this->buildSlip(array(
            'bulan' => '102026', 'label_periode' => 'Oktober 2026',
            'nik' => '1001', 'nama_pegawai' => 'dr. Budi', 'uang_lembur' => 0.0, 'jam_lembur' => 0, 'alpha' => 2
        ));
        $empB_prev = $this->buildSlip(array(
            'bulan' => '102026', 'label_periode' => 'Oktober 2026',
            'nik' => '1002', 'nama_pegawai' => 'Rina (Resign)', 'gaji_pokok' => 2500000.0
        ));

        $empA_curr = $this->buildSlip(array(
            'bulan' => '112026', 'label_periode' => 'November 2026',
            'nik' => '1001', 'nama_pegawai' => 'dr. Budi', 'uang_lembur' => 160000.0, 'jam_lembur' => 8, 'alpha' => 0
        ));
        $empC_curr = $this->buildSlip(array(
            'bulan' => '112026', 'label_periode' => 'November 2026',
            'nik' => '1003', 'nama_pegawai' => 'Dina (Baru)', 'gaji_pokok' => 3000000.0
        ));

        $prev_period = array(
            'bulan' => '102026', 'label_periode' => 'Oktober 2026',
            'slips' => array('1001' => $empA_prev, '1002' => $empB_prev)
        );
        $curr_period = array(
            'bulan' => '112026', 'label_periode' => 'November 2026',
            'slips' => array('1001' => $empA_curr, '1003' => $empC_curr)
        );

        $clinic_diff = Payroll_diff_explainer::explainClinicPeriodDiff($curr_period, $prev_period);

        $this->assertTrue($clinic_diff['has_previous']);
        $this->assertTrue($clinic_diff['reconciliation_ok']);
        $this->assertEquals('up', $clinic_diff['direction']);
        // empA delta: +160k lembur +200k alpha reduction = +360k
        // headcount: +empC_curr (3.75M) - empB_prev (3.25M) = +500k => total clinic delta = +860k
        $this->assertEquals(860000.0, $clinic_diff['net_delta']);
        $this->assertArrayHasKey('1001', $clinic_diff['employee_diffs']);
        $this->assertArrayHasKey('1003', $clinic_diff['employee_diffs']);
        $this->assertTrue($clinic_diff['employee_diffs']['1003']['is_new_in_period']);
        $this->assertGreaterThanOrEqual(2, count($clinic_diff['top_movers']));
        $this->assertNotFalse(strpos($clinic_diff['summary_sentence'], 'naik Rp 860.000'));
    }
}
