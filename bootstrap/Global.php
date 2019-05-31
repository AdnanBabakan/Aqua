<?php

// I18N
function __(string $key, string $folder = '', ...$params)
{
    $i18n = new \Aqua\I18N;
    return $i18n->translate($key, $folder, ...$params);
}

// Shark
function Shark()
{
    return new \Aqua\Shark;
}

// Colored var_dum
function debug(...$object)
{
    return \Aqua\Core::var_dump(...$object);
}