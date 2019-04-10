<?php

namespace HomeController;

use \Aqua\Pearl as Pearl;

class HomeController extends \Aqua\Controller
{
    public function Index()
    {
        return Pearl::render('index', ["title" => "Aqua", "message" => "Welcome to Aqua framework!"]);
    }
}