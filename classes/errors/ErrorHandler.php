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
        $escaped_file_address = str_replace('\\', '\\\\', $file);
        echo <<<HTML
<!DOCTYPE html>
<div style="background: #efefef; position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 9999999999999999999999999999999999; overflow: scroll; line-height: 50px; font-family: monospace;">
    <div style="background: #1B1464; font-size: 28px; font-weight: 300; padding: 10px; color: #ffffff;">Aqua Error</div>
    <p style="padding: 25px;">[{$code}] {$message} - File: '{$file}' - Line: '{$line}'</p>
    <script>
        window.onload = function() {
            document.title = "Aqua Error: [{$code}] {$message} File: '{$escaped_file_address}' - Line: '{$line}'";
        }
    </script>
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