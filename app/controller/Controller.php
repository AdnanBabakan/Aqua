<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * Every controller should extend this class in order to be valid as a controller class
 */

namespace Aqua;

require_once 'traits/Params.php';
require_once 'traits/Headers.php';

class Controller extends Authenticator
{

    use Params;
    use Headers;

    public $content_type = 'text/html';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $type
     */

    public function content_type($type) : void
    {
        $this->content_type = $type;
    }

    public function __get($name)
    {
        if(preg_match('/^(get|post)_(.*)/i', $name, $matches)) {
            return $this->params($matches[2], $matches[1]);
        }
    }

}