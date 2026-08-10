<?php
$dir = new RecursiveDirectoryIterator('application/views/');
$ite = new RecursiveIteratorIterator($dir);

$css_features = "
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            width: 400px;
            height: auto;
        }
        /* Nomor Surat */
        .nomor-surat {
            text-align: left;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        /* QR Code */
        .qr-code {
            width: 70px;
            height: 70px;
            margin: 10px auto;
            display: block;
        }";

$watermark_html = "\n    <img src=\"<?php echo base_url('assets/img/kpmh.png') ?>\" class=\"watermark\">\n";

$nomor_surat_logic = '
    <?php
    $bulanRomawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    $noSurat = "Nomor : " . date(\'ymd\') . "/HRD-KPMH/" . $bulanRomawi[date(\'n\')] . "/" . date(\'Y\');
    ?>
    <div class="nomor-surat"><?php echo $noSurat; ?></div>
';

$qr_html = '
            <img src="<?php echo base_url(\'assets/img/qr-dummy.png\') ?>" class="qr-code" alt="Validasi Digital">
            <p style="font-size:10px; margin-top:-5px; font-style:italic;">Validasi Digital</p>
';

$count = 0;
foreach($ite as $file) {
    if ($file->isFile() && preg_match('/cetak_.*\.php$/', $file->getFilename())) {
        $path = $file->getPathname();
        $content = file_get_contents($path);

        $changed = false;

        // 1. Inject CSS
        if (strpos($content, '.watermark {') === false) {
            $content = str_replace('</style>', $css_features . "\n    </style>", $content);
            $changed = true;
        }

        // 2. Inject Watermark after <body>
        if (strpos($content, 'class="watermark"') === false) {
            $content = preg_replace('/<body>/i', "<body>" . $watermark_html, $content);
            $changed = true;
        }

        // 3. Inject Nomor Surat after <hr class="kop-line-2">
        if (strpos($content, 'class="nomor-surat"') === false) {
            $content = preg_replace('/<hr class="kop-line-2">/i', '<hr class="kop-line-2">' . $nomor_surat_logic, $content);
            $changed = true;
        }

        // 4. Inject QR Code inside the signature box (either replacing <br><br> or before the name)
        // Find Mengetahui,</p> and inject QR Code right after
        if (strpos($content, 'class="qr-code"') === false) {
            // For reports that use <p>Mengetahui,</p>
            if (preg_match('/<p>Mengetahui,<\/p>/is', $content)) {
                $content = preg_replace('/<p>Mengetahui,<\/p>(\s*<p style="margin-bottom: 70px;">.*?<\/p>)?/is', "<p>Mengetahui,</p>$1\n" . $qr_html, $content);
                // We also replace the `<br><br><br><br>` in slip gaji if it exists
                $content = preg_replace('/<br>\s*<br>\s*<br>\s*<br>/is', '', $content);
                // Change margin-bottom: 70px to something smaller since QR takes space
                $content = preg_replace('/margin-bottom:\s*70px;/i', 'margin-bottom: 5px;', $content);
                $changed = true;
            }
        }

        if ($changed) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
            $count++;
        }
    }
}
echo "Total updated: $count files\n";
?>
