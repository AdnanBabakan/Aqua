<?php

namespace HomeController;

use Aqua\Controller;
use Aqua\Pearl;

class HomeController extends Controller
{
    public function Index()
    {
        $q = Shark()->select()->table('users');
        debug($q);
        return Pearl::render('index', ["title" => "Aqua", "message" => "Welcome to Aqua!", "desc" => "Hola", "test" => "1234", "user" => "Adnan"]);
    }

    public function Test()
    {
        return 'Hello';
    }
}