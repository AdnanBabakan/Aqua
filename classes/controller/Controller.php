<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * Every controller should extend this class in order to be valid as a controller class
 */

namespace Aqua;

require_once 'traits/Params.php';

class Controller extends Authenticator
{

    use Params;

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

}