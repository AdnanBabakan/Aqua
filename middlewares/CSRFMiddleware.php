<?php

namespace Aqua;

class CSRFMiddleware extends Middleware implements MiddlewareInterface
{
    public function handle()
    {
        if($this->POST('csrf_token')==$_SESSION['csrf_token']) {
            return true;
        } else {
            return false;
        }
    }

    public function methods(): array
    {
        return ["POST", "PUT", "DELETE"];
    }

    public function on_error()
    {
        echo 'CSRF not authorized!';
    }
}