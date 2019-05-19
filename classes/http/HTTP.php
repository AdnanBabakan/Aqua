<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This static class will help you handle https requests
 */

namespace Aqua;

class Http
{
    public static function redirect(string $address)
    {
        if(preg_match('/^http(s)?:\/\//i', $address)) {
            $redirect_address = $address;
        } else {
            $redirect_address = Core::config()->general->www . ($address[0]!='/'?'/':'') . $address;
        }

        header("Location: " . $redirect_address);
    }
}