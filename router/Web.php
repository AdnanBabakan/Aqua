<?php

$router->get('/{name}', function($name) {
    echo 'Welcome to Aqua! ' . $name;
});