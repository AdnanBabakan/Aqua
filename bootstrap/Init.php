<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant

require_once 'Aqua.php';

require_once __ROOT__ . '/core/router/Router.php';

require_once __ROOT__ . '/core/Misc.php';

// Initiate Router
$router = new \Aqua\Router();

// Load Controllers

foreach(\Aqua\Misc::rsearch(__ROOT__ . '/controller', '/(.*?)\.php/') as $controllerFile) {
    require_once $controllerFile;
}

// Run Router
$router->run();