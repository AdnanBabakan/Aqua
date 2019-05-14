<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that will help you work with Pearl tampleates
 */

namespace Aqua;

class Pearl
{
    public static function render(string $template, array $parameters = []) : string
    {

        $cache = new Cache($template, $parameters);
        
        if($cache->cache_exists() && Core::config()->general->cache) {
            
            $file = $cache->get_cache();

        } else {
            
            extract($parameters);

            ob_start();
            require(__ROOT__ . '/views/' . $template . '.php');
            $file = ob_get_contents();
            ob_end_clean();

            if(preg_match_all('/\[\[(.*?)\]\]/', $file, $match)) {
                $match_number = count($match);
                for($i=0; $i<$match_number; $i++) {
                    if(isset($match[1][$i]) && array_key_exists($match[1][$i], $parameters)) {
                        $file = str_replace($match[0][$i], $parameters[$match[1][$i]], $file);   
                    }
                }
            }

            if(Core::config()->general->cache) {
                $cache->save_cache($file);
            }

        }

        return $file;
    }
}