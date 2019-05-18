<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This static class will help you handle the params which are sent by forms
 */

namespace Aqua;

class Input
{
    public static function params(string $name = Null, $type = Null)
    {
        if(!$type) {
            $params = array_merge($_GET, $_POST);
        } else if($type == 'GET') {
            $params = $_GET;
        } else if($type == 'POST') {
            $params = $_POST;
        }
        if($name) {
            return htmlspecialchars($params[$name]);
        } else {
            return array_map('htmlspecialchars', $params);
        }
    }

    public static function POST(string $name = Null)
    {
        return self::params($name, 'POST');
    }

    public static function GET(string $name = Null)
    {
        return self::params($name, 'GET');
    }
}