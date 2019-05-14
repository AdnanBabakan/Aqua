<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file will add more features to Shark and methods here can be called after table() method in a Shark instance
 */

namespace Aqua;

class SharkChain extends Shark
{
    public function last_insert_id()
    {
        return self::$db_conn_static->lastInsertId();
    }
}