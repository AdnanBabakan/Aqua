<?php
use \Aqua\Router as Router;
use \Aqua\Core as Core;
use \Aqua\Shark as Shark;

Router::route('/', 'Index@HomeController');

Router::route('/db', function() {
    Core::var_dump(\Aqua\Shark()->select()->table('users'));
});