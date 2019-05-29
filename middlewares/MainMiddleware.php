<?php

namespace Aqua;

class MainMiddleware extends Middleware implements MiddlewareInterface
{
    public function handle()
    {
        echo 'Hi';
    }

    public function methods(): array
    {
        return ["POST"];
    }
}