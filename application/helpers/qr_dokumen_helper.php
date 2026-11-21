<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('qr_doc_secret')) {
	function qr_doc_secret() {
		$CI =& get_instance();
		$key = $CI->config->item('encryption_key');
		if (!empty($key)) {
			return hash('sha256', $key . '|KPMH_HRIS_DOC_V1');
		}
		return hash('sha256', 'KPMH_BANJARBARU_HRIS_SIGNED_DOC_SECRET_2026');
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

if (!function_exists('render_qr_dokumen')) {
	function render_qr_dokumen($tipe, $ref, $periode = '', $size = 82) {
		static $script_emitted = false;

		$url  = qr_doc_url($tipe, $ref, $periode);
		$sig  = qr_doc_signature($tipe, $ref, $periode);
		$code = strtoupper($tipe) . '-' . $sig;
		$size = max(64, (int)$size);

		$html = '';
		if (!$script_emitted) {
			$script_emitted = true;
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
					overflow: hidden !important;
				}
				.qr-doc-box canvas {
					display: none !important;
				}
				.qr-doc-box img.qr-doc-img {
					display: block !important;
					width: 100% !important;
					height: 100% !important;
					max-width: 100% !important;
					max-height: 100% !important;
					margin: 0 !important;
					padding: 0 !important;
					border: 0 !important;
					object-fit: contain !important;
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
			$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>';
			$html .= '<script>
				document.addEventListener("DOMContentLoaded", function() {
					if (typeof QRCode === "undefined") return;
					var nodes = document.querySelectorAll(".qr-doc-box[data-qr-url]");
					nodes.forEach(function(el) {
						if (el.dataset.qrRendered === "1") return;
						var url = el.getAttribute("data-qr-url");
						var sz  = parseInt(el.getAttribute("data-qr-size"), 10) || 82;

						// Render pada elemen sementara agar hanya 1 gambar PNG tajam yang masuk ke DOM (mencegah duplikasi canvas + img)
						var scratch = document.createElement("div");
						new QRCode(scratch, {
							text: url,
							width: sz * 2,
							height: sz * 2,
							colorDark: "#0F172A",
							colorLight: "#FFFFFF",
							correctLevel: QRCode.CorrectLevel.M
						});

						var canvas = scratch.querySelector("canvas");
						var imgEl  = document.createElement("img");
						imgEl.className = "qr-doc-img";
						imgEl.alt = "QR Verifikasi Digital HRIS";
						imgEl.width = sz;
						imgEl.height = sz;

						if (canvas && typeof canvas.toDataURL === "function") {
							imgEl.src = canvas.toDataURL("image/png");
						} else {
							var fallbackImg = scratch.querySelector("img");
							if (fallbackImg && fallbackImg.src) {
								imgEl.src = fallbackImg.src;
							}
						}

						if (imgEl.src) {
							el.innerHTML = "";
							el.appendChild(imgEl);
							el.dataset.qrRendered = "1";
						}
					});
				});
			</script>';
		}

		$html .= '<a class="qr-doc-link" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" title="Pindai atau klik QR Code untuk memverifikasi keaslian dokumen">';
		$html .= '<span class="qr-doc-box" style="width: ' . $size . 'px; height: ' . $size . 'px;" data-qr-url="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" data-qr-size="' . $size . '">';
		$html .= '<span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-size:9px;line-height:1.2;color:#334155;text-align:center;">QR<br>' . htmlspecialchars($sig, ENT_QUOTES, 'UTF-8') . '</span>';
		$html .= '</span>';
		$html .= '<span class="qr-doc-code">' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</span>';
		$html .= '</a>';

		return $html;
	}
}
