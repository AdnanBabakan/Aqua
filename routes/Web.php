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

    $q = $shark->where(['username', 'Hasan'])
        ->and_where('id', '>', '30')
        ->or_where('username', 'mohammad')
        ->select()
        ->table('users');


    Core::var_dump($q);

});