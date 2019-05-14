<?php

namespace HomeController;

use \Aqua\Controller;
use \Aqua\Core;
use Aqua\Pearl;

class HomeController extends Controller
{
    public function Index()
    {
        return Pearl::render('index', ["title"=>"Aqua", "message"=>"Welcome to Aqua!", "desc"=>"Hola", "test"=>"1234", "user"=>"Adnan"]);
    }
}