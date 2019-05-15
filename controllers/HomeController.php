<?php

namespace HomeController;

use \Aqua\Controller;
use \Aqua\Core;

class HomeController extends Controller
{
    public function Index()
    {
        $h = new \Aqua\Model\Users();
        debug($h->add_user('alo', 'alozadeh'));
    }
}