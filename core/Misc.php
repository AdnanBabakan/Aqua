<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file is the main class that handles routes acrros the appliaction
 * @source https://github.com/bramus/router
 */

namespace Aqua;

class Misc
{
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
}