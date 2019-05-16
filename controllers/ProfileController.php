<?php

namespace ProfileController;

    use \Aqua\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth_login_needed();
    }

    public function Profile()
    {
        return 'This is your profile';
    }
}