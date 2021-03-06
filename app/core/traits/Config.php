<?php
/**
 * @namespace Aqua\Trait
 * @trait Config
 * @version 0.1
 * This file will handle the options in the aqua_config.ini file and will make it globally available through the life-cycle
 */

namespace Aqua\Traits;

trait Config
{

    public static $config;

    /**
     * @return object
     */
    public static function config() : object
    {
        return json_decode(json_encode(parse_ini_file(__ROOT__ . '/AquaConfig.ini', true)));
    }

    public static function aqua_data() : object
    {
        return json_decode(json_encode([
            "version" => "Core 0.4-alpha"
        ]));
    }
}