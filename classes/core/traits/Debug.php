<?php
/**
 * @namespace Aqua\Trait
 * @trait Debug
 * @version 0.1
 * This file will provide tools for debugging
 */

namespace Aqua\Traits;

trait Debug
{

    public static function pre_var_dump($o = []) : void
    {
        echo '<pre>';
        print_r($o);
        echo '</pre>';
    }
}