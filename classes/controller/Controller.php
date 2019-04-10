<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * Every controller should extend this class in order to be valid as a controller class
 * @Source https://github.com/bramus/router
 */

namespace Aqua;

class Controller
{
    
    public $content_type = 'text/html';

    public function content_type($type)
    {
        $this->content_type = $type;
    }

}