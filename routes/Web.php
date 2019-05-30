<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;
use \Aqua\Shark as Shark;
use \Aqua\SharkCallback as SharkCallback;

// Home
Router::route('[POST]/', 'Index@HomeController');
Router::route('[POST]/test_csrf', 'TestCSRF@HomeController');

//Router::route('/u/{name}/{date}', function($n, $d) {
//    return 'Hello ' . (isset($n)?$n:'None');
//})->rules([
//    "name" => "[A-Za-z]+",
//    "date" => "[0-9]+"
//])->name('user-profile');
//
//Router::route('[POST]/test', function() {
//    Router::use_ally('user-profile', ["date"=>"1379", "name"=>"adnan"]);
//});
//
//Router::route_to_ally('/t', 'user-profile', ["date"=>"1379", "name"=>"adnan"]);
//
//Router::route('/csrf_key', function() {
//    return \Aqua\CSRF::csrf_token_input();
//});