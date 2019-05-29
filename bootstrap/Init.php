<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/
session_start();

define('AQUA_BEGIN_TIME', microtime(true));

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant
define('__PATH__', '/' . (isset($_GET['path'])?$_GET['path'] . (substr($_GET['path'], -1)=='/'?'':'/'):''));

require_once  __ROOT__ . '/app/errors/ErrorHandler.php';

// Register Error Handlers
set_error_handler("\Aqua\ErrorHandler::error_handler");
register_shutdown_function('\Aqua\ErrorHandler::fatal_error_handler');

// Composer loader if exists
!file_exists(__ROOT__ . '/vendor') or require_once __ROOT__ . '/vendor/autoload.php';

require_once __ROOT__ . '/app/core/Core.php';

require_once __ROOT__ . '/app/core/Misc.php';

require_once __ROOT__ . '/app/i18n/I18N.php';

require_once __ROOT__ . '/app/exception/AquaException.php';

require_once __ROOT__ . '/app/shark/Shark.php';

require_once __ROOT__ . '/app/authenticator/Authenticator.php';

require_once __ROOT__ . '/app/csrf/CSRF.php';

// Initiate CSRF protection
$CSRF = new \Aqua\CSRF;

require_once __ROOT__ . '/app/pearl/Pearl.php';

require_once __ROOT__ . '/app/cache/Cache.php';

require_once __ROOT__ . '/bootstrap/Global.php';

require_once __ROOT__ . '/bootstrap/AutoLoader.php';

require_once __ROOT__ . '/app/controller/Controller.php';

require_once __ROOT__ . '/app/middleware/Middleware.php';

require_once __ROOT__ . '/app/middleware/MiddlewareInterface.php';

require_once __ROOT__ . '/app/router/Router.php';

require_once __ROOT__ . '/config/Config.php';

require_once __ROOT__ . '/routes/Web.php';

require_once __ROOT__ . '/app/developer/Developer.php';

//Initiate Shark
Shark();

// Initiate Router
\Aqua\Router::run();

define('AQUA_END_TIME', microtime(true));

// Initiate Developer tools
if(isset(\Aqua\Core::config()->general->dev_tools) and \Aqua\Core::config()->general->dev_tools) {
    \Aqua\Developer::init();
}