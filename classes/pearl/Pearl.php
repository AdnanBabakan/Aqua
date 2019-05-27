<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that will help you work with Pearl templates
 */

namespace Aqua;

class Pearl
{
    protected static $default_parameters = [];
    protected static $cache_id;

    /**
     * @param array ...$parameters
     */
    public static function add_default_parameter(array ...$parameters) : void
    {
        self::$default_parameters = array_merge(self::$default_parameters, ...$parameters);
    }

    /**
     * @return array
     */
    public static function get_default_parameters() : array
    {
        return self::$default_parameters;
    }

    public static function get_cache_id()
    {
        return isset(self::$cache_id)?self::$cache_id:Null;
    }

    /**
     * @param string|null $string
     * @return string
     */
    public static function render_layout(?string $string) : string
    {
        $raw_content = preg_replace('/\[@layout (.*?)\]/', '', $string);
        if(preg_match_all('/\[@(.*?)\]/', $string, $match)) {
            for($i=0; $i<count($match[0]); $i++) {
                $full_command = $match[0][$i];
                $command_array = explode(' ', $match[1][$i]);
                switch($command_array[0]) {
                    case 'layout':
                        ob_start();
                        require_once __ROOT__ . '/views/' . $command_array[1] . '.php';
                        $layout = ob_get_clean();
                        $string = self::render_layout(str_replace('[@yield]', $raw_content, $layout));
                        break;
                    case 'include':
                        ob_start();
                        require __ROOT__ . '/views/' . $command_array[1] . '.php';
                        $component = ob_get_clean();
                        $string = self::render_layout(str_replace($full_command, $component, $string));
                        break;
                    }
                }
            }
        return $string;
    }

    /**
     * @param string $template
     * @param array $parameters
     * @param bool $is_string
     * @return string
     */
    public static function render(string $template, array $parameters = [], bool $is_string = false) : string
    {
        $parameters = array_merge($parameters, self::$default_parameters);

        $cached = false;

        if(Core::config()->general->cache) {
            $cache = new Cache($template, $parameters);
            self::$cache_id = $cache->get_cache_id();
            if($cache->cache_exists()) {
                $cached = true;
                $file = $cache->get_cache();
            }
        }

        if(!$cached) {
            extract($parameters);

            if($is_string) {
                $file = $template;
            } else {
                ob_start();
                require(__ROOT__ . '/views/' . $template . '.php');
                $file = ob_get_contents();
                ob_end_clean();
            }

            $file = self::render_layout($file);

            if(preg_match_all('/\[\[(.*?)\]\]/', $file, $match)) {
                for($i=0; $i<count($match[0]); $i++) {
                    if(isset($match[1][$i]) && array_key_exists($match[1][$i], $parameters)) {
                        $file = str_replace($match[0][$i], $parameters[$match[1][$i]], $file);
                    }
                }
            }

            if(isset($layout)) {
                $file = str_replace('[@yield]', $file, $layout);
            }

            $file = preg_replace('/\[@(.*?)\]/', '', $file);

            if(Core::config()->general->cache) {
                $cache = new Cache($template, $parameters);
                self::$cache_id = $cache->get_cache_id();
                $cache->save_cache($file);
            }
        }

        return $file;
    }
}