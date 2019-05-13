<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;

Router::route('/', 'Index@HomeController');
Router::route('/debug', function() {
    Core::var_dump(["name" => "Adnan", "age" => 19]);
});

Router::route('/test', function() {
    
    GLOBAL $shark;

    $username = "Hasan";
    $password = "762174";

    $q = $shark->first("id", "password")->table('users');

    Core::var_dump($q);

});