<?php

namespace ErrorController;

use Aqua\Controller;

class ErrorController extends Controller
{
    public function e404()
    {
        return 'And you are lost!';
    }
}