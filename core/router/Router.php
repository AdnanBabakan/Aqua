<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
 * @Source https://github.com/bramus/router
 */

namespace Aqua;

class Router
{

    protected static $routes = [];

    public static function route($r, $f) : void
    {
        array_push(self::$routes, [
            "route" => $r,
            "function" => $f
        ]);
    }

    public static function run() : void
    {
        foreach(self::$routes as $route) {
            if(preg_match('/^' . str_replace('/', '\/', $route['route']) . '$/', __PATH__, $match)) {
                echo 'Yes!';
            }
        }
    }
}