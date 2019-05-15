<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;
use \Aqua\Shark as Shark;
use \Aqua\SharkCallback as SharkCallback;

Router::route('/', 'Index@HomeController');

Router::route('/db', function() {

    $q = Shark()->inserted_id();

    Core::var_dump($q);

});