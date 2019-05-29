<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This class will help you protect your application from CSRF attacks
 */

namespace Aqua;

class CSRF
{
    public function __construct()
    {
        $life_span = isset(Core::config()->general->csrf_life_span)?Core::config()->general->csrf_life_span:3600;
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = base64_encode(Misc::generate_random_string(25) . '=' . (time() + $life_span));
        } else {
            $token_expire = explode('=', base64_decode($_SESSION['csrf_token']))[1];
            if ($token_expire < time()) {
                $_SESSION['csrf_token'] = base64_encode(Misc::generate_random_string(25) . '=' . (time() + $life_span));
            }
        }
    }

    public static function csrf_token() : string
    {
        return $_SESSION['csrf_token'];
    }

    public static function csrf_token_input() : string
    {
        return '<input type="hidden" name="csrf_token" id="csrf_token" value="' . $_SESSION['csrf_token'] . '" />';
    }
}