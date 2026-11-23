<?php
if (!defined('BASEPATH')) {
    define('BASEPATH', __DIR__ . '/../system/');
}
if (!defined('APPPATH')) {
    define('APPPATH', __DIR__ . '/../application/');
}
if (!defined('FCPATH')) {
    define('FCPATH', __DIR__ . '/../');
}

if (!function_exists('base_url')) {
    function base_url($uri = '') {
        return 'http://localhost/penggajian/' . ltrim((string)$uri, '/');
    }
}

require_once APPPATH . 'libraries/Payroll_calculator.php';
require_once APPPATH . 'libraries/Payroll_diff_explainer.php';
require_once APPPATH . 'libraries/Attendance_policy.php';
require_once APPPATH . 'libraries/Qr_matrix.php';
require_once APPPATH . 'helpers/qr_dokumen_helper.php';

if (!class_exists('PHPUnit_Framework_TestCase', false) && class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
}

if (!class_exists('PHP_Timer', false)) {
    class PHP_Timer
    {
        private static $times = array();
        private static $reqStart = null;

        public static function start()
        {
            if (self::$reqStart === null) {
                self::$reqStart = microtime(true);
            }
            self::$times[] = microtime(true);
        }

        public static function stop()
        {
            $start = array_pop(self::$times);
            return $start ? max(0.0, microtime(true) - $start) : 0.0;
        }

        public static function resourceUsage()
        {
            $elapsed = self::$reqStart ? (microtime(true) - self::$reqStart) : 0.0;
            return sprintf('Time: %.2f seconds, Memory: %.2f MB', $elapsed, memory_get_peak_usage(true) / 1048576);
        }
    }
}
