<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;

Router::route('/', 'Index@HomeController');
Router::route('/debug', function() {
    Core::var_dump(Core::config());
});