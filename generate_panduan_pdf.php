<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);

$htmlFile = __DIR__ . '/panduan_ujian_skripsi.html';
if (!file_exists($htmlFile)) {
    die("HTML file not found: $htmlFile\n");
}

$html = file_get_contents($htmlFile);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$pdfPath = __DIR__ . '/PANDUAN_SIMULASI_UJIAN_SKRIPSI_CRUD_CI3.pdf';
file_put_contents($pdfPath, $dompdf->output());

echo "PDF_SUCCESS: Generated " . round(filesize($pdfPath)/1024, 2) . " KB at " . $pdfPath . "\n";
