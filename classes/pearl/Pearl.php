<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that will help you work with Pearl tampleates
 */

namespace Aqua;

class Pearl
{
    public static function render(string $t, array $p = [])
    {

        $cache = new Cache($t, $p);
        
        if($cache->cache_exists() && Core::config()->general->cache) {
            
            $file = $cache->get_cache();

        } else {
            
            extract($p);

            ob_start();
            require(__ROOT__ . '/views/' . $t . '.php');
            $file = ob_get_contents();
            ob_end_clean();

            if(preg_match_all('/\[\[(.*?)\]\]/', $file, $match)) {
                $match_number = count($match);
                for($i=0; $i<$match_number; $i++) {
                    if(isset($match[1][$i]) && array_key_exists($match[1][$i], $p)) {
                        $file = str_replace($match[0][$i], $p[$match[1][$i]], $file);   
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