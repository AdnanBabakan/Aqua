<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;

Router::route('/', 'Index@HomeController');
Router::route('/debug', function() {
    Core::var_dump(["name" => "Adnan", "age" => 19]);
});

Router::route('/test', function() {
    
    GLOBAL $shark;

    $username = "yasaie";
    $password = "762174";

    $shark->insert('users', compact("username", "password"))->insert('users', ["username"=>"adnan", "password"=>"1111"]);

});