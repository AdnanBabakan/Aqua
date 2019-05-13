<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that will help your application speed up using cache
 */

namespace Aqua;

class Cache
{
    public $file_name;
    public $file_address;

    public function __construct(string $n = '', array $a = [])
    {
        $this->file_name = md5(json_encode($a) . $n);
        $this->file_address = __ROOT__ . '/cache/' . $this->file_name;
    }

    public function save_cache(string $c = '')
    {
        file_put_contents($this->file_address, $c);
    }

    public function cache_exists()
    {
        return file_exists($this->file_address);
    }

    public function get_cache()
    {
        return file_get_contents($this->file_address);
    }

    public static function clear_cache()
    {
        $cache_folder_name = __ROOT__ . '/cache';
        $cache_folder = scandir($cache_folder_name);
        foreach ($cache_folder as $file) {
            if ($file != '.' and $file != '..') {
                unlink($cache_folder_name . '/' . $file);
            }
        }
    }
}