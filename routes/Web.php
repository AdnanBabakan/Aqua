<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;
use \Aqua\Shark as Shark;
use \Aqua\SharkCallback as SharkCallback;

// Home
Router::route('/', 'Index@HomeController');
Router::route('[POST]/hello', function() {
    return 'Hi';
});

Router::map('404', 'e404@ErrorController');