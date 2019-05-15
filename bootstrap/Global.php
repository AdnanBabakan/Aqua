<?php

function Shark()
{
    return new \Aqua\Shark();
}

function debug(...$a)
{
    return \Aqua\Core::var_dump(...$a);
}