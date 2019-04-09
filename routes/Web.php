<?php
use \Aqua\Router as Router;

Router::route('/movie/{name}/{year}', function($n, $y) {
    return 'You are searching for the movie called ' . $n . ' which is release in year ' . $y;
});