<?php
use \Aqua\Router as Router;

Router::route('/', 'Index@HomeController');
// Router::route('/clear_cache', function() {
//     \Aqua\Cache::clear_cache();
// });