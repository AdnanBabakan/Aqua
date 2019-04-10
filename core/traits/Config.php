<?php
/**
 * @namespace AquaTrait
 * @trait Config
 * @version 0.1
 * This file will handle the options in the aqua_config.ini file and will make it globally available through the life-cycle
 */

namespace AquaTrait;

trait Config
{

    public static $config;

    public static function Config() : object
    {
        return json_decode(json_encode(parse_ini_file(__ROOT__ . '/AquaConfig.ini', true)));
    }
}