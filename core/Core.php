<?php
/**
 * @namespace Aqua
 * @class Core
 * @version 0.1
 * This file is used to gather all the necessary stuff in a class
 */
namespace Aqua;

include 'traits/Config.php';
include 'traits/Debug.php';

class Core
{
    use \Aqua\Traits\Config;
    use \Aqua\Traits\Debug;
}