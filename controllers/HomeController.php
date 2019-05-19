<?php

namespace HomeController;

use Aqua\Controller;
use Aqua\Pearl;

class HomeController extends Controller
{
    public function Index()
    {
        // $this->auth_login_needed();
        return Pearl::render('index', ["title"=>"Aqua", "message"=>"Welcome to Aqua!", "desc"=>"Hola", "test"=>"1234", "user"=>"Adnan"]);
    }

    public function Test()
    {
        $this->auth_user('', '');
        return 'Hello';
    }
}