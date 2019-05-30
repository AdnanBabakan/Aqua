<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * By implementing this interface you can create your own middleware and register it in the config
 */

namespace Aqua;

interface MiddlewareInterface
{
    public function handle();

    public function methods(): array;

    public function on_error();
}