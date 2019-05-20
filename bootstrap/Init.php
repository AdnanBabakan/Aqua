<?php
/**
 * This file will gather all what is needed for you application
 * Editing this file is not suggested as it may cause instability issues or even break your app down
*/
session_start();

define('__ROOT__', str_replace('\\', '/',  realpath(__DIR__ . '/..'))); // Access Aqua root folder with this constant
define('__PATH__', '/' . (isset($_GET['path'])?$_GET['path'] . (substr($_GET['path'], -1)=='/'?'':'/'):''));

require_once  __ROOT__ . '/classes/errors/ErrorHandler.php';

// Register Error Handlers
set_error_handler("\Aqua\ErrorHandler::error_handler");
register_shutdown_function('\Aqua\ErrorHandler::fatal_error_handler');

// Composer loader if exists
!file_exists(__ROOT__ . '/vendor') or require_once __ROOT__ . '/vendor/autoload.php';

require_once __ROOT__ . '/classes/core/Core.php';

require_once __ROOT__ . '/classes/core/Misc.php';

require_once __ROOT__ . '/classes/i18n/I18N.php';

require_once __ROOT__ . '/classes/exceptions/AquaException.php';

require_once __ROOT__ . '/classes/shark/Shark.php';

require_once __ROOT__ . './classes/http/HTTP.php';

require_once __ROOT__ . './classes/http/Input.php';

require_once __ROOT__ . '/classes/authenticator/Authenticator.php';

require_once __ROOT__ . '/classes/pearl/Pearl.php';

require_once __ROOT__ . '/classes/cache/Cache.php';

require_once __ROOT__ . '/bootstrap/Global.php';

require_once __ROOT__ . '/bootstrap/AutoLoader.php';

require_once __ROOT__ . '/config/Config.php';

require_once __ROOT__ . '/classes/controller/Controller.php';

require_once __ROOT__ . '/classes/router/Router.php';

require_once __ROOT__ . '/routes/Web.php';

// Initiate Router
\Aqua\Router::run();