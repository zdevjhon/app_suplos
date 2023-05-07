<?php

namespace App\Config;

date_default_timezone_set('America/Lima');

class ErrorLog {

    public static function activateErrorLog()
    {
        error_reporting(E_ALL ^ E_NOTICE);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', FALSE);
        ini_set('log_errors', TRUE);
        ini_set('error_log', dirname(__DIR__) . '/Logs/php-error.log');
    }
}