<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes across the appliaction
 */

namespace Aqua;

class Router
{

    protected static $routes = [];
    protected static $maps = [];

    protected static $regex_shortcuts = [
        "{(.*?)}" => "(.*?)+"
    ];

    protected static $current_route;

    /**
     * @param string $route
     * @param $function
     */
    public static function route(string $route, $function): void
    {
        $methods = "ALL";
        if (preg_match('/^\[(.*?)\]/', $route, $match)) {
            $methods = explode('|', $match[1]);
        }

        self::$routes[] = [
            "route" => preg_replace('/^\[(.*?)\]/', '', $route),
            "function" => $function,
            "methods" => $methods
        ];
    }

    /**
     * @param string $name
     * @param $function
     */
    public static function map(string $name, $function): void
    {
        self::$maps[$name] = $function;
    }

    /**
     * @param $string
     * @return string
     */
    protected static function regex_shortcuts($string): string
    {
        foreach (self::$regex_shortcuts as $k => $v) {
            $string = preg_replace('/' . $k . '/', $v, $string);
        }

        return $string;
    }

    /**
     * @return array
     */
    protected static function extract_url_params(): array
    {
        $params = [];
        $params_position = [];

        $s = self::$current_route['route'];

        $explode_route = explode("/", $s);

        foreach ($explode_route as $v) {
            if ($v != "") {
                if (preg_match('/{(.*?)}/', $v)) {
                    array_push($params_position, array_search($v, $explode_route));
                }
            }
        }

        $path_explode = explode("/", __PATH__);

        foreach ($path_explode as $v) {
            if (empty($v)) {
                unset($path_explode[array_search($v, $path_explode)]);
            }
        }

        foreach ($params_position as $v) {
            array_push($params, $path_explode[$v]);
        }

        return $params;
    }

    protected static $appends = '';

    public static function append($string) : void
    {
        if(gettype($string)=='object') {
            self::$appends .= $string();
        } else {
            self::$appends .= $string;
        }
    }

    public static function run(): void
    {
        $page_found = false;
        foreach (self::$routes as $route) {
            if (preg_match('/^' . str_replace('/', '\/', self::regex_shortcuts($route['route'])) . '(\/)$/', (__PATH__ == '/' ? '//' : __PATH__))) {
                $page_found = true;
                if ($route['methods'] == 'ALL' or in_array($_SERVER['REQUEST_METHOD'], $route['methods'])) {
                    self::$current_route = $route;
                    $params = self::extract_url_params();
                    if (gettype($route['function']) == 'object') {
                        echo $route['function'](...$params);
                    } elseif (gettype($route['function']) == 'string') {
                        $f = explode('@', $route['function']);
                        require_once __ROOT__ . '/controllers/' . $f[1] . '.php';
                        $class = '\\' . $f[1] . '\\' . $f[1];
                        $instance = new $class;
                        $return_value = $instance->{$f[0]}(...$params);
                        switch (gettype($return_value)) {
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
                } else {
                    $page_found = false;
                }
            } else {
                $page_found = false;
            }
        }

        if (!$page_found) {
            self::run_map('404');
        }

        $appended = self::$appends;
        echo <<<HTML
        <!--AQUA_APPEND-->
        {$appended}
        <!--AQUA_APPEND-->
HTML;
    }

    /**
     * @param $name
     */
    protected static function run_map($name)
    {
        http_response_code($name);
        if (array_key_exists($name, self::$maps)) {
            $map = self::$maps[$name];
            if (gettype($map) == 'object') {
                echo $map();
            } elseif (gettype($map) == 'string') {
                $f = explode('@', $map);
                require_once __ROOT__ . '/controllers/' . $f[1] . '.php';
                $class = '\\' . $f[1] . '\\' . $f[1];
                $instance = new $class;
                $return_value = $instance->{$f[0]}();
                switch (gettype($return_value)) {
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
        } else {
            echo 'Aqua 404 error!';
        }
    }
}