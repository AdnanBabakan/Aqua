<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * Authenticator will provide you the tools needed to make login systems
 */

namespace Aqua;

use AquaException;

class Authenticator
{
    protected $storage_type;
    protected $storage_encryption_method;
    protected $storage_secret_key;
    protected $storage_secret_iv;
    protected $auth_tag;
    protected $login_page;
    protected $users_table;
    protected $user_username_column;
    protected $user_password_column;

    public function __construct()
    {
        $storage_type = Core::config()->auth->storage_type;
        if(!($storage_type == 'session' or $storage_type == 'cookie')) {
            $this->storage_type = 'session';
        } else {
            $this->storage_type = $storage_type;
        }
        $hash_algorithm = isset(Core::config()->auth->hash_algorithm)?Core::config()->auth->hash_algorithm:'sha256';
        $this->storage_encryption_method = isset(Core::config()->auth->storage_encryption_method)?Core::config()->auth->storage_encryption_method:'aes-128-gcm';
        $this->storage_secret_key = isset(Core::config()->auth->storage_secret_key)?Core::config()->auth->storage_secret_key:'AQUA_KEY';
        $this->storage_secret_key = hash($hash_algorithm, $this->storage_secret_key);
        $this->storage_secret_iv = isset(Core::config()->auth->storage_secret_iv)?Core::config()->auth->storage_secret_iv:'AQUA_IV';
        $this->storage_secret_iv = substr(hash($hash_algorithm, $this->storage_secret_iv), 0, 16);
        $this->login_page = isset(Core::config()->auth->login_page)?Core::config()->auth->login_page:'/login';
    }

    public function auth_set_data(string $data_key, $data_value) : void
    {
        if(Core::config()->auth->use_encoding) $data_value = openssl_encrypt($data_value, $this->storage_encryption_method, $this->storage_secret_key, 0, $this->storage_secret_iv, $this->auth_tag);
        switch($this->storage_type)
        {
            case 'session':
                $_SESSION[$data_key] = $data_value;
                break;
            case 'cookie':
                setcookie($data_key, $data_value, time() + Core::config()->auth->cookie_expire, isset(Core::config()->auth->cookie_domain)?Core::config()->auth->cookie_domain:'/');
                break;
        }
    }

    public function auth_get_data(string $data_key) : string
    {
        switch($this->storage_type)
        {
            case 'session':
                $data_value = isset($_SESSION[$data_key])?$_SESSION[$data_key]:'UNDEFINED';
                break;
            case 'cookie':
                $data_value = isset($_COOKIE[$data_key])?$_COOKIE[$data_key]:'UNDEFINED';
                break;
        }

        if(Core::config()->auth->use_encoding) $data_value = openssl_decrypt($data_value, $this->storage_encryption_method, $this->storage_secret_key, 0, $this->storage_secret_iv, $this->auth_tag);

        if(isset($data_value)) {
            return $data_value;
        } else {
            return '';
        }
    }

    public function auth_unset_data(string $data_key) : void
    {
        switch($this->storage_type)
        {
            case 'session':
                unset($_SESSION[$data_key]);
                break;
            case 'cookie':
                setcookie($data_key, '', time() - 200, isset(Core::config()->auth->cookie_domain)?Core::config()->auth->cookie_domain:'/');
                break;
        }
    }

    public function auth_log_in() : void
    {
        $this->auth_set_data('auth_logged_in', true);
    }

    public function auth_user(string $username, string $password)
    {
        if(isset(Core::config()->auth->users_table) and isset(Core::config()->auth->user_username_column) and isset(Core::config()->auth->user_password_column)) {
            $count = count(Shark()->select()->where([
                [Core::config()->auth->user_username_column, $username],
                [Core::config()->auth->user_password_column, $password]
            ])->table(Core::config()->auth->users_table));
            return $count>0?true:false;
        } else {
            try {
                throw new \AquaException(__('No config provided for authenticator.', 'core'), -1);
            } catch(\AquaException $e) {
                echo $e;
            }
        }
    }

    public function auth_user_and_log_in(string $username, string $password)
    {
        if($this->auth_user($username, $password)) {
            $this->auth_log_in();
            return true;
        } else {
            return false;
        }
    }

    public function auth_sign_out() : void
    {
        $this->auth_unset_data('auth_logged_in');
    }

    public function auth_is_logged_in() : bool
    {
        $bool = false;
        switch($this->storage_type)
        {
            case 'session':
                $bool = isset($_SESSION['auth_logged_in']);
                break;
            case 'cookie':
                $bool = isset($_COOKIE['auth_logged_in']);
                break;
        }

        return $bool;
    }

    public function auth_login_needed()
    {
        if(!$this->auth_is_logged_in()) {
            HTTP::redirect($this->login_page);
        }
    }
}