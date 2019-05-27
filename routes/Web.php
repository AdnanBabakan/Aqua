<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;
use \Aqua\Shark as Shark;
use \Aqua\SharkCallback as SharkCallback;

// Home
Router::route('/', 'Index@HomeController');

Router::route('/u/{name}/{date}', function($n, $d) {
    return 'Hello ' . (isset($n)?$n:'None');
})->rules([
    "name" => "[A-Za-z]+",
    "date" => "[0-9]+"
]);