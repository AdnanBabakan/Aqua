<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * @author Payam Yasaie
 * This file is the main class that will help your application speed up using cache
 */

namespace Aqua;

class Cache
{
    public $file_name;
    public $file_address;
    public $cache_folder_name = __ROOT__ . '/cache';

    /**
     * Cache constructor.
     * @param string $template
     * @param array $parameters
     */
    public function __construct(string $template = '', array $parameters = [])
    {
        $this->file_name = md5($template . json_encode($parameters));
        $this->file_address = __ROOT__ . '/cache/' . $this->file_name;
    }

    /**
     * @param string $content
     */
    public function save_cache(string $content = '') : void
    {
        file_exists(__ROOT__ . '/cache') or mkdir(__ROOT__ . '/cache');
        file_put_contents($this->file_address, $content);
    }

    public function get_cache_id() : string
    {
        return $this->file_name;
    }

    /**
     * @return bool
     */
    public function cache_exists() : bool
    {
        return file_exists($this->file_address);
    }

    /**
     * @return string
     */
    public function get_cache() : string
    {
        return file_get_contents($this->file_address);
    }

    public function clear_cache() : void
    {
        $cache_folder = scandir($this->cache_folder_name);
        foreach ($cache_folder as $file) {
            if ($file != '.' and $file != '..') {
                unlink($this->cache_folder_name . '/' . $file);
            }
        }
    }
}
