<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/
session_start();

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant
define('__PATH__', '/' . (isset($_GET['path'])?$_GET['path'] . (substr($_GET['path'], -1)=='/'?'':'/'):''));


require_once __ROOT__ . '/classes/core/Core.php';

require_once __ROOT__ . '/classes/core/Misc.php';

require_once __ROOT__ . '/classes/i18n/I18N.php';

require_once __ROOT__ . '/classes/exceptions/Exceptions.php';

require_once __ROOT__ . '/classes/shark/Shark.php';

require_once __ROOT__ . './classes/http/HTTP.php';

require_once __ROOT__ . '/classes/authenticator/Authenticator.php';

require_once __ROOT__ . '/classes/pearl/Pearl.php';

require_once __ROOT__ . '/classes/cache/Cache.php';

require_once __ROOT__ . '/bootstrap/Global.php';

require_once __ROOT__ . '/bootstrap/AutoLoader.php';

require_once __ROOT__ . '/config/Config.php';

require_once __ROOT__ . '/classes/controller/Controller.php';

require_once __ROOT__ . '/classes/router/Router.php';

foreach(\Aqua\Misc::rsearch(__ROOT__ . '/controllers', '/(.*?)\.php/') as $controllerFile) {
    require_once $controllerFile;
}

require_once __ROOT__ . '/routes/Web.php';

// Initiate Router
\Aqua\Router::run();