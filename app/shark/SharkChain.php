<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * This file will add more features to Shark and methods here can be called after table() method in a Shark instance
 */

namespace Aqua;

class SharkChain extends Shark
{
    /**
     * @return int
     */
    public function inserted_id()
    {
        return (int) self::$db_conn_static->lastInsertId();
    }

    /**
     * @return __anonymous|array|bool|mixed|\PDOStatement
     */
    public function get()
    {
        $id = (int) self::$db_conn_static->lastInsertId();
        $self = new self;
        return $self->first()->where('id', $id)->table('users');
    }
}