<?php

class PayrollCalculatorTest extends PHPUnit_Framework_TestCase
{
    public function testCalculateSlipBasicNetPay()
    {
        $res = Payroll_calculator::calculateSlip(array(
            'gaji_pokok'        => 3500000,
            'tj_transport'      => 300000,
            'uang_makan'        => 250000,
            'tunjangan_dinamis' => 150000,
            'uang_lembur'       => 200000,
            'alpha'             => 2,
            'alpha_rate'        => 100000,
            'potongan_dinamis'  => 50000,
            'potongan_pinjaman' => 250000
        ));

        $this->assertEquals(4050000, $res['gaji_dasar']);
        $this->assertEquals(700000, $res['total_tunjangan']);
        $this->assertEquals(200000, $res['pot_alpha']);
        $this->assertEquals(500000, $res['total_potongan']);
        $this->assertEquals(3900000, $res['gaji_bersih_raw']);
        $this->assertEquals(3900000, $res['gaji_bersih']);
    }

    public function testCalculateSlipClampsNegativePayToZero()
    {
        $res = Payroll_calculator::calculateSlip(array(
            'gaji_pokok'        => 1000000,
            'tj_transport'      => 0,
            'uang_makan'        => 0,
            'alpha'             => 10,
            'alpha_rate'        => 200000
        ));

        $this->assertLessThan(0, $res['gaji_bersih_raw']);
        $this->assertEquals(0.0, $res['gaji_bersih']);
    }

    public function testResolveKomponenPercentageAndOverride()
    {
        $komponen = (object) array(
            'id_komponen'   => 7,
            'nama_komponen' => 'BPJS Kesehatan',
            'tipe'          => 'potongan',
            'nominal'       => 1.5,
            'is_persentase' => 1
        );

        $pct = Payroll_calculator::resolveKomponenItem($komponen, 4000000, null);
        $this->assertEquals(60000.0, $pct['nominal']);
        $this->assertEquals(1.5, $pct['persen_raw']);
        $this->assertFalse($pct['is_override']);

        $ovr = Payroll_calculator::resolveKomponenItem($komponen, 4000000, 95000);
        $this->assertEquals(95000.0, $ovr['nominal']);
        $this->assertTrue($ovr['is_override']);
    }

    public function testExtractAlphaRateMatchesCaseInsensitive()
    {
        $rows = array(
            (object) array('potongan' => 'Terlambat', 'jml_potongan' => 25000),
            (object) array('potongan' => ' alpha ', 'jml_potongan' => 125000),
        );
        $this->assertEquals(125000.0, Payroll_calculator::extractAlphaRate($rows));
    }

    public function testSortPeriodsDescOrdersChronologicallyNotAlphabetically()
    {
        $rows = array(
            (object) array('bulan' => '092026'),
            (object) array('bulan' => '012026'),
            (object) array('bulan' => '122025'),
            (object) array('bulan' => '022026'),
        );
        $sorted = Payroll_calculator::sortPeriodsDesc($rows);

        $this->assertEquals('092026', $sorted[0]->bulan);
        $this->assertEquals('022026', $sorted[1]->bulan);
        $this->assertEquals('012026', $sorted[2]->bulan);
        $this->assertEquals('122025', $sorted[3]->bulan);
    }

    public function testSanitizeCsvCellPreventsFormulaInjection()
    {
        $this->assertEquals("'=SUM(A1:A2)", Payroll_calculator::sanitizeCsvCell('=SUM(A1:A2)'));
        $this->assertEquals("'+cmd", Payroll_calculator::sanitizeCsvCell('+cmd'));
        $this->assertEquals("'-cmd", Payroll_calculator::sanitizeCsvCell('-cmd'));
        $this->assertEquals("'@cmd", Payroll_calculator::sanitizeCsvCell('@cmd'));
        $this->assertEquals('Dr. H.M. Hidayatullah', Payroll_calculator::sanitizeCsvCell('Dr. H.M. Hidayatullah'));
    }
}
