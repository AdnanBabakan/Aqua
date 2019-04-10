<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant
define('__PATH__', '/' . (isset($_GET['path'])?$_GET['path']:''));

require_once 'Aqua.php';

require_once __ROOT__ . '/core/router/Router.php';

require_once __ROOT__ . '/core/Misc.php';

require_once __ROOT__ . '/router/Web.php';

// Initiate Router
\Aqua\Router::run();