<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;

Router::route('/', 'Index@HomeController');

Router::route('/db', function() {

    GLOBAL $shark;

    $shark->insert(["username" => "Hello there"])->table('users')->insert(["title" => "Hello there dude!"])->table('posts');
});