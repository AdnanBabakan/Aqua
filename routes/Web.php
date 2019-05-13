<?php
use \Aqua\Router as Router;

Router::route('/', 'Index@HomeController');
Router::route('/Cache', 'Cache@HomeController');