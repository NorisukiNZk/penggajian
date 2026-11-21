<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('qr_doc_secret')) {
	function qr_doc_secret() {
		if (function_exists('get_instance')) {
			$CI =& get_instance();
			if ($CI && isset($CI->config)) {
				$key = $CI->config->item('encryption_key');
				if (!empty($key)) {
					return hash('sha256', $key . '|KPMH_HRIS_DOC_V1');
				}
			}
		}
		$envKey = getenv('APP_ENCRYPTION_KEY');
		if (!empty($envKey)) {
			return hash('sha256', $envKey . '|KPMH_HRIS_DOC_V1');
		}
		return hash('sha256', 'kpmh_hris_2026_9f3c7a1b8e4d206a5c3f8b1e7d4a92c1|KPMH_HRIS_DOC_V1');
	}
}

if (!function_exists('qr_doc_signature')) {
	function qr_doc_signature($tipe, $ref, $periode = '') {
		$payload = strtoupper(trim((string)$tipe)) . '|' . trim((string)$ref) . '|' . trim((string)$periode);
		return strtoupper(substr(hash_hmac('sha256', $payload, qr_doc_secret()), 0, 12));
	}
}

if (!function_exists('qr_doc_verify_signature')) {
	function qr_doc_verify_signature($tipe, $ref, $periode, $sig) {
		$expected = qr_doc_signature($tipe, $ref, $periode);
		return hash_equals($expected, strtoupper(trim((string)$sig)));
	}
}

if (!function_exists('qr_doc_url')) {
	function qr_doc_url($tipe, $ref, $periode = '') {
		$tipe    = strtolower(trim((string)$tipe));
		$ref     = trim((string)$ref);
		$periode = trim((string)$periode);
		$sig     = qr_doc_signature($tipe, $ref, $periode);

		return base_url(
			'verifikasi/cek?tipe=' . rawurlencode($tipe)
			. '&ref=' . rawurlencode($ref)
			. '&periode=' . rawurlencode($periode)
			. '&sig=' . rawurlencode($sig)
		);
	}
}

if (!function_exists('qr_doc_data_uri')) {
	function qr_doc_data_uri($url, $size = 82) {
		if (!class_exists('Qr_matrix', false)) {
			$libPath = defined('APPPATH')
				? APPPATH . 'libraries/Qr_matrix.php'
				: dirname(__DIR__) . '/libraries/Qr_matrix.php';
			if (file_exists($libPath)) {
				require_once $libPath;
			}
		}
		if (class_exists('Qr_matrix', false)) {
			return Qr_matrix::toPngDataUri($url, max(160, (int)$size * 2));
		}
		return '';
	}
}

if (!function_exists('render_qr_dokumen')) {
	function render_qr_dokumen($tipe, $ref, $periode = '', $size = 82, $for_pdf = false) {
		static $style_emitted = false;

		$url     = qr_doc_url($tipe, $ref, $periode);
		$sig     = qr_doc_signature($tipe, $ref, $periode);
		$code    = strtoupper($tipe) . '-' . $sig;
		$size    = max(64, (int)$size);
		$dataUri = qr_doc_data_uri($url, $size);

		$html = '';
		if (!$for_pdf && !$style_emitted) {
			$style_emitted = true;
			$html .= '<style>
				.qr-wrapper {
					width: auto !important;
					height: auto !important;
					margin: 6px auto 8px auto !important;
					text-align: center !important;
				}
				.qr-doc-link {
					display: inline-flex !important;
					flex-direction: column !important;
					align-items: center !important;
					justify-content: center !important;
					text-decoration: none !important;
					color: #18293D !important;
				}
				.qr-doc-box {
					display: block !important;
					box-sizing: content-box !important;
					background: #FFFFFF !important;
					padding: 5px !important;
					border: 1px solid #CBD5E1 !important;
					border-radius: 6px !important;
					line-height: 0 !important;
				}
				.qr-doc-box img.qr-doc-img {
					display: block !important;
					width: 100% !important;
					height: 100% !important;
					margin: 0 !important;
					padding: 0 !important;
					border: 0 !important;
					image-rendering: pixelated;
				}
				.qr-doc-code {
					margin-top: 5px !important;
					font-family: "Courier New", Consolas, monospace !important;
					font-size: 9px !important;
					font-weight: 700 !important;
					letter-spacing: 0.04em !important;
					color: #334155 !important;
					line-height: 1.2 !important;
				}
			</style>';
		}

		if ($for_pdf) {
			$html .= '<div style="text-align:center; margin: 4px auto;">';
			if ($dataUri !== '') {
				$html .= '<img src="' . $dataUri . '" width="' . $size . '" height="' . $size . '" style="border:1px solid #CBD5E1; padding:3px; background:#FFFFFF;" alt="QR Verifikasi">';
			}
			$html .= '<div style="font-family: Courier, monospace; font-size: 8.5px; font-weight: bold; color: #334155; margin-top: 3px;">'
				. htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</div>';
			$html .= '</div>';
			return $html;
		}

		$html .= '<a class="qr-doc-link" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" title="Pindai atau klik QR Code untuk memverifikasi keaslian dokumen">';
		$html .= '<span class="qr-doc-box" style="width: ' . $size . 'px; height: ' . $size . 'px;">';
		if ($dataUri !== '') {
			$html .= '<img class="qr-doc-img" src="' . $dataUri . '" width="' . $size . '" height="' . $size . '" alt="QR Verifikasi Digital HRIS">';
		} else {
			$html .= '<span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:9px;color:#334155;">' . htmlspecialchars($sig, ENT_QUOTES, 'UTF-8') . '</span>';
		}
		$html .= '</span>';
		$html .= '<span class="qr-doc-code">' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</span>';
		$html .= '</a>';

		return $html;
	}
}
