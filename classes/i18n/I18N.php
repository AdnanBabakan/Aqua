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

    public function translate(string $string, string $folder = '')
    {
        $translate = $string;

        $lang_source_file = __ROOT__ . $this->default_directory . ($folder!=''?'/' . $folder:'') . '/' . $this->default_lang . '.php';
        if(file_exists($lang_source_file)) {
            $lang_array = require_once $lang_source_file;
            $translate = isset($lang_array[$string])?$lang_array[$string]:$string;
        }

        return $translate;
    }
}