<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
 */

namespace Aqua;

class Misc
{
    /**
     * @param $folder
     * @param $pattern
     * @return array
     */
    public static function rsearch($folder, $pattern) : array
    {
        $dir = new \RecursiveDirectoryIterator($folder);
        $ite = new \RecursiveIteratorIterator($dir);
        $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
        $fileList = array();
        foreach($files as $file) {
            $fileList = array_merge($fileList, $file);
        }
        $fileList = array_map(function($v) {
            return realpath(str_replace('\\', '/', $v));
        }, $fileList);
        foreach($fileList as $k => $v) {
            if(gettype($v)!='string') {
                unset($fileList[$k]);
            }
        }
        return $fileList;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generate_random_string($length = 10) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}