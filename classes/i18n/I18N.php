<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This class will provide you i18n features
 */

namespace Aqua;

class I18N
{
    protected $default_lang;
    protected $default_directory;

    public function __construct()
    {
        $this->default_lang = isset(Core::config()->locale->default_lang)?Core::config()->locale->default_lang:'en';
        $this->default_directory = isset(Core::config()->locale->default_directory)?Core::config()->locale->default_directory:'/locale';
    }

    public function translate(string $key, string $folder = '', ...$params)
    {
        $translate = $key;

        $lang_source_file = __ROOT__ . $this->default_directory . ($folder!=''?'/' . $folder:'') . '/' . $this->default_lang . '.php';
        if(file_exists($lang_source_file)) {
            $lang_array = require_once $lang_source_file;
            $translate = isset($lang_array[$key])?$lang_array[$key]:$key;
            if(is_array($params)) {
                $translate = preg_replace_callback('/%([0-9]+)/', function($m) use ($params) {
                    return isset($params[$m[1]])?$params[$m[1]]:'';
                }, $translate);
            }
        }

        return $translate;
    }
}