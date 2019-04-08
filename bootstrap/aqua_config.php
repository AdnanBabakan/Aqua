<?php
/**
 * @namespace: Aqua
 * @class: Config
 * @version: 0.1
 * This file will handle the options in the aqua_config.ini file and will make it globally available through the life-cycle
 */
namespace Aqua;
class Config
{
    public static function get()
    {
        return json_decode(json_encode(parse_ini_file(__ROOT__ . '/aqua_config.ini', true)));
    }
}