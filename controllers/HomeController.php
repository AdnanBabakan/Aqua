<?php

namespace HomeController;

use \Aqua\Pearl as Pearl;
use \Aqua\Cache as Cache;

class HomeController extends \Aqua\Controller
{
    public function Index()
    {
        return Pearl::render('index', ["title" => "Aqua", "message" => "Adnan Welcome to Aqua framework!1242154235"]);
    }

    public function Cache()
    {
        Cache::clear_cache();
        return 'Cache cleared';
    }
}