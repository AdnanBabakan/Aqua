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

    public function SetKey()
    {
        $this->auth_set_data('id', '22');
    }

    public function UnsetKey()
    {
        $this->auth_unset_data('id');
    }

    public function Show()
    {
        echo $this->auth_get_data('id');
        debug($_SESSION);
    }
}