<?php

namespace HomeController;

use \Aqua\Pearl as Pearl;
use \Aqua\Cache as Cache;

class HomeController extends \Aqua\Controller
{
    public function Index()
    {
        return Pearl::render('index', ["title" => "Aqua", "message" => "Hello"]);
    }
}