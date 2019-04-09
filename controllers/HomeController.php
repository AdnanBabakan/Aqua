<?php

namespace HomeController;

class HomeController
{
    public function Index($n, $y)
    {
        return 'Movie: ' . $n . ' Year: ' . $y;
    }
}