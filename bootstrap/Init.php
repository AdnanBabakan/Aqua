<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant
define('__PATH__', '/' . (isset($_GET['path'])?$_GET['path'] . (substr($_GET['path'], -1)=='/'?'':'/'):''));


require_once __ROOT__ . '/core/Core.php';

require_once __ROOT__ . '/core/Misc.php';

require_once __ROOT__ . '/classes/router/Router.php';

require_once __ROOT__ . '/routes/Web.php';

// Initiate Router
\Aqua\Router::run();