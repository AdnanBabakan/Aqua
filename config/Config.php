<?php
/**
 * This file is loaded after your models but before your controllers and routers so
 * any config needed can be added here in order to overwrite default behaviour of app and libraries
 */

// Default params for Pearl
\Aqua\Pearl::add_default_parameter(["app_title"=>"Aqua"]);

// Register Global Middleware
\Aqua\Router::register_global_middleware('Aqua\MainMiddleware');