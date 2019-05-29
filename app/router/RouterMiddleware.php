<?php

namespace Aqua;

trait RouterMiddleware
{
    public static $global_middleware;

    public static function register_global_middleware($name)
    {
        $middleware_name = explode('\\', $name);
        $middleware_name = end($middleware_name);
        require_once __ROOT__ . '/middlewares/' . $middleware_name . '.php';
        $reflection_class = new \ReflectionClass($name);
        if (!in_array('Aqua\MiddlewareInterface', $reflection_class->getInterfaceNames())) {
            try {
                throw new AquaException(__('MIDDLEWARE_INTERFACE_ERROR', 'core', $middleware_name));
            } catch (AquaException $e) {
                echo $e;
            }
        } else {
            self::$global_middleware = new $name;
        }
    }
}