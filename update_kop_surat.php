<?php
$dir = new RecursiveDirectoryIterator('application/views/');
$ite = new RecursiveIteratorIterator($dir);

$css_new = "
        /* Tampilan Header Klinik Baru */
        table.kop-surat {
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 5px;
        }
        table.kop-surat img {
            width: 110px;
            height: auto;
        }
        table.kop-surat h1 {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
            color: #000;
        }
        table.kop-surat h2 {
            font-size: 14px;
            font-weight: normal;
            margin: 5px 0 0 0;
            color: #333;
        }
        table.kop-surat p {
            font-size: 13px;
            margin: 5px 0 0 0;
        }
        .kop-line-2 {
            border: 0;
            border-top: 1px solid black;
            height: 1px;
            margin: 0 0 20px 0;
        }";

$html_new = '    <table class="kop-surat">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="<?php echo base_url(\'assets/img/kpmh.png\') ?>" alt="Logo Klinik">
            </td>
            <td width="70%" style="text-align: center;">
                <h1>KLINIK PRATAMA HIDAYATULLAH</h1>
                <h2>Jl. A. Yani KM 23 RT 01 RW 02, Kel. Landasan Ulin, Kec. Liang Anggang Banjarbaru</h2>
                <p><strong>Telp:</strong> (0511) XXXXXXX | <strong>Email:</strong> klinik.kpmh@gmail.com</p>
            </td>
            <td width="15%" style="text-align: center;">
                <!-- Ruang kosong atau logo kedua jika ada -->
            </td>
        </tr>
    </table>
    <hr class="kop-line-2">';

$count = 0;
foreach($ite as $file) {
    if ($file->isFile() && preg_match('/cetak_.*\.php$/', $file->getFilename())) {
        $path = $file->getPathname();
        $content = file_get_contents($path);

        $pattern = '/<div class="header">.*?<hr class="kop-line">\s*<\/div>/is';
        if(preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $html_new, $content);
            
            if (strpos($content, 'table.kop-surat') === false) {
                $content = str_replace('</style>', $css_new . "\n    </style>", $content);
            }
            
            file_put_contents($path, $content);
            echo "Updated: $path\n";
            $count++;
        } else {
            echo "Skipped (no header div): $path\n";
        }
    }
}
echo "Total updated: $count files\n";
?>
