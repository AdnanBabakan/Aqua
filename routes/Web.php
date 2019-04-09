<?php
use \Aqua\Router as Router;

Router::route('/movie/{name}/detail/{year}', 'Index@HomeController');