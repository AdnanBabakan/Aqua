<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file will help you debug your program easily
 */

namespace Aqua;

class ErrorHandler
{
    public static function error_handler($code, $message, $file, $line)
    {
        echo <<<HTML
<!DOCTYPE html>
<div style="background: #eeeeee; position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 9999999999999999999999999999999999; overflow: scroll; line-height: 50px; font-family: monospace;">
    <span style="font-size: 28px; font-weight: 300;">Aqua Error:</span><br>[{$code}] {$message} - File: '{$file}' - Line: '{$line}'
</div>
HTML;
        die;
    }

    public static function fatal_error_handler()
    {
        $last_error = error_get_last();
        if ($last_error['type'] === E_ERROR) {
            // fatal error
            self::error_handler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }
}