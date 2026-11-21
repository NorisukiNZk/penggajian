<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Konfigurasi Keamanan Aplikasi HRIS Klinik Hidayatullah
|--------------------------------------------------------------------------
*/
$is_prod = (defined('ENVIRONMENT') && ENVIRONMENT === 'production');

$config['recaptcha_site_key'] = getenv('RECAPTCHA_SITE_KEY')
	? getenv('RECAPTCHA_SITE_KEY')
	: ($is_prod ? '' : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI');

$config['recaptcha_secret_key'] = getenv('RECAPTCHA_SECRET_KEY')
	? getenv('RECAPTCHA_SECRET_KEY')
	: ($is_prod ? '' : '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe');

$config['show_demo_chips']      = !$is_prod;
$config['min_password_length']  = 8;
$config['login_max_attempts']   = 5;
$config['login_lockout_seconds'] = 300;
