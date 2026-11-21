<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wrapper Dompdf untuk ekspor PDF server-side dokumen resmi HRIS Klinik Hidayatullah.
 */
class Pdf_exporter
{
    public function stream($html, $filename = 'dokumen.pdf', $paper = 'A4', $orientation = 'portrait', $download = true)
    {
        $autoload = FCPATH . 'vendor/autoload.php';
        if (!file_exists($autoload)) {
            show_error('Dependensi Dompdf (vendor/autoload.php) tidak ditemukan.', 500);
            return;
        }
        require_once $autoload;

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        $safeName = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $filename);
        if (substr(strtolower($safeName), -4) !== '.pdf') {
            $safeName .= '.pdf';
        }

        $dompdf->stream($safeName, array('Attachment' => $download ? 1 : 0));
    }

    public static function localImageDataUri($relativePath)
    {
        $fullPath = FCPATH . ltrim(str_replace('\\', '/', $relativePath), '/');
        if (!file_exists($fullPath) || !is_readable($fullPath)) {
            return '';
        }
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $mime = ($ext === 'png') ? 'image/png' : (($ext === 'svg') ? 'image/svg+xml' : 'image/jpeg');
        $raw = file_get_contents($fullPath);
        return 'data:' . $mime . ';base64,' . base64_encode($raw);
    }
}
