<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file includes exception
 */

namespace Aqua;

use \Throwable;
use \Exception;

class AquaException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        parent::__toString();
        $generated_message = "<b>" . __CLASS__ . "</b> {$this->message}: - File: '{$this->file}' - Line: {$this->line}";
        ErrorHandler::error_handler($this->code, $generated_message, $this->file, $this->line);
    }
};