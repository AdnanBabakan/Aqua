<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
 * @Source https://github.com/bramus/router
 */

namespace Aqua;

use \Aqua\Core as Core;

class Router
{

    protected static $routes = [];

    protected static $regex_shortcuts = [
        "{(.*?)}" => "(.*?)+"
    ];

    protected static $current_route;

    public static function route($r, $f) : void
    {
        array_push(self::$routes, [
            "route" => $r,
            "function" => $f
        ]);
    }

    protected static function regex_shortcuts($s) : string
    {
        foreach(self::$regex_shortcuts as $k => $v) {
            $s = preg_replace('/' . $k . '/', $v, $s);
        }

        return $s;
    }

    protected static function extract_url_params() : array
    {
        $params = [];
        $params_position = [];

        $s = self::$current_route['route'];

        $explode_route = explode("/", $s);

        foreach($explode_route as $v) {
            if($v!="") {
                if(preg_match('/{(.*?)}/', $v)) {
                    array_push($params_position, array_search($v, $explode_route));
                }
            }
        }

        $path_explode = explode("/", __PATH__);

        foreach($path_explode as $v) {
            if(empty($v)) {
                unset($path_explode[array_search($v, $path_explode)]);
            }
        }

        foreach($params_position as $v) {
            array_push($params, $path_explode[$v]);
        }

        return $params;
    }

    public static function run() : void
    {
        foreach(self::$routes as $route) {
            if(preg_match('/^' . str_replace('/', '\/', self::regex_shortcuts($route['route'])) . '(\/)$/', __PATH__)) {
                self::$current_route = $route;
                echo self::$current_route['function'](...self::extract_url_params());
            }
        }
    }
}