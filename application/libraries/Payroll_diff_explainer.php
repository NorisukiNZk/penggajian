<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mesin analisis dan penjelas selisih gaji otomatis (Month-over-Month Payroll Diff Explainer).
 * Membandingkan slip gaji periode berjalan terhadap periode sebelumnya secara deterministik
 * dan menghasilkan ringkasan kalimat bahasa Indonesia beserta rincian dampak per komponen.
 */
class Payroll_diff_explainer
{
    /**
     * Format nominal Rupiah standar Indonesia tanpa desimal.
     */
    public static function formatRupiah($amount, $with_sign = false)
    {
        $val = (float)$amount;
        $abs = abs($val);
        $formatted = 'Rp ' . number_format($abs, 0, ',', '.');
        if ($with_sign) {
            if ($val > 0.0001) {
                return '+' . $formatted;
            }
            if ($val < -0.0001) {
                return '-' . $formatted;
            }
            return 'Rp 0';
        }
        return ($val < -0.0001 ? '-' : '') . $formatted;
    }

    /**
     * Format angka persentase perubahan yang mudah dibaca.
     */
    public static function formatPercent($pct)
    {
        if ($pct === null) {
            return '';
        }
        $val = round((float)$pct, 1);
        $sign = $val > 0 ? '+' : '';
        return $sign . number_format($val, 1, ',', '.') . '%';
    }

    /**
     * Normalisasi label periode MMYYYY menjadi nama bulan Indonesia.
     */
    private static function resolvePeriodLabel(array $slip)
    {
        if (!empty($slip['label_periode'])) {
            return (string)$slip['label_periode'];
        }
        $bulan = isset($slip['bulan']) ? (string)$slip['bulan'] : '';
        if ($bulan !== '' && class_exists('Payroll_calculator', false)) {
            return Payroll_calculator::formatPeriodLabel($bulan, false);
        }
        return $bulan !== '' ? $bulan : 'Periode Ini';
    }

    /**
     * Bangun peta komponen dinamis berbasis nama (case-insensitive) agar perbandingan stabil
     * walau urutan array berbeda antar periode.
     */
    private static function indexDynamicItems($items)
    {
        $map = array();
        if (!is_array($items)) {
            return $map;
        }
        foreach ($items as $item) {
            $name = isset($item['nama_komponen']) ? trim((string)$item['nama_komponen']) : '';
            if ($name === '') {
                continue;
            }
            $key = strtolower($name);
            if (!isset($map[$key])) {
                $map[$key] = array(
                    'nama_komponen' => $name,
                    'nominal'       => 0.0,
                    'is_override'   => !empty($item['is_override']),
                    'is_persentase' => !empty($item['is_persentase'])
                );
            }
            $map[$key]['nominal'] += (float)(isset($item['nominal']) ? $item['nominal'] : 0);
            if (!empty($item['is_override'])) {
                $map[$key]['is_override'] = true;
            }
        }
        return $map;
    }

    /**
     * Gabungkan deskripsi cicilan pinjaman aktif menjadi string ringkas.
     */
    private static function summarizeLoanDetail($details)
    {
        if (!is_array($details) || empty($details)) {
            return '';
        }
        $labels = array();
        foreach ($details as $d) {
            $ket = isset($d['keterangan']) ? trim((string)$d['keterangan']) : '';
            if ($ket !== '') {
                $labels[] = $ket;
            }
        }
        return implode(', ', $labels);
    }

    /**
     * Gabungkan potongan frasa dengan konjungsi bahasa Indonesia yang alami.
     */
    private static function joinPhrasesId(array $phrases)
    {
        $count = count($phrases);
        if ($count === 0) {
            return '';
        }
        if ($count === 1) {
            return $phrases[0];
        }
        if ($count === 2) {
            return $phrases[0] . ' dan ' . $phrases[1];
        }
        $last = array_pop($phrases);
        return implode(', ', $phrases) . ', serta ' . $last;
    }

    /**
     * Menjelaskan perubahan slip gaji 1 pegawai antara periode berjalan ($current)
     * dan periode sebelumnya ($previous).
     */
    public static function explainEmployeeDiff(array $current, $previous = null)
    {
        $curr_label = self::resolvePeriodLabel($current);
        $curr_net   = (float)(isset($current['gaji_bersih_raw']) ? $current['gaji_bersih_raw'] : (isset($current['gaji_bersih']) ? $current['gaji_bersih'] : 0));

        if (!is_array($previous) || empty($previous)) {
            return array(
                'has_previous'       => false,
                'direction'          => 'baseline',
                'current_period'     => isset($current['bulan']) ? (string)$current['bulan'] : '',
                'current_label'      => $curr_label,
                'previous_period'    => null,
                'previous_label'     => null,
                'current_net'        => $curr_net,
                'previous_net'       => null,
                'net_delta'          => 0.0,
                'net_delta_pct'      => null,
                'positive_total'     => 0.0,
                'negative_total'     => 0.0,
                'headline'           => 'Periode Awal Tercatat',
                'summary_sentence'   => 'Belum ada data slip periode sebelumnya untuk dibandingkan. Rincian periode ' . $curr_label . ' (' . self::formatRupiah($curr_net) . ') menjadi acuan awal.',
                'short_reason'       => 'Periode pertama tercatat pada riwayat gaji.',
                'factors'            => array(),
                'reconciliation_ok'  => true
            );
        }

        $prev_label = self::resolvePeriodLabel($previous);
        $prev_net   = (float)(isset($previous['gaji_bersih_raw']) ? $previous['gaji_bersih_raw'] : (isset($previous['gaji_bersih']) ? $previous['gaji_bersih'] : 0));
        $net_delta  = round($curr_net - $prev_net, 2);
        $net_pct    = (abs($prev_net) > 0.0001) ? round(($net_delta / abs($prev_net)) * 100, 1) : null;

        $factors = array();

        // 1. Komponen Tetap (Gaji Pokok, Tunjangan Transport, Uang Makan)
        $fixed_fields = array(
            'gaji_pokok'   => 'Gaji Pokok',
            'tj_transport' => 'Tunjangan Transport',
            'uang_makan'   => 'Uang Makan'
        );
        foreach ($fixed_fields as $field => $label) {
            $p_val = (float)(isset($previous[$field]) ? $previous[$field] : 0);
            $c_val = (float)(isset($current[$field]) ? $current[$field] : 0);
            $diff  = round($c_val - $p_val, 2);
            if (abs($diff) >= 0.01) {
                $verb = $diff > 0 ? 'naik' : 'turun';
                $factors[] = array(
                    'key'           => $field,
                    'category'      => 'earning',
                    'label'         => $label,
                    'prev_amount'   => $p_val,
                    'curr_amount'   => $c_val,
                    'delta_amount'  => $diff,
                    'impact_on_net' => $diff,
                    'reason'        => $label . ' ' . $verb . ' dari ' . self::formatRupiah($p_val) . ' menjadi ' . self::formatRupiah($c_val),
                    'short_clause'  => strtolower($label) . ' ' . $verb . ' (' . self::formatRupiah($diff, true) . ')'
                );
            }
        }

        // 2. Uang Lembur (konteks durasi jam)
        $p_lembur = (float)(isset($previous['uang_lembur']) ? $previous['uang_lembur'] : 0);
        $c_lembur = (float)(isset($current['uang_lembur']) ? $current['uang_lembur'] : 0);
        $p_jam    = (int)(isset($previous['jam_lembur']) ? $previous['jam_lembur'] : 0);
        $c_jam    = (int)(isset($current['jam_lembur']) ? $current['jam_lembur'] : 0);
        $d_lembur = round($c_lembur - $p_lembur, 2);
        if (abs($d_lembur) >= 0.01) {
            $d_jam = $c_jam - $p_jam;
            if ($p_lembur <= 0 && $c_lembur > 0) {
                $reason = 'Ada lembur terverifikasi sebanyak ' . $c_jam . ' jam bulan ini';
                $clause = 'tambahan lembur ' . $c_jam . ' jam (' . self::formatRupiah($d_lembur, true) . ')';
            } elseif ($p_lembur > 0 && $c_lembur <= 0) {
                $reason = 'Tidak ada jam lembur bulan ini (periode lalu ' . $p_jam . ' jam)';
                $clause = 'tidak ada lembur bulan ini (' . self::formatRupiah($d_lembur, true) . ')';
            } elseif ($d_jam > 0) {
                $reason = 'Jam lembur bertambah ' . $d_jam . ' jam (' . $p_jam . ' jam menjadi ' . $c_jam . ' jam)';
                $clause = 'jam lembur bertambah ' . $d_jam . ' jam (' . self::formatRupiah($d_lembur, true) . ')';
            } elseif ($d_jam < 0) {
                $reason = 'Jam lembur berkurang ' . abs($d_jam) . ' jam (' . $p_jam . ' jam menjadi ' . $c_jam . ' jam)';
                $clause = 'jam lembur berkurang ' . abs($d_jam) . ' jam (' . self::formatRupiah($d_lembur, true) . ')';
            } else {
                $verb = $d_lembur > 0 ? 'naik' : 'turun';
                $reason = 'Tarif lembur ' . $verb . ' untuk ' . $c_jam . ' jam lembur';
                $clause = 'perubahan tarif lembur (' . self::formatRupiah($d_lembur, true) . ')';
            }

            $factors[] = array(
                'key'           => 'uang_lembur',
                'category'      => 'earning',
                'label'         => 'Uang Lembur',
                'prev_amount'   => $p_lembur,
                'curr_amount'   => $c_lembur,
                'delta_amount'  => $d_lembur,
                'impact_on_net' => $d_lembur,
                'reason'        => $reason,
                'short_clause'  => $clause
            );
        }

        // 3. Tunjangan Dinamis (per nama komponen)
        $p_tj_map = self::indexDynamicItems(isset($previous['tunjangan_detail']) ? $previous['tunjangan_detail'] : array());
        $c_tj_map = self::indexDynamicItems(isset($current['tunjangan_detail']) ? $current['tunjangan_detail'] : array());
        $all_tj_keys = array_unique(array_merge(array_keys($p_tj_map), array_keys($c_tj_map)));
        foreach ($all_tj_keys as $k) {
            $p_item = isset($p_tj_map[$k]) ? $p_tj_map[$k] : array('nama_komponen' => $c_tj_map[$k]['nama_komponen'], 'nominal' => 0.0, 'is_override' => false);
            $c_item = isset($c_tj_map[$k]) ? $c_tj_map[$k] : array('nama_komponen' => $p_tj_map[$k]['nama_komponen'], 'nominal' => 0.0, 'is_override' => false);
            $diff   = round($c_item['nominal'] - $p_item['nominal'], 2);
            if (abs($diff) >= 0.01) {
                $nama = $c_item['nama_komponen'];
                $ovr_note = !empty($c_item['is_override']) ? ' (penyesuaian khusus)' : '';
                if ($p_item['nominal'] <= 0 && $c_item['nominal'] > 0) {
                    $reason = 'Tunjangan ' . $nama . ' mulai diberikan bulan ini' . $ovr_note;
                    $clause = 'tambahan ' . $nama . ' (' . self::formatRupiah($diff, true) . ')';
                } elseif ($p_item['nominal'] > 0 && $c_item['nominal'] <= 0) {
                    $reason = 'Tunjangan ' . $nama . ' tidak berlaku pada periode ini';
                    $clause = 'berakhirnya ' . $nama . ' (' . self::formatRupiah($diff, true) . ')';
                } else {
                    $verb = $diff > 0 ? 'naik' : 'turun';
                    $reason = 'Tunjangan ' . $nama . ' ' . $verb . ' dari ' . self::formatRupiah($p_item['nominal']) . ' menjadi ' . self::formatRupiah($c_item['nominal']) . $ovr_note;
                    $clause = $nama . ' ' . $verb . ' (' . self::formatRupiah($diff, true) . ')';
                }

                $factors[] = array(
                    'key'           => 'tunjangan_' . $k,
                    'category'      => 'earning',
                    'label'         => $nama,
                    'prev_amount'   => $p_item['nominal'],
                    'curr_amount'   => $c_item['nominal'],
                    'delta_amount'  => $diff,
                    'impact_on_net' => $diff,
                    'reason'        => $reason,
                    'short_clause'  => $clause
                );
            }
        }

        // 4. Potongan Alpha (dampak ke THP adalah negatif dari kenaikan potongan)
        $p_alpha_amt  = (float)(isset($previous['pot_alpha']) ? $previous['pot_alpha'] : 0);
        $c_alpha_amt  = (float)(isset($current['pot_alpha']) ? $current['pot_alpha'] : 0);
        $p_alpha_days = (int)(isset($previous['alpha']) ? $previous['alpha'] : 0);
        $c_alpha_days = (int)(isset($current['alpha']) ? $current['alpha'] : 0);
        $d_alpha_amt  = round($c_alpha_amt - $p_alpha_amt, 2);
        if (abs($d_alpha_amt) >= 0.01) {
            $impact = round(-$d_alpha_amt, 2);
            $d_days = $c_alpha_days - $p_alpha_days;
            if ($p_alpha_amt <= 0 && $c_alpha_amt > 0) {
                $reason = 'Tercatat ' . $c_alpha_days . ' hari alpha bulan ini (periode lalu 0 hari)';
                $clause = $c_alpha_days . ' hari alpha (' . self::formatRupiah($impact, true) . ')';
            } elseif ($p_alpha_amt > 0 && $c_alpha_amt <= 0) {
                $reason = 'Bebas potongan alpha bulan ini (periode lalu ' . $p_alpha_days . ' hari)';
                $clause = 'bebas potongan alpha (' . self::formatRupiah($impact, true) . ')';
            } elseif ($d_days > 0) {
                $reason = 'Jumlah alpha bertambah ' . $d_days . ' hari (' . $p_alpha_days . ' hari menjadi ' . $c_alpha_days . ' hari)';
                $clause = 'alpha bertambah ' . $d_days . ' hari (' . self::formatRupiah($impact, true) . ')';
            } elseif ($d_days < 0) {
                $reason = 'Jumlah alpha berkurang ' . abs($d_days) . ' hari (' . $p_alpha_days . ' hari menjadi ' . $c_alpha_days . ' hari)';
                $clause = 'alpha berkurang ' . abs($d_days) . ' hari (' . self::formatRupiah($impact, true) . ')';
            } else {
                $verb = $d_alpha_amt > 0 ? 'naik' : 'turun';
                $reason = 'Tarif potongan alpha ' . $verb . ' pada ' . $c_alpha_days . ' hari alpha';
                $clause = 'perubahan tarif potongan alpha (' . self::formatRupiah($impact, true) . ')';
            }

            $factors[] = array(
                'key'           => 'pot_alpha',
                'category'      => 'deduction',
                'label'         => 'Potongan Alpha',
                'prev_amount'   => $p_alpha_amt,
                'curr_amount'   => $c_alpha_amt,
                'delta_amount'  => $d_alpha_amt,
                'impact_on_net' => $impact,
                'reason'        => $reason,
                'short_clause'  => $clause
            );
        }

        // 5. Potongan Dinamis (per nama komponen)
        $p_pot_map = self::indexDynamicItems(isset($previous['potongan_detail']) ? $previous['potongan_detail'] : array());
        $c_pot_map = self::indexDynamicItems(isset($current['potongan_detail']) ? $current['potongan_detail'] : array());
        $all_pot_keys = array_unique(array_merge(array_keys($p_pot_map), array_keys($c_pot_map)));
        foreach ($all_pot_keys as $k) {
            $p_item = isset($p_pot_map[$k]) ? $p_pot_map[$k] : array('nama_komponen' => $c_pot_map[$k]['nama_komponen'], 'nominal' => 0.0, 'is_override' => false);
            $c_item = isset($c_pot_map[$k]) ? $c_pot_map[$k] : array('nama_komponen' => $p_pot_map[$k]['nama_komponen'], 'nominal' => 0.0, 'is_override' => false);
            $diff   = round($c_item['nominal'] - $p_item['nominal'], 2);
            if (abs($diff) >= 0.01) {
                $impact   = round(-$diff, 2);
                $nama     = $c_item['nama_komponen'];
                $ovr_note = !empty($c_item['is_override']) ? ' (penyesuaian khusus)' : '';
                if ($p_item['nominal'] <= 0 && $c_item['nominal'] > 0) {
                    $reason = 'Potongan ' . $nama . ' mulai berlaku bulan ini' . $ovr_note;
                    $clause = 'potongan ' . $nama . ' (' . self::formatRupiah($impact, true) . ')';
                } elseif ($p_item['nominal'] > 0 && $c_item['nominal'] <= 0) {
                    $reason = 'Potongan ' . $nama . ' tidak lagi berlaku bulan ini';
                    $clause = 'berakhirnya potongan ' . $nama . ' (' . self::formatRupiah($impact, true) . ')';
                } else {
                    $verb = $diff > 0 ? 'naik' : 'turun';
                    $reason = 'Potongan ' . $nama . ' ' . $verb . ' dari ' . self::formatRupiah($p_item['nominal']) . ' menjadi ' . self::formatRupiah($c_item['nominal']) . $ovr_note;
                    $clause = 'potongan ' . $nama . ' ' . $verb . ' (' . self::formatRupiah($impact, true) . ')';
                }

                $factors[] = array(
                    'key'           => 'potongan_' . $k,
                    'category'      => 'deduction',
                    'label'         => 'Potongan ' . $nama,
                    'prev_amount'   => $p_item['nominal'],
                    'curr_amount'   => $c_item['nominal'],
                    'delta_amount'  => $diff,
                    'impact_on_net' => $impact,
                    'reason'        => $reason,
                    'short_clause'  => $clause
                );
            }
        }

        // 6. Cicilan Pinjaman / Kasbon
        $p_loan = (float)(isset($previous['pot_pinjaman']) ? $previous['pot_pinjaman'] : 0);
        $c_loan = (float)(isset($current['pot_pinjaman']) ? $current['pot_pinjaman'] : 0);
        $d_loan = round($c_loan - $p_loan, 2);
        if (abs($d_loan) >= 0.01) {
            $impact     = round(-$d_loan, 2);
            $p_loan_txt = self::summarizeLoanDetail(isset($previous['pinjaman_detail']) ? $previous['pinjaman_detail'] : array());
            $c_loan_txt = self::summarizeLoanDetail(isset($current['pinjaman_detail']) ? $current['pinjaman_detail'] : array());

            if ($p_loan <= 0 && $c_loan > 0) {
                $detail_desc = $c_loan_txt !== '' ? $c_loan_txt : 'cicilan kasbon/pinjaman';
                $reason = 'Mulai berlakunya ' . $detail_desc;
                $clause = 'mulai berlakunya cicilan pinjaman (' . self::formatRupiah($impact, true) . ')';
            } elseif ($p_loan > 0 && $c_loan <= 0) {
                $detail_desc = $p_loan_txt !== '' ? ' (periode lalu: ' . $p_loan_txt . ')' : '';
                $reason = 'Cicilan pinjaman telah lunas atau selesai bulan ini' . $detail_desc;
                $clause = 'cicilan pinjaman selesai (' . self::formatRupiah($impact, true) . ')';
            } else {
                $verb = $d_loan > 0 ? 'bertambah' : 'berkurang';
                $extra = $c_loan_txt !== '' ? ' [' . $c_loan_txt . ']' : '';
                $reason = 'Total cicilan pinjaman ' . $verb . ' dari ' . self::formatRupiah($p_loan) . ' menjadi ' . self::formatRupiah($c_loan) . $extra;
                $clause = 'cicilan pinjaman ' . $verb . ' (' . self::formatRupiah($impact, true) . ')';
            }

            $factors[] = array(
                'key'           => 'pot_pinjaman',
                'category'      => 'deduction',
                'label'         => 'Cicilan Pinjaman / Kasbon',
                'prev_amount'   => $p_loan,
                'curr_amount'   => $c_loan,
                'delta_amount'  => $d_loan,
                'impact_on_net' => $impact,
                'reason'        => $reason,
                'short_clause'  => $clause
            );
        }

        // Urutkan faktor dari dampak nominal absolut terbesar ke terkecil
        usort($factors, function ($a, $b) {
            $aa = abs($a['impact_on_net']);
            $bb = abs($b['impact_on_net']);
            if (abs($aa - $bb) < 0.01) {
                return strcmp($a['label'], $b['label']);
            }
            return ($aa > $bb) ? -1 : 1;
        });

        $positive_total = 0.0;
        $negative_total = 0.0;
        $sum_impacts    = 0.0;
        foreach ($factors as $f) {
            $sum_impacts += $f['impact_on_net'];
            if ($f['impact_on_net'] > 0) {
                $positive_total += $f['impact_on_net'];
            } else {
                $negative_total += $f['impact_on_net'];
            }
        }
        $reconciliation_ok = abs(round($sum_impacts - $net_delta, 2)) < 1.0;

        // Susun ringkasan kalimat bahasa Indonesia alami
        $top_clauses = array();
        foreach (array_slice($factors, 0, 3) as $f) {
            $top_clauses[] = $f['short_clause'];
        }
        $extra_count = count($factors) - count($top_clauses);
        $joined_top  = self::joinPhrasesId($top_clauses);
        if ($extra_count > 0) {
            $joined_top .= ' serta ' . $extra_count . ' komponen lainnya';
        }

        if (abs($net_delta) < 0.01) {
            $direction = 'same';
            if (empty($factors)) {
                $headline         = 'Gaji Bersih Tetap Sama';
                $summary_sentence = 'Gaji bersih periode ' . $curr_label . ' tetap sama (' . self::formatRupiah($curr_net) . ') dibanding ' . $prev_label . ', tanpa perubahan pada komponen penerimaan maupun potongan.';
                $short_reason     = 'Tidak ada perubahan komponen dibanding ' . $prev_label . '.';
            } else {
                $headline         = 'Gaji Bersih Tetap (Saling Mengimbangi)';
                $summary_sentence = 'Gaji bersih periode ' . $curr_label . ' tetap sama dibanding ' . $prev_label . ' karena perubahan komponen saling mengimbangi: ' . $joined_top . '.';
                $short_reason     = 'Perubahan saling mengimbangi: ' . $joined_top . '.';
            }
        } elseif ($net_delta > 0) {
            $direction = 'up';
            $pct_str   = $net_pct !== null ? ' (' . self::formatPercent($net_pct) . ')' : '';
            $headline  = 'Gaji Bersih Naik ' . self::formatRupiah(abs($net_delta));
            $summary_sentence = 'Gaji bersih periode ' . $curr_label . ' naik ' . self::formatRupiah(abs($net_delta)) . $pct_str . ' dibanding ' . $prev_label
                . ($joined_top !== '' ? ', terutama dipicu oleh ' . $joined_top . '.' : '.');
            $short_reason = $joined_top !== '' ? 'Dipicu oleh ' . $joined_top . '.' : 'Naik dibanding ' . $prev_label . '.';
        } else {
            $direction = 'down';
            $pct_str   = $net_pct !== null ? ' (' . self::formatPercent($net_pct) . ')' : '';
            $headline  = 'Gaji Bersih Turun ' . self::formatRupiah(abs($net_delta));
            $summary_sentence = 'Gaji bersih periode ' . $curr_label . ' turun ' . self::formatRupiah(abs($net_delta)) . $pct_str . ' dibanding ' . $prev_label
                . ($joined_top !== '' ? ', terutama dipicu oleh ' . $joined_top . '.' : '.');
            $short_reason = $joined_top !== '' ? 'Dipicu oleh ' . $joined_top . '.' : 'Turun dibanding ' . $prev_label . '.';
        }

        return array(
            'has_previous'      => true,
            'direction'         => $direction,
            'current_period'    => isset($current['bulan']) ? (string)$current['bulan'] : '',
            'current_label'     => $curr_label,
            'previous_period'   => isset($previous['bulan']) ? (string)$previous['bulan'] : '',
            'previous_label'    => $prev_label,
            'current_net'       => $curr_net,
            'previous_net'      => $prev_net,
            'net_delta'         => $net_delta,
            'net_delta_pct'     => $net_pct,
            'positive_total'    => round($positive_total, 2),
            'negative_total'    => round($negative_total, 2),
            'headline'          => $headline,
            'summary_sentence'  => $summary_sentence,
            'short_reason'      => $short_reason,
            'factors'           => $factors,
            'reconciliation_ok' => $reconciliation_ok
        );
    }

    /**
     * Menjelaskan perubahan total belanja gaji tingkat klinik antara periode berjalan dan periode sebelumnya,
     * memisahkan efek perubahan jumlah pegawai (headcount) dari perubahan komponen pegawai yang sama.
     *
     * @param array $current_period_data  ['bulan' => 'MMYYYY', 'label_periode' => '...', 'slips' => [nik => slip]]
     * @param array|null $prev_period_data Struktur sama untuk periode sebelumnya, atau null jika belum ada.
     */
    public static function explainClinicPeriodDiff(array $current_period_data, $prev_period_data = null)
    {
        $curr_label = !empty($current_period_data['label_periode'])
            ? (string)$current_period_data['label_periode']
            : self::resolvePeriodLabel($current_period_data);
        $curr_slips = isset($current_period_data['slips']) && is_array($current_period_data['slips'])
            ? $current_period_data['slips']
            : array();

        $curr_total_net = 0.0;
        foreach ($curr_slips as $s) {
            $curr_total_net += (float)(isset($s['gaji_bersih_raw']) ? $s['gaji_bersih_raw'] : (isset($s['gaji_bersih']) ? $s['gaji_bersih'] : 0));
        }

        if (!is_array($prev_period_data) || empty($prev_period_data['slips'])) {
            return array(
                'has_previous'       => false,
                'direction'          => 'baseline',
                'current_period'     => isset($current_period_data['bulan']) ? (string)$current_period_data['bulan'] : '',
                'current_label'      => $curr_label,
                'previous_period'    => null,
                'previous_label'     => null,
                'current_total_net'  => round($curr_total_net, 2),
                'previous_total_net' => null,
                'current_headcount'  => count($curr_slips),
                'previous_headcount' => 0,
                'net_delta'          => 0.0,
                'net_delta_pct'      => null,
                'headline'           => 'Periode Awal Penggajian',
                'summary_sentence'   => 'Belum ada periode penggajian sebelumnya untuk dibandingkan terhadap ' . $curr_label . ' (' . count($curr_slips) . ' pegawai, total ' . self::formatRupiah($curr_total_net) . ').',
                'drivers'            => array(),
                'top_movers'         => array(),
                'employee_diffs'     => array(),
                'reconciliation_ok'  => true
            );
        }

        $prev_label = !empty($prev_period_data['label_periode'])
            ? (string)$prev_period_data['label_periode']
            : self::resolvePeriodLabel($prev_period_data);
        $prev_slips = $prev_period_data['slips'];

        $prev_total_net = 0.0;
        foreach ($prev_slips as $s) {
            $prev_total_net += (float)(isset($s['gaji_bersih_raw']) ? $s['gaji_bersih_raw'] : (isset($s['gaji_bersih']) ? $s['gaji_bersih'] : 0));
        }

        $net_delta = round($curr_total_net - $prev_total_net, 2);
        $net_pct   = (abs($prev_total_net) > 0.0001) ? round(($net_delta / abs($prev_total_net)) * 100, 1) : null;

        // Pisahkan pegawai masuk baru, pegawai keluar, dan pegawai yang ada di kedua periode
        $new_emp_impact     = 0.0;
        $new_emp_names      = array();
        $removed_emp_impact = 0.0;
        $removed_emp_names  = array();

        $same_fixed_delta   = 0.0;
        $same_lembur_delta  = 0.0;
        $same_lembur_hours  = 0;
        $same_tj_din_delta  = 0.0;
        $same_alpha_impact  = 0.0;
        $same_alpha_days    = 0;
        $same_pot_din_imp   = 0.0;
        $same_loan_impact   = 0.0;

        $employee_diffs = array();
        $movers         = array();

        foreach ($curr_slips as $nik => $c_slip) {
            $c_net = (float)(isset($c_slip['gaji_bersih_raw']) ? $c_slip['gaji_bersih_raw'] : (isset($c_slip['gaji_bersih']) ? $c_slip['gaji_bersih'] : 0));
            if (!isset($prev_slips[$nik])) {
                $new_emp_impact += $c_net;
                $new_emp_names[] = isset($c_slip['nama_pegawai']) ? $c_slip['nama_pegawai'] : $nik;
                $emp_diff = self::explainEmployeeDiff($c_slip, null);
                $emp_diff['is_new_in_period'] = true;
                $employee_diffs[$nik] = $emp_diff;
                $movers[] = array(
                    'nik'          => $nik,
                    'nama_pegawai' => isset($c_slip['nama_pegawai']) ? $c_slip['nama_pegawai'] : $nik,
                    'jabatan'      => isset($c_slip['nama_jabatan']) ? $c_slip['nama_jabatan'] : '',
                    'direction'    => 'new',
                    'prev_net'     => 0.0,
                    'curr_net'     => $c_net,
                    'net_delta'    => $c_net,
                    'short_reason' => 'Pegawai baru masuk daftar gaji periode ' . $curr_label . '.'
                );
                continue;
            }

            $p_slip = $prev_slips[$nik];
            $emp_diff = self::explainEmployeeDiff($c_slip, $p_slip);
            $emp_diff['is_new_in_period'] = false;
            $employee_diffs[$nik] = $emp_diff;

            $same_fixed_delta  += ((float)$c_slip['gaji_pokok'] - (float)$p_slip['gaji_pokok'])
                                + ((float)$c_slip['tj_transport'] - (float)$p_slip['tj_transport'])
                                + ((float)$c_slip['uang_makan'] - (float)$p_slip['uang_makan']);
            $same_lembur_delta += ((float)$c_slip['uang_lembur'] - (float)$p_slip['uang_lembur']);
            $same_lembur_hours += ((int)$c_slip['jam_lembur'] - (int)$p_slip['jam_lembur']);

            $c_tj_din = (float)(isset($c_slip['tunjangan_dinamis']) ? $c_slip['tunjangan_dinamis'] : 0);
            $p_tj_din = (float)(isset($p_slip['tunjangan_dinamis']) ? $p_slip['tunjangan_dinamis'] : 0);
            $same_tj_din_delta += ($c_tj_din - $p_tj_din);

            $same_alpha_impact += -((float)$c_slip['pot_alpha'] - (float)$p_slip['pot_alpha']);
            $same_alpha_days   += ((int)$c_slip['alpha'] - (int)$p_slip['alpha']);

            $c_pot_din = (float)(isset($c_slip['potongan_dinamis']) ? $c_slip['potongan_dinamis'] : 0);
            $p_pot_din = (float)(isset($p_slip['potongan_dinamis']) ? $p_slip['potongan_dinamis'] : 0);
            $same_pot_din_imp += -($c_pot_din - $p_pot_din);

            $same_loan_impact += -((float)$c_slip['pot_pinjaman'] - (float)$p_slip['pot_pinjaman']);

            if (abs($emp_diff['net_delta']) >= 0.01) {
                $movers[] = array(
                    'nik'          => $nik,
                    'nama_pegawai' => isset($c_slip['nama_pegawai']) ? $c_slip['nama_pegawai'] : $nik,
                    'jabatan'      => isset($c_slip['nama_jabatan']) ? $c_slip['nama_jabatan'] : '',
                    'direction'    => $emp_diff['direction'],
                    'prev_net'     => $emp_diff['previous_net'],
                    'curr_net'     => $emp_diff['current_net'],
                    'net_delta'    => $emp_diff['net_delta'],
                    'short_reason' => $emp_diff['short_reason']
                );
            }
        }

        foreach ($prev_slips as $nik => $p_slip) {
            if (!isset($curr_slips[$nik])) {
                $p_net = (float)(isset($p_slip['gaji_bersih_raw']) ? $p_slip['gaji_bersih_raw'] : (isset($p_slip['gaji_bersih']) ? $p_slip['gaji_bersih'] : 0));
                $removed_emp_impact -= $p_net;
                $removed_emp_names[] = isset($p_slip['nama_pegawai']) ? $p_slip['nama_pegawai'] : $nik;
            }
        }

        $drivers = array();
        if (abs($new_emp_impact) >= 0.01) {
            $cnt = count($new_emp_names);
            $drivers[] = array(
                'key'           => 'headcount_added',
                'label'         => 'Penambahan Pegawai di Daftar Gaji',
                'impact_on_net' => round($new_emp_impact, 2),
                'detail'        => $cnt . ' pegawai baru masuk payroll (' . implode(', ', array_slice($new_emp_names, 0, 3)) . ($cnt > 3 ? ', dll.' : '') . ')',
                'short_clause'  => 'tambahan ' . $cnt . ' pegawai di daftar gaji (' . self::formatRupiah($new_emp_impact, true) . ')'
            );
        }
        if (abs($removed_emp_impact) >= 0.01) {
            $cnt = count($removed_emp_names);
            $drivers[] = array(
                'key'           => 'headcount_removed',
                'label'         => 'Pengurangan Pegawai di Daftar Gaji',
                'impact_on_net' => round($removed_emp_impact, 2),
                'detail'        => $cnt . ' pegawai periode lalu tidak tercatat bulan ini (' . implode(', ', array_slice($removed_emp_names, 0, 3)) . ($cnt > 3 ? ', dll.' : '') . ')',
                'short_clause'  => 'berkurangnya ' . $cnt . ' pegawai di daftar gaji (' . self::formatRupiah($removed_emp_impact, true) . ')'
            );
        }
        if (abs($same_fixed_delta) >= 0.01) {
            $verb = $same_fixed_delta > 0 ? 'kenaikan' : 'penurunan';
            $drivers[] = array(
                'key'           => 'fixed_pay',
                'label'         => 'Gaji Pokok & Tunjangan Tetap',
                'impact_on_net' => round($same_fixed_delta, 2),
                'detail'        => ucfirst($verb) . ' struktur gaji pokok, transport, atau uang makan',
                'short_clause'  => $verb . ' gaji dasar (' . self::formatRupiah($same_fixed_delta, true) . ')'
            );
        }
        if (abs($same_lembur_delta) >= 0.01) {
            $jam_str = $same_lembur_hours !== 0
                ? (($same_lembur_hours > 0 ? '+' : '') . $same_lembur_hours . ' jam lembur')
                : 'perubahan tarif lembur';
            $verb = $same_lembur_delta > 0 ? 'kenaikan' : 'penurunan';
            $drivers[] = array(
                'key'           => 'overtime',
                'label'         => 'Upah Lembur',
                'impact_on_net' => round($same_lembur_delta, 2),
                'detail'        => ucfirst($verb) . ' upah lembur (' . $jam_str . ')',
                'short_clause'  => $verb . ' lembur (' . $jam_str . ' / ' . self::formatRupiah($same_lembur_delta, true) . ')'
            );
        }
        if (abs($same_tj_din_delta) >= 0.01) {
            $verb = $same_tj_din_delta > 0 ? 'kenaikan' : 'penurunan';
            $drivers[] = array(
                'key'           => 'dynamic_allowance',
                'label'         => 'Tunjangan Dinamis',
                'impact_on_net' => round($same_tj_din_delta, 2),
                'detail'        => ucfirst($verb) . ' komponen tunjangan tambahan pegawai',
                'short_clause'  => $verb . ' tunjangan dinamis (' . self::formatRupiah($same_tj_din_delta, true) . ')'
            );
        }
        if (abs($same_alpha_impact) >= 0.01) {
            $day_str = $same_alpha_days !== 0
                ? (($same_alpha_days > 0 ? '+' : '') . $same_alpha_days . ' hari alpha')
                : 'perubahan tarif alpha';
            $desc = $same_alpha_impact > 0 ? 'berkurangnya potongan alpha' : 'bertambahnya potongan alpha';
            $drivers[] = array(
                'key'           => 'alpha_deduction',
                'label'         => 'Potongan Kehadiran Alpha',
                'impact_on_net' => round($same_alpha_impact, 2),
                'detail'        => ucfirst($desc) . ' (' . $day_str . ')',
                'short_clause'  => $desc . ' (' . $day_str . ' / ' . self::formatRupiah($same_alpha_impact, true) . ')'
            );
        }
        if (abs($same_pot_din_imp) >= 0.01) {
            $desc = $same_pot_din_imp > 0 ? 'berkurangnya potongan dinamis' : 'bertambahnya potongan dinamis';
            $drivers[] = array(
                'key'           => 'dynamic_deduction',
                'label'         => 'Potongan Dinamis',
                'impact_on_net' => round($same_pot_din_imp, 2),
                'detail'        => ucfirst($desc) . ' pegawai',
                'short_clause'  => $desc . ' (' . self::formatRupiah($same_pot_din_imp, true) . ')'
            );
        }
        if (abs($same_loan_impact) >= 0.01) {
            $desc = $same_loan_impact > 0 ? 'berkurangnya cicilan pinjaman/kasbon' : 'bertambahnya cicilan pinjaman/kasbon';
            $drivers[] = array(
                'key'           => 'loan_deduction',
                'label'         => 'Cicilan Pinjaman / Kasbon',
                'impact_on_net' => round($same_loan_impact, 2),
                'detail'        => ucfirst($desc) . ' pada periode ini',
                'short_clause'  => $desc . ' (' . self::formatRupiah($same_loan_impact, true) . ')'
            );
        }

        usort($drivers, function ($a, $b) {
            $aa = abs($a['impact_on_net']);
            $bb = abs($b['impact_on_net']);
            if (abs($aa - $bb) < 0.01) {
                return strcmp($a['label'], $b['label']);
            }
            return ($aa > $bb) ? -1 : 1;
        });

        usort($movers, function ($a, $b) {
            $aa = abs($a['net_delta']);
            $bb = abs($b['net_delta']);
            if (abs($aa - $bb) < 0.01) {
                return strcmp($a['nama_pegawai'], $b['nama_pegawai']);
            }
            return ($aa > $bb) ? -1 : 1;
        });

        $sum_drivers = 0.0;
        foreach ($drivers as $dr) {
            $sum_drivers += $dr['impact_on_net'];
        }
        $reconciliation_ok = abs(round($sum_drivers - $net_delta, 2)) < 1.0;

        $top_clauses = array();
        foreach (array_slice($drivers, 0, 3) as $dr) {
            $top_clauses[] = $dr['short_clause'];
        }
        $joined = self::joinPhrasesId($top_clauses);

        if (abs($net_delta) < 0.01) {
            $direction = 'same';
            $headline  = 'Total Belanja Gaji Stabil';
            $summary   = empty($drivers)
                ? 'Total belanja gaji bersih periode ' . $curr_label . ' (' . self::formatRupiah($curr_total_net) . ') tetap sama persis dibanding ' . $prev_label . '.'
                : 'Total belanja gaji bersih periode ' . $curr_label . ' tetap sama dibanding ' . $prev_label . ' karena perubahan antar pos saling mengimbangi: ' . $joined . '.';
        } elseif ($net_delta > 0) {
            $direction = 'up';
            $pct_str   = $net_pct !== null ? ' (' . self::formatPercent($net_pct) . ')' : '';
            $headline  = 'Belanja Gaji Naik ' . self::formatRupiah(abs($net_delta));
            $summary   = 'Total belanja gaji bersih ' . $curr_label . ' naik ' . self::formatRupiah(abs($net_delta)) . $pct_str . ' dibanding ' . $prev_label
                . ($joined !== '' ? ', terutama dipicu oleh ' . $joined . '.' : '.');
        } else {
            $direction = 'down';
            $pct_str   = $net_pct !== null ? ' (' . self::formatPercent($net_pct) . ')' : '';
            $headline  = 'Belanja Gaji Turun ' . self::formatRupiah(abs($net_delta));
            $summary   = 'Total belanja gaji bersih ' . $curr_label . ' turun ' . self::formatRupiah(abs($net_delta)) . $pct_str . ' dibanding ' . $prev_label
                . ($joined !== '' ? ', terutama dipicu oleh ' . $joined . '.' : '.');
        }

        return array(
            'has_previous'       => true,
            'direction'          => $direction,
            'current_period'     => isset($current_period_data['bulan']) ? (string)$current_period_data['bulan'] : '',
            'current_label'      => $curr_label,
            'previous_period'    => isset($prev_period_data['bulan']) ? (string)$prev_period_data['bulan'] : '',
            'previous_label'     => $prev_label,
            'current_total_net'  => round($curr_total_net, 2),
            'previous_total_net' => round($prev_total_net, 2),
            'current_headcount'  => count($curr_slips),
            'previous_headcount' => count($prev_slips),
            'net_delta'          => $net_delta,
            'net_delta_pct'      => $net_pct,
            'headline'           => $headline,
            'summary_sentence'   => $summary,
            'drivers'            => $drivers,
            'top_movers'         => array_slice($movers, 0, 5),
            'employee_diffs'     => $employee_diffs,
            'reconciliation_ok'  => $reconciliation_ok
        );
    }
}
