<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This trait will help to handle the headers of requests
 */

namespace Aqua;

trait Headers
{
    public function header()
    {
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }
        $headers = array_merge(apache_request_headers(), ["Origin" => $origin]);
        return json_decode(json_encode($headers));
    }
}