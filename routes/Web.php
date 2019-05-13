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

    // $q = $shark->where([
    //     ['username', 'adnan'],
    //     ['age', '>', 4]
    // ])->table('users');

    // $q = $shark->where('username', 'hasan')->table('users');
    // $q = $shark->where('username', '>', 'hasan')->table('users');
    // $q = $shark->where(['username', 'hasan'], ['test', 'test'])->table('users');
    // $q = $shark->where([['username', 'hasan']])->table('users');
    // $q = $shark->where([
    //     ['username', 'hasan'],
    //     ['age', '>', 5]
    // ])->table('users');
    $q = $shark->where(['username', 'hasan'], ['age', '>', 5])->table('users');

    // $q = $shark->select("username", "id")
    //     ->table('users');

    Core::var_dump($q);

});