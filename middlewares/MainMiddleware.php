<?php

namespace Aqua;

class MainMiddleware extends Middleware implements MiddlewareInterface
{
    public function handle()
    {
        echo 'Hi';
        return true;
    }

    public function methods(): array
    {
        return ["GET"];
    }

    public function on_error()
    {
        // TODO: Implement on_error() method.
    }
}