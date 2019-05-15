<?php

namespace Aqua\Model;

use \Aqua\Shark;

class Users extends Shark {
    
    public function get_users()
    {
        return $this->select()->run();
    }

    public function add_user($username, $password)
    {
        $insert = $this->insert(compact("username", "password"))->run()->get();

        return $insert;
    }

}