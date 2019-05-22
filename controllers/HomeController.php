<?php

namespace HomeController;

use Aqua\Controller;
use Aqua\Pearl;

class HomeController extends Controller
{
    public function Index()
    {
        $q = Shark()->select()->where(["id" => "1", "username" => "alo"])->table('users');
        var_dump($q);
        return Pearl::render('index', ["title" => "Aqua", "message" => "Welcome to Aqua!", "desc" => "Hola", "test" => "1234", "user" => "Adnan"]);
    }

    public function Test()
    {
        $this->auth_user('', '');
        return 'Hello';
    }
}