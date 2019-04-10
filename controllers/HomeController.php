<?php

namespace HomeController;

class HomeController extends \Aqua\Controller
{

    public function __construct()
    {
        $this->content_type('text/plain');
    }

    public function Index()
    {
        return 'Hello Aqua!';
    }

    public function User()
    {
        return 'Users Page!';
    }
}