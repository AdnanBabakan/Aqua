<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This trait will help to handle the params which are sent by forms
 */

namespace Aqua;

trait Params
{
    public function params(string $name = Null, $type = Null)
    {
        if(!$type) {
            $params = array_merge($_GET, $_POST);
        } else if($type == 'GET') {
            $params = $_GET;
        } else if($type == 'POST') {
            $params = $_POST;
        }
        if($name) {
            return htmlspecialchars(isset($params[$name])?$params[$name]:'NaN');
        } else {
            return array_map('htmlspecialchars', $params);
        }
    }

    public function POST(string $name = Null)
    {
        return $this->params($name, 'POST');
    }

    public function GET(string $name = Null)
    {
        return $this->params($name, 'GET');
    }
}