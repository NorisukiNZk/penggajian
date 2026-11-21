<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Layanan murni perhitungan payroll, pengurutan periode, dan sanitasi CSV.
 * Dibuat independen dari framework CI3 agar dapat diuji unit secara langsung.
 */
class Payroll_calculator
{
    public static function extractAlphaRate($potongan_rows)
    {
        $rate = 0;
        if (is_array($potongan_rows)) {
            foreach ($potongan_rows as $p) {
                $name = is_object($p) ? (isset($p->potongan) ? $p->potongan : '') : (isset($p['potongan']) ? $p['potongan'] : '');
                $amt  = is_object($p) ? (isset($p->jml_potongan) ? $p->jml_potongan : 0) : (isset($p['jml_potongan']) ? $p['jml_potongan'] : 0);
                if (strtolower(trim((string)$name)) === 'alpha') {
                    $rate = (float)$amt;
                    break;
                }
            }
        }
        return $rate;
    }

    public static function resolveKomponenItem($komponen, $gaji_pokok, $override_nominal = null)
    {
        $is_persen  = is_object($komponen) ? ((int)$komponen->is_persentase === 1) : (!empty($komponen['is_persentase']));
        $raw_val    = is_object($komponen) ? (float)$komponen->nominal : (float)$komponen['nominal'];
        $id_komp    = is_object($komponen) ? (int)$komponen->id_komponen : (int)$komponen['id_komponen'];
        $nama_komp  = is_object($komponen) ? (string)$komponen->nama_komponen : (string)$komponen['nama_komponen'];
        $tipe_komp  = is_object($komponen) ? (string)$komponen->tipe : (string)$komponen['tipe'];

        if ($override_nominal !== null) {
            $nominal = (float)$override_nominal;
            $is_override = true;
        } elseif ($is_persen) {
            $nominal = ((float)$gaji_pokok * $raw_val) / 100;
            $is_override = false;
        } else {
            $nominal = $raw_val;
            $is_override = false;
        }

        return array(
            'id_komponen'   => $id_komp,
            'nama_komponen' => $nama_komp,
            'tipe'          => $tipe_komp,
            'nominal'       => $nominal,
            'persen_raw'    => $is_persen ? $raw_val : null,
            'is_persentase' => $is_persen ? 1 : 0,
            'is_override'   => $is_override
        );
    }

    public static function calculateSlip(array $input)
    {
        $gaji_pokok       = (float)(isset($input['gaji_pokok']) ? $input['gaji_pokok'] : 0);
        $tj_transport     = (float)(isset($input['tj_transport']) ? $input['tj_transport'] : 0);
        $uang_makan       = (float)(isset($input['uang_makan']) ? $input['uang_makan'] : 0);
        $tj_dinamis       = (float)(isset($input['tunjangan_dinamis']) ? $input['tunjangan_dinamis'] : 0);
        $uang_lembur      = (float)(isset($input['uang_lembur']) ? $input['uang_lembur'] : 0);
        $alpha_days       = max(0, (int)(isset($input['alpha']) ? $input['alpha'] : 0));
        $alpha_rate       = max(0.0, (float)(isset($input['alpha_rate']) ? $input['alpha_rate'] : 0));
        $pot_dinamis      = (float)(isset($input['potongan_dinamis']) ? $input['potongan_dinamis'] : 0);
        $pot_pinjaman     = (float)(isset($input['potongan_pinjaman']) ? $input['potongan_pinjaman'] : 0);

        $gaji_dasar      = $gaji_pokok + $tj_transport + $uang_makan;
        $total_tunjangan = $tj_transport + $uang_makan + $tj_dinamis;
        $pot_alpha       = $alpha_days * $alpha_rate;
        $total_potongan  = $pot_alpha + $pot_dinamis + $pot_pinjaman;

        $gaji_bersih_raw = $gaji_pokok + $total_tunjangan + $uang_lembur - $total_potongan;
        $gaji_bersih     = max(0.0, $gaji_bersih_raw);

        return array(
            'gaji_pokok'        => $gaji_pokok,
            'tj_transport'      => $tj_transport,
            'uang_makan'        => $uang_makan,
            'gaji_dasar'        => $gaji_dasar,
            'tunjangan_dinamis' => $tj_dinamis,
            'uang_lembur'       => $uang_lembur,
            'total_tunjangan'   => $total_tunjangan,
            'pot_alpha'         => $pot_alpha,
            'potongan_dinamis'  => $pot_dinamis,
            'potongan_pinjaman' => $pot_pinjaman,
            'total_potongan'    => $total_potongan,
            'gaji_bersih_raw'   => $gaji_bersih_raw,
            'gaji_bersih'       => $gaji_bersih
        );
    }

    public static function periodToSortableInt($mmyyyy)
    {
        $s = trim((string)$mmyyyy);
        if (strlen($s) !== 6 || !ctype_digit($s)) {
            return 0;
        }
        $bulan = (int)substr($s, 0, 2);
        $tahun = (int)substr($s, 2, 4);
        return ($tahun * 100) + $bulan;
    }

    public static function sortPeriodsDesc(array $periodes)
    {
        usort($periodes, function ($a, $b) {
            $pa = is_object($a) ? $a->bulan : (is_array($a) ? $a['bulan'] : (string)$a);
            $pb = is_object($b) ? $b->bulan : (is_array($b) ? $b['bulan'] : (string)$b);
            $va = self::periodToSortableInt($pa);
            $vb = self::periodToSortableInt($pb);
            if ($va === $vb) {
                return 0;
            }
            return ($va > $vb) ? -1 : 1;
        });
        return $periodes;
    }

    public static function formatPeriodLabel($mmyyyy, $short = false)
    {
        $nama_full = array(
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        );
        $nama_short = array(
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agt',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
        );

        $s = str_pad(trim((string)$mmyyyy), 6, '0', STR_PAD_LEFT);
        $b = substr($s, 0, 2);
        $y = substr($s, 2, 4);
        $map = $short ? $nama_short : $nama_full;
        return (isset($map[$b]) ? $map[$b] : $b) . ' ' . $y;
    }

    public static function sanitizeCsvCell($val)
    {
        $str = (string)$val;
        if ($str !== '' && in_array($str[0], array('=', '+', '-', '@', "\t", "\r"), true)) {
            return "'" . $str;
        }
        return $str;
    }
}
