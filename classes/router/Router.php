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
    protected static $current_route;
    protected static $current_route_address;
    protected static $allies = [];

    public static function route(string $route, $function)
    {
        $route[0] == '/' or $route = '/' . $route;
        self::$current_route_address = $route;
        $methods = "ALL";
        if (preg_match('/^\[(.*?)\]/', $route, $match)) {
            $methods = explode('|', $match[1]);
        }
        self::$routes[] = [
            "route" => preg_replace('/^\[(.*?)\]/', '', $route),
            "function" => $function,
            "methods" => $methods
        ];

        return new class
        {
            public function __call($name, $arguments)
            {
                Router::add_route_option($name, ...$arguments);
                return $this;
            }
        };
    }

    public static function add_route_option($name, ...$arguments)
    {
        switch ($name) {
            case 'rules':
                $i = 0;
                foreach (self::$routes as $route) {
                    if ($route['route'] == self::$current_route_address) {
                        self::$routes[$i][$name] = count($arguments) == 1 ? $arguments[0] : $arguments;
                    }
                    $i++;
                }
                break;
            case 'name':
                self::$allies[$arguments[0]] = self::$current_route_address;
                break;
            default:
                try {
                    throw new AquaException(__('ROUTER_CHAIN_NOT_DEFINED', 'core', $name));
                } catch (AquaException $e) {
                    echo $e;
                }
                break;
        }
    }

    public static function use_ally(string $name, array $params = []) : void
    {
        $address = self::$allies[$name];
        $address = preg_replace_callback('/{(.*?)}/', function($m) use ($params) {
            return isset($params[$m[1]])?$params[$m[1]]:$m[0];
        }, $address);
        self::location($address);
    }

    public static function route_to_ally(string $route, string $name, array $params = []) : void
    {
        self::route($route, function() use ($name, $params) {
            self::use_ally($name, $params);
        });
    }

    public static function redirect(string $route, string $address, $code = 302): void
    {
        self::route($route, function () use ($address, $code) {
            self::location($address, $code);
        });
    }

    public static function permanent_redirect(string $route, string $address): void
    {
        self::redirect($route, $address, 301);
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
    protected static $regex_shortcuts = [
        "{\?(.*?)}" => "(\/?([^\/]*?)+)",
        "{(.*?)}" => "(\/([^\/]+?)+)"
    ];

    protected static function regex_shortcuts($string): string
    {
        $string[0] == '/' or $string = '/' . $string;
        $string = preg_replace('/\/$/', '', $string);
        $string = preg_replace('/^\//', '\\/', $string);

        foreach (self::$regex_shortcuts as $k => $v) {
            $string = preg_replace('/\/' . $k . '/', $v, $string);
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
        $params_keys = [];
        $s = self::$current_route['route'];
        $explode_route = explode("/", $s);
        foreach ($explode_route as $v) {
            if ($v != "") {
                if (preg_match('/{(.*?)}/', $v)) {
                    $params_position[] = array_search($v, $explode_route);
                    $params_keys[] = preg_replace('/{|}/', '', $v);
                }
            }
        }
        $path_explode = explode("/", __PATH__);
        foreach ($path_explode as $v) {
            if (empty($v)) {
                unset($path_explode[array_search($v, $path_explode)]);
            }
        }
        $i = 0;
        foreach ($params_position as $v) {
            $params[$params_keys[$i]] = isset($path_explode[$v]) ? $path_explode[$v] : Null;
            $i++;
        }
        return $params;
    }

    protected static $appends = '';

    public static function append($string): void
    {
        if (gettype($string) == 'object') {
            self::$appends .= $string();
        } else {
            self::$appends .= $string;
        }
    }

    public static function run(): void
    {
        $page_found = 0;
        foreach (self::$routes as $route) {
            if (preg_match('/^' . self::regex_shortcuts($route['route']) . '(\/)$/', __PATH__)) {
                self::$current_route = $route;
                $params = self::extract_url_params();
                $all_params_matches_rules = true;
                if (isset(self::$current_route['rules'])) {
                    foreach (self::$current_route['rules'] as $k => $v) {
                        preg_match('/^' . $v . '$/', $params[$k]) or $all_params_matches_rules = false;
                    }
                }
                if (($route['methods'] == 'ALL' or in_array($_SERVER['REQUEST_METHOD'], $route['methods'])) and $all_params_matches_rules) {
                    $page_found++;
                    if (gettype($route['function']) == 'object') {
                        echo $route['function'](...array_values($params));
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
                }
            }
        }
        if ($page_found == 0) {
            self::run_map('404');
        }
        echo self::$appends;
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
            echo 'Aqua Error!';
        }
    }

    public static function location(string $address, $code = 302): void
    {
        if (preg_match('/^http(s)?:\/\//i', $address)) {
            $redirect_address = $address;
        } else {
            $redirect_address = Core::config()->general->www . ($address[0] != '/' ? '/' : '') . $address;
        }
        http_response_code($code);
        header("Location: " . $redirect_address);
    }
}