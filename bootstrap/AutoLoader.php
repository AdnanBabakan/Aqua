<?php
// Model autoloader
spl_autoload_register(function($className) {
    $path = explode('\\', $className);
    $path = __ROOT__ . '/model/' . end($path) . '.php';
    require_once $path;
});