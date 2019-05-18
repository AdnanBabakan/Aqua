<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file includes exceptions
 */

namespace Aqua;

use \Throwable;

class AquaException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        parent::__toString();
        $generated_message = "<b>" . __CLASS__ . "</b> [{$this->code}] {$this->message} - File: '{$this->file}' - Line: {$this->line}";
        if($this->code < 0) {
            die($generated_message);
        } else {
            return $generated_message;
        }
    }
};