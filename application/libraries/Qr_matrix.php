<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Generator QR Code ISO/IEC 18004 murni PHP (Byte Mode, ECC Level M, Versi 1 s/d 10)
 * Tanpa ketergantungan API eksternal maupun JavaScript klien sehingga bekerja offline dan di Dompdf.
 */
class Qr_matrix
{
    private static $initialized = false;
    private static $gfExp = array();
    private static $gfLog = array();

    // Kapasitas & parameter blok Error Correction Level M untuk versi 1..10:
    // [total_data_cw, ec_cw_per_block, g1_blocks, g1_data_cw, g2_blocks, g2_data_cw]
    private static $versionSpecM = array(
        1  => array(16,  10, 1, 16, 0, 0),
        2  => array(28,  16, 1, 28, 0, 0),
        3  => array(44,  26, 1, 44, 0, 0),
        4  => array(64,  18, 2, 32, 0, 0),
        5  => array(86,  24, 2, 43, 0, 0),
        6  => array(108, 16, 4, 27, 0, 0),
        7  => array(124, 18, 4, 31, 0, 0),
        8  => array(154, 22, 2, 38, 2, 39),
        9  => array(182, 22, 3, 36, 2, 37),
        10 => array(216, 26, 4, 43, 1, 44),
    );

    private static $alignCoords = array(
        1  => array(),
        2  => array(6, 18),
        3  => array(6, 22),
        4  => array(6, 26),
        5  => array(6, 30),
        6  => array(6, 34),
        7  => array(6, 22, 38),
        8  => array(6, 24, 42),
        9  => array(6, 26, 46),
        10 => array(6, 28, 50),
    );

    private static $versionBits = array(
        7  => 0x07C94,
        8  => 0x085BC,
        9  => 0x09A99,
        10 => 0x0A4D3,
    );

    // Format info 15-bit untuk ECC Level M (00), mask 0..7, sudah di-XOR 0x5412
    private static $formatBitsM = array(
        0 => 0x5412,
        1 => 0x5125,
        2 => 0x5E7C,
        3 => 0x5B4B,
        4 => 0x45F9,
        5 => 0x40CE,
        6 => 0x4F97,
        7 => 0x4AA0,
    );

    private static function initGf()
    {
        if (self::$initialized) {
            return;
        }
        $x = 1;
        for ($i = 0; $i < 255; $i++) {
            self::$gfExp[$i] = $x;
            self::$gfLog[$x] = $i;
            $x <<= 1;
            if ($x & 0x100) {
                $x ^= 0x11D;
            }
        }
        for ($i = 255; $i < 512; $i++) {
            self::$gfExp[$i] = self::$gfExp[$i - 255];
        }
        self::$gfLog[0] = 0;
        self::$initialized = true;
    }

    private static function gfMul($a, $b)
    {
        if ($a === 0 || $b === 0) {
            return 0;
        }
        return self::$gfExp[self::$gfLog[$a] + self::$gfLog[$b]];
    }

    private static function rsGeneratorPoly($ecCount)
    {
        $poly = array(1);
        for ($i = 0; $i < $ecCount; $i++) {
            $next = array_fill(0, count($poly) + 1, 0);
            $factor = self::$gfExp[$i];
            for ($j = 0; $j < count($poly); $j++) {
                $next[$j]     ^= $poly[$j];
                $next[$j + 1] ^= self::gfMul($poly[$j], $factor);
            }
            $poly = $next;
        }
        return $poly;
    }

    private static function rsRemainder($data, $ecCount)
    {
        $gen = self::rsGeneratorPoly($ecCount);
        $res = array_merge($data, array_fill(0, $ecCount, 0));
        $dataLen = count($data);

        for ($i = 0; $i < $dataLen; $i++) {
            $coef = $res[$i];
            if ($coef !== 0) {
                for ($j = 0; $j < count($gen); $j++) {
                    $res[$i + $j] ^= self::gfMul($gen[$j], $coef);
                }
            }
        }
        return array_slice($res, $dataLen);
    }

    public static function encodeMatrix($text)
    {
        self::initGf();
        $bytes = array_values(unpack('C*', (string)$text));
        $byteLen = count($bytes);

        // Pilih versi minimum 1..10 (mode byte: 4 bit mode + 8/16 bit length + data + min 4 bit terminator)
        $version = 0;
        foreach (self::$versionSpecM as $v => $spec) {
            $charBits = ($v <= 9) ? 8 : 16;
            $requiredBits = 4 + $charBits + ($byteLen * 8);
            if ($requiredBits <= ($spec[0] * 8)) {
                $version = $v;
                break;
            }
        }
        if ($version === 0) {
            throw new InvalidArgumentException('QR payload exceeds max version 10 M capacity.');
        }

        $spec = self::$versionSpecM[$version];
        list($totalDataCw, $ecCwPerBlock, $g1Blocks, $g1DataCw, $g2Blocks, $g2DataCw) = $spec;

        // 1. Encode bit stream (mode 0100 = Byte)
        $bits = array();
        $pushBits = function ($val, $len) use (&$bits) {
            for ($i = $len - 1; $i >= 0; $i--) {
                $bits[] = ($val >> $i) & 1;
            }
        };

        $pushBits(0b0100, 4);
        $pushBits($byteLen, ($version <= 9) ? 8 : 16);
        foreach ($bytes as $b) {
            $pushBits($b, 8);
        }

        $maxDataBits = $totalDataCw * 8;
        $termLen = min(4, $maxDataBits - count($bits));
        for ($i = 0; $i < $termLen; $i++) {
            $bits[] = 0;
        }
        while (count($bits) % 8 !== 0) {
            $bits[] = 0;
        }

        $dataCodewords = array();
        for ($i = 0; $i < count($bits); $i += 8) {
            $cw = 0;
            for ($j = 0; $j < 8; $j++) {
                $cw = ($cw << 1) | $bits[$i + $j];
            }
            $dataCodewords[] = $cw;
        }

        $padBytes = array(0xEC, 0x11);
        $padIdx = 0;
        while (count($dataCodewords) < $totalDataCw) {
            $dataCodewords[] = $padBytes[$padIdx % 2];
            $padIdx++;
        }

        // 2. Bagi ke blok dan hitung ECC + interleave
        $blocks = array();
        $ecBlocks = array();
        $offset = 0;
        for ($i = 0; $i < $g1Blocks; $i++) {
            $blk = array_slice($dataCodewords, $offset, $g1DataCw);
            $offset += $g1DataCw;
            $blocks[] = $blk;
            $ecBlocks[] = self::rsRemainder($blk, $ecCwPerBlock);
        }
        for ($i = 0; $i < $g2Blocks; $i++) {
            $blk = array_slice($dataCodewords, $offset, $g2DataCw);
            $offset += $g2DataCw;
            $blocks[] = $blk;
            $ecBlocks[] = self::rsRemainder($blk, $ecCwPerBlock);
        }

        $finalCodewords = array();
        $maxDataBlockLen = max($g1DataCw, $g2DataCw);
        for ($col = 0; $col < $maxDataBlockLen; $col++) {
            foreach ($blocks as $blk) {
                if (isset($blk[$col])) {
                    $finalCodewords[] = $blk[$col];
                }
            }
        }
        for ($col = 0; $col < $ecCwPerBlock; $col++) {
            foreach ($ecBlocks as $ecBlk) {
                $finalCodewords[] = $ecBlk[$col];
            }
        }

        // 3. Bangun matriks dasar + function patterns
        $size = 17 + (4 * $version);
        $modules = array_fill(0, $size, array_fill(0, $size, null));
        $isFunc  = array_fill(0, $size, array_fill(0, $size, false));

        $setFunc = function ($r, $c, $val) use (&$modules, &$isFunc, $size) {
            if ($r >= 0 && $r < $size && $c >= 0 && $c < $size) {
                $modules[$r][$c] = $val ? 1 : 0;
                $isFunc[$r][$c]  = true;
            }
        };

        $drawFinder = function ($top, $left) use ($setFunc) {
            for ($dr = -1; $dr <= 7; $dr++) {
                for ($dc = -1; $dc <= 7; $dc++) {
                    if ($dr === -1 || $dr === 7 || $dc === -1 || $dc === 7) {
                        $val = 0;
                    } elseif ($dr === 0 || $dr === 6 || $dc === 0 || $dc === 6) {
                        $val = 1;
                    } elseif ($dr >= 2 && $dr <= 4 && $dc >= 2 && $dc <= 4) {
                        $val = 1;
                    } else {
                        $val = 0;
                    }
                    $setFunc($top + $dr, $left + $dc, $val);
                }
            }
        };

        $drawFinder(0, 0);
        $drawFinder(0, $size - 7);
        $drawFinder($size - 7, 0);

        // Timing patterns
        for ($i = 8; $i < $size - 8; $i++) {
            $bit = ($i % 2 === 0) ? 1 : 0;
            $setFunc(6, $i, $bit);
            $setFunc($i, 6, $bit);
        }

        // Alignment patterns
        $coords = self::$alignCoords[$version];
        foreach ($coords as $ar) {
            foreach ($coords as $ac) {
                if (($ar === 6 && $ac === 6) ||
                    ($ar === 6 && $ac === $size - 7) ||
                    ($ar === $size - 7 && $ac === 6)) {
                    continue;
                }
                for ($dr = -2; $dr <= 2; $dr++) {
                    for ($dc = -2; $dc <= 2; $dc++) {
                        $dist = max(abs($dr), abs($dc));
                        $setFunc($ar + $dr, $ac + $dc, ($dist === 2 || $dist === 0) ? 1 : 0);
                    }
                }
            }
        }

        // Dark module
        $setFunc((4 * $version) + 9, 8, 1);

        // Reserve format info slots
        for ($i = 0; $i < 9; $i++) {
            if ($i !== 6) {
                $setFunc(8, $i, 0);
                $setFunc($i, 8, 0);
            }
        }
        for ($i = 0; $i < 8; $i++) {
            $setFunc(8, $size - 1 - $i, 0);
            $setFunc($size - 1 - $i, 8, 0);
        }

        // Version info untuk versi >= 7
        if ($version >= 7) {
            $vbits = self::$versionBits[$version];
            for ($i = 0; $i < 18; $i++) {
                $bit = ($vbits >> $i) & 1;
                $r = (int)floor($i / 3);
                $c = $size - 11 + ($i % 3);
                $setFunc($r, $c, $bit);
                $setFunc($c, $r, $bit);
            }
        }

        // 4. Penempatan bit data zig-zag
        $allBits = array();
        foreach ($finalCodewords as $cw) {
            for ($b = 7; $b >= 0; $b--) {
                $allBits[] = ($cw >> $b) & 1;
            }
        }
        $bitIdx = 0;
        $upward = true;
        for ($right = $size - 1; $right >= 1; $right -= 2) {
            if ($right === 6) {
                $right = 5;
            }
            for ($vert = 0; $vert < $size; $vert++) {
                $r = $upward ? ($size - 1 - $vert) : $vert;
                for ($dx = 0; $dx < 2; $dx++) {
                    $c = $right - $dx;
                    if (!$isFunc[$r][$c]) {
                        $val = isset($allBits[$bitIdx]) ? $allBits[$bitIdx] : 0;
                        $modules[$r][$c] = $val;
                        $bitIdx++;
                    }
                }
            }
            $upward = !$upward;
        }

        // 5. Pilih mask 0..7 dengan penalty terendah
        $bestMask = 0;
        $bestPenalty = PHP_INT_MAX;
        $bestMatrix = null;

        for ($mask = 0; $mask < 8; $mask++) {
            $cand = $modules;
            for ($r = 0; $r < $size; $r++) {
                for ($c = 0; $c < $size; $c++) {
                    if (!$isFunc[$r][$c] && self::maskCond($mask, $r, $c)) {
                        $cand[$r][$c] ^= 1;
                    }
                }
            }
            self::applyFormatBits($cand, $size, $mask);
            $penalty = self::scorePenalty($cand, $size);
            if ($penalty < $bestPenalty) {
                $bestPenalty = $penalty;
                $bestMask = $mask;
                $bestMatrix = $cand;
            }
        }

        return $bestMatrix;
    }

    private static function maskCond($mask, $r, $c)
    {
        switch ($mask) {
            case 0: return (($r + $c) % 2) === 0;
            case 1: return ($r % 2) === 0;
            case 2: return ($c % 3) === 0;
            case 3: return (($r + $c) % 3) === 0;
            case 4: return (((int)floor($r / 2) + (int)floor($c / 3)) % 2) === 0;
            case 5: return ((($r * $c) % 2) + (($r * $c) % 3)) === 0;
            case 6: return (((($r * $c) % 2) + (($r * $c) % 3)) % 2) === 0;
            case 7: return (((($r + $c) % 2) + (($r * $c) % 3)) % 2) === 0;
        }
        return false;
    }

    private static function applyFormatBits(&$mat, $size, $mask)
    {
        $f = self::$formatBitsM[$mask];
        for ($i = 0; $i < 15; $i++) {
            $bit = ($f >> $i) & 1;

            // Copy 1 (kiri-atas): 0..5 horizontal, 6=(8,7), 7=(8,8), 8=(7,8), 9..14 vertikal
            if ($i < 6) {
                $mat[8][$i] = $bit;
            } elseif ($i < 8) {
                $mat[8][$i + 1] = $bit;
            } elseif ($i === 8) {
                $mat[7][8] = $bit;
            } else {
                $mat[14 - $i][8] = $bit;
            }

            // Copy 2 (kiri-bawah 0..6 & kanan-atas 7..14)
            if ($i < 7) {
                $mat[$size - 1 - $i][8] = $bit;
            } else {
                $mat[8][$size - 15 + $i] = $bit;
            }
        }
        $mat[$size - 8][8] = 1;
    }

    private static function scorePenalty($mat, $size)
    {
        $penalty = 0;

        // N1: 5+ modul berurutan sewarna
        for ($r = 0; $r < $size; $r++) {
            $runColor = -1;
            $runLen = 0;
            for ($c = 0; $c < $size; $c++) {
                if ($mat[$r][$c] === $runColor) {
                    $runLen++;
                } else {
                    if ($runLen >= 5) $penalty += ($runLen - 2);
                    $runColor = $mat[$r][$c];
                    $runLen = 1;
                }
            }
            if ($runLen >= 5) $penalty += ($runLen - 2);
        }
        for ($c = 0; $c < $size; $c++) {
            $runColor = -1;
            $runLen = 0;
            for ($r = 0; $r < $size; $r++) {
                if ($mat[$r][$c] === $runColor) {
                    $runLen++;
                } else {
                    if ($runLen >= 5) $penalty += ($runLen - 2);
                    $runColor = $mat[$r][$c];
                    $runLen = 1;
                }
            }
            if ($runLen >= 5) $penalty += ($runLen - 2);
        }

        // N2: blok 2x2 sewarna
        for ($r = 0; $r < $size - 1; $r++) {
            for ($c = 0; $c < $size - 1; $c++) {
                $v = $mat[$r][$c];
                if ($v === $mat[$r][$c + 1] && $v === $mat[$r + 1][$c] && $v === $mat[$r + 1][$c + 1]) {
                    $penalty += 3;
                }
            }
        }

        // N3: rasio hitam terhadap total
        $dark = 0;
        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                if ($mat[$r][$c] === 1) $dark++;
            }
        }
        $total = $size * $size;
        $k = (int)floor(abs(($dark * 100 / $total) - 50) / 5);
        $penalty += $k * 10;

        return $penalty;
    }

    public static function toPngDataUri($text, $targetPx = 180)
    {
        $matrix = self::encodeMatrix($text);
        if (!function_exists('imagecreate')) {
            return self::toSvgDataUri($text, $targetPx);
        }

        $modCount = count($matrix);
        $quiet = 2;
        $totalMods = $modCount + ($quiet * 2);
        $scale = max(3, (int)ceil($targetPx / $totalMods));
        $imgPx = $totalMods * $scale;

        $im = imagecreate($imgPx, $imgPx);
        $white = imagecolorallocate($im, 255, 255, 255);
        $dark  = imagecolorallocate($im, 15, 23, 42);
        imagefill($im, 0, 0, $white);

        for ($r = 0; $r < $modCount; $r++) {
            for ($c = 0; $c < $modCount; $c++) {
                if ($matrix[$r][$c] === 1) {
                    $x1 = ($c + $quiet) * $scale;
                    $y1 = ($r + $quiet) * $scale;
                    imagefilledrectangle($im, $x1, $y1, $x1 + $scale - 1, $y1 + $scale - 1, $dark);
                }
            }
        }

        ob_start();
        imagepng($im);
        $pngBytes = ob_get_clean();
        imagedestroy($im);

        return 'data:image/png;base64,' . base64_encode($pngBytes);
    }

    public static function toSvgDataUri($text, $targetPx = 180)
    {
        $matrix = self::encodeMatrix($text);
        $modCount = count($matrix);
        $quiet = 2;
        $vb = $modCount + ($quiet * 2);

        $paths = '';
        for ($r = 0; $r < $modCount; $r++) {
            for ($c = 0; $c < $modCount; $c++) {
                if ($matrix[$r][$c] === 1) {
                    $x = $c + $quiet;
                    $y = $r + $quiet;
                    $paths .= '<rect x="' . $x . '" y="' . $y . '" width="1" height="1"/>';
                }
            }
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $vb . ' ' . $vb . '" width="' . (int)$targetPx . '" height="' . (int)$targetPx . '" shape-rendering="crispEdges">'
            . '<rect width="' . $vb . '" height="' . $vb . '" fill="#FFFFFF"/>'
            . '<g fill="#0F172A">' . $paths . '</g>'
            . '</svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
