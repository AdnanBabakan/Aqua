<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
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

    public static function route(string $r, $f) : void
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
            if(preg_match('/^' . str_replace('/', '\/', self::regex_shortcuts($route['route'])) . '(\/)$/', (__PATH__=='/'?'//':__PATH__))) {
                self::$current_route = $route;
                $params = self::extract_url_params();
                if(gettype($route['function'])=='object') {
                    echo self::$current_route['function'](...$params);
                } elseif(gettype($route['function'])=='string') {
                    $f = explode('@', $route['function']);
                    require_once __ROOT__ . '/controllers/' . $f[1] . '.php';
                    $class = '\\' . $f[1] . '\\' . $f[1];
                    $instance = new $class;
                    $return_value = $instance->{$f[0]}(...$params);
                    switch(gettype($return_value)) {
                        case 'array':
                        case 'object':
                            header('Content-Type: application/json;');
                            echo json_encode($return_value);
                        break;
                        default:
                            header('Content-Type: ' . $instance->content_type . ';');
                            echo $return_value;
                    }
                }
            }
        }
    }
}