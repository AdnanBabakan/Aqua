<?php

//I18N
function __(string $string, string $folder = '')
{
    $i18n = new \Aqua\I18N;
    return $i18n->translate($string, $folder);
}

// Shark
function Shark()
{
    return new \Aqua\Shark;
}

// Colored var_dum
function debug(...$a)
{
    return \Aqua\Core::var_dump(...$a);
}