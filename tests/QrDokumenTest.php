<?php

class QrDokumenTest extends PHPUnit_Framework_TestCase
{
    public function testHmacSignatureVerificationAcceptsValidAndRejectsTampering()
    {
        $sig = qr_doc_signature('slip', '300001', '092026');
        $this->assertEquals(12, strlen($sig));
        $this->assertTrue(qr_doc_verify_signature('slip', '300001', '092026', $sig));
        $this->assertTrue(qr_doc_verify_signature('SLIP', '300001', '092026', strtolower($sig)));

        $this->assertFalse(qr_doc_verify_signature('slip', '300002', '092026', $sig));
        $this->assertFalse(qr_doc_verify_signature('slip', '300001', '102026', $sig));
        $this->assertFalse(qr_doc_verify_signature('cuti', '300001', '092026', $sig));
    }

    public function testQrMatrixGeneratesFinderPatternsAndValidPngDataUri()
    {
        $url = qr_doc_url('sppk', '101', '');
        $matrix = Qr_matrix::encodeMatrix($url);
        $size = count($matrix);

        $this->assertGreaterThanOrEqual(21, $size);
        $this->assertEquals(0, ($size - 21) % 4);

        // Finder top-left 7x7 corners and center must be dark
        $this->assertEquals(1, $matrix[0][0]);
        $this->assertEquals(1, $matrix[3][3]);
        $this->assertEquals(0, $matrix[1][1]);
        // Dark module invariant at (size - 8, 8)
        $this->assertEquals(1, $matrix[$size - 8][8]);

        $pngDataUri = Qr_matrix::toPngDataUri($url, 180);
        $this->assertStringStartsWith('data:image/png;base64,', $pngDataUri);
        $rawPng = base64_decode(substr($pngDataUri, strlen('data:image/png;base64,')));
        $this->assertNotFalse($rawPng);
        $this->assertGreaterThan(150, strlen($rawPng));
    }

    public function testRenderedPngQrCodeDecodesBackToExactUrlAcrossLengths()
    {
        $payloads = array(
            'KPMH-SHORT',
            qr_doc_url('slip', '76788', '092026'),
            qr_doc_url('sppk', '3', ''),
            qr_doc_url('cuti', '10', '') . '&extra=' . str_repeat('X', 45)
        );

        foreach ($payloads as $payload) {
            $pngUri = Qr_matrix::toPngDataUri($payload, 180);
            $decoded = $this->decodeQrFromPngDataUri($pngUri);
            $this->assertEquals($payload, $decoded, 'Decoded QR bytes from PNG must match input payload exactly');
        }
    }

    public function testRenderQrDokumenHtmlAndPdfModes()
    {
        $htmlWeb = render_qr_dokumen('cuti', '15', '', 82, false);
        $this->assertContains('qr-wrapper', $htmlWeb);
        $this->assertContains('CUTI-', $htmlWeb);
        $this->assertContains('data:image/png;base64,', $htmlWeb);
        $this->assertNotContains('qrcode.min.js', $htmlWeb);

        $htmlPdf = render_qr_dokumen('slip', '300001', '092026', 78, true);
        $this->assertContains('SLIP-', $htmlPdf);
        $this->assertContains('data:image/png;base64,', $htmlPdf);
    }

    private function decodeQrFromPngDataUri($dataUri)
    {
        $raw = base64_decode(substr($dataUri, strlen('data:image/png;base64,')));
        $im = imagecreatefromstring($raw);
        $this->assertNotFalse($im);

        $w = imagesx($im);
        $h = imagesy($im);
        $this->assertEquals($w, $h);

        $isDarkPx = function ($x, $y) use ($im) {
            $idx = imagecolorat($im, $x, $y);
            $rgba = imagecolorsforindex($im, $idx);
            return $rgba['red'] < 128;
        };

        // Locate top-left finder first dark pixel to determine quiet zone & module pixel scale
        $firstX = null;
        for ($y = 0; $y < $h && $firstX === null; $y++) {
            for ($x = 0; $x < $w; $x++) {
                if ($isDarkPx($x, $y)) {
                    $firstX = $x;
                    break;
                }
            }
        }
        $this->assertNotNull($firstX);

        $finderDarkPx = 0;
        for ($x = $firstX; $x < $w; $x++) {
            if ($isDarkPx($x, $firstX)) {
                $finderDarkPx++;
            } else {
                break;
            }
        }
        $scale = (int)round($finderDarkPx / 7);
        $this->assertGreaterThan(0, $scale);

        $size = (int)round(($w - 2 * $firstX) / $scale);
        $this->assertEquals(0, ($size - 21) % 4);
        $version = (int)(($size - 17) / 4);

        // Sample center of every module
        $mat = array();
        for ($r = 0; $r < $size; $r++) {
            $row = array();
            $py = (int)floor($firstX + ($r + 0.5) * $scale);
            for ($c = 0; $c < $size; $c++) {
                $px = (int)floor($firstX + ($c + 0.5) * $scale);
                $row[] = $isDarkPx($px, $py) ? 1 : 0;
            }
            $mat[] = $row;
        }
        imagedestroy($im);

        // Extract Copy 1 and Copy 2 Format Info bits and assert ISO BCH parity + identical copies
        $copy1 = 0;
        for ($i = 0; $i < 6; $i++)  $copy1 |= ($mat[8][$i] << $i);
        $copy1 |= ($mat[8][7] << 6);
        $copy1 |= ($mat[8][8] << 7);
        $copy1 |= ($mat[7][8] << 8);
        for ($i = 9; $i < 15; $i++) $copy1 |= ($mat[14 - $i][8] << $i);

        $copy2 = 0;
        for ($i = 0; $i < 7; $i++)  $copy2 |= ($mat[$size - 1 - $i][8] << $i);
        for ($i = 7; $i < 15; $i++) $copy2 |= ($mat[8][$size - 15 + $i] << $i);

        $this->assertEquals($copy1, $copy2, 'Copy 1 and Copy 2 format bits in PNG must match');

        $unmaskedFmt = $copy1 ^ 0x5412;
        $ecLevel = ($unmaskedFmt >> 13) & 0x3;
        $mask    = ($unmaskedFmt >> 10) & 0x7;
        $this->assertEquals(0, $ecLevel, 'Expected ECC Level M (00)');

        // Verify BCH(15,5) remainder is 0 against generator x^10 + x^8 + x^5 + x^4 + x^2 + x + 1 (0x537)
        $rem = $unmaskedFmt;
        for ($shift = 4; $shift >= 0; $shift--) {
            if ($rem & (1 << ($shift + 10))) {
                $rem ^= (0x537 << $shift);
            }
        }
        $this->assertEquals(0, $rem, 'Format BCH(15,5) checksum must equal 0');

        // Reconstruct function mask map (finders, timing, dark module, alignment, version)
        $isFunc = array_fill(0, $size, array_fill(0, $size, false));
        $markRect = function ($r0, $c0, $hRect, $wRect) use (&$isFunc, $size) {
            for ($rr = $r0; $rr < $r0 + $hRect; $rr++) {
                for ($cc = $c0; $cc < $c0 + $wRect; $cc++) {
                    if ($rr >= 0 && $rr < $size && $cc >= 0 && $cc < $size) {
                        $isFunc[$rr][$cc] = true;
                    }
                }
            }
        };
        $markRect(0, 0, 9, 9);
        $markRect(0, $size - 8, 9, 8);
        $markRect($size - 8, 0, 8, 9);
        for ($i = 0; $i < $size; $i++) {
            $isFunc[6][$i] = true;
            $isFunc[$i][6] = true;
        }
        $isFunc[$size - 8][8] = true;

        $alignMap = array(
            1 => array(), 2 => array(6, 18), 3 => array(6, 22), 4 => array(6, 26),
            5 => array(6, 30), 6 => array(6, 34), 7 => array(6, 22, 38),
            8 => array(6, 24, 42), 9 => array(6, 26, 46), 10 => array(6, 28, 50)
        );
        $coords = isset($alignMap[$version]) ? $alignMap[$version] : array();
        foreach ($coords as $ar) {
            foreach ($coords as $ac) {
                if (($ar <= 8 && $ac <= 8) || ($ar <= 8 && $ac >= $size - 8) || ($ar >= $size - 8 && $ac <= 8)) {
                    continue;
                }
                $markRect($ar - 2, $ac - 2, 5, 5);
            }
        }
        if ($version >= 7) {
            $markRect($size - 11, 0, 3, 6);
            $markRect(0, $size - 11, 6, 3);
        }

        // Zig-zag read & unmask data bits
        $bits = array();
        $upward = true;
        for ($right = $size - 1; $right >= 1; $right -= 2) {
            if ($right === 6) $right = 5;
            for ($vert = 0; $vert < $size; $vert++) {
                $r = $upward ? ($size - 1 - $vert) : $vert;
                for ($dx = 0; $dx < 2; $dx++) {
                    $c = $right - $dx;
                    if ($isFunc[$r][$c]) continue;
                    $masked = false;
                    switch ($mask) {
                        case 0: $masked = (($r + $c) % 2) === 0; break;
                        case 1: $masked = ($r % 2) === 0; break;
                        case 2: $masked = ($c % 3) === 0; break;
                        case 3: $masked = (($r + $c) % 3) === 0; break;
                        case 4: $masked = (((int)floor($r / 2) + (int)floor($c / 3)) % 2) === 0; break;
                        case 5: $masked = ((($r * $c) % 2) + (($r * $c) % 3)) === 0; break;
                        case 6: $masked = (((($r * $c) % 2) + (($r * $c) % 3)) % 2) === 0; break;
                        case 7: $masked = (((($r + $c) % 2) + (($r * $c) % 3)) % 2) === 0; break;
                    }
                    $bits[] = $mat[$r][$c] ^ ($masked ? 1 : 0);
                }
            }
            $upward = !$upward;
        }

        // Convert unmasked bitstream into codewords and de-interleave per ISO/IEC 18004 Version M specs
        $specM = array(
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
        $this->assertArrayHasKey($version, $specM);
        list($totalDataCw, $ecCwPerBlock, $g1Blocks, $g1DataCw, $g2Blocks, $g2DataCw) = $specM[$version];

        $rawCw = array();
        $totalCw = $totalDataCw + ($g1Blocks + $g2Blocks) * $ecCwPerBlock;
        for ($i = 0; $i < $totalCw; $i++) {
            $cw = 0;
            for ($b = 0; $b < 8; $b++) {
                $cw = ($cw << 1) | $bits[($i * 8) + $b];
            }
            $rawCw[] = $cw;
        }

        // De-interleave data codewords into blocks
        $numBlocks = $g1Blocks + $g2Blocks;
        $blocks = array_fill(0, $numBlocks, array());
        $cwIdx = 0;
        $maxDataLen = max($g1DataCw, $g2DataCw);
        for ($col = 0; $col < $maxDataLen; $col++) {
            for ($b = 0; $b < $numBlocks; $b++) {
                $bLen = ($b < $g1Blocks) ? $g1DataCw : $g2DataCw;
                if ($col < $bLen) {
                    $blocks[$b][] = $rawCw[$cwIdx++];
                }
            }
        }
        $dataBits = array();
        foreach ($blocks as $blk) {
            foreach ($blk as $cw) {
                for ($b = 7; $b >= 0; $b--) {
                    $dataBits[] = ($cw >> $b) & 1;
                }
            }
        }

        $readInt = function ($offset, $len) use (&$dataBits) {
            $v = 0;
            for ($k = 0; $k < $len; $k++) {
                $v = ($v << 1) | $dataBits[$offset + $k];
            }
            return $v;
        };

        $mode = $readInt(0, 4);
        $this->assertEquals(4, $mode, 'Expected Byte mode (0100)');
        $lenBits = ($version <= 9) ? 8 : 16;
        $byteLen = $readInt(4, $lenBits);
        $out = '';
        for ($i = 0; $i < $byteLen; $i++) {
            $out .= chr($readInt(4 + $lenBits + $i * 8, 8));
        }
        return $out;
    }
}
