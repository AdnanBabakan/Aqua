<?php
/**
 * @namespace: Aqua
 * @version 0.1
 * Authenticator will provide you the tools needed to make login systems
 */

namespace Aqua;

class Authenticator
{
    protected $storage_type;
    protected $storage_encryption_method;
    protected $storage_secret_key;
    protected $storage_secret_iv;

    public function __construct()
    {
        $storage_type = Core::config()->auth->storage_type;
        if(!($storage_type == 'session' or $storage_type == 'cookie')){
            $this->storage_type = 'session';
        } else {
            $this->storage_type = $storage_type;
        }
        $hash_algorithm = isset(Core::config()->auth->hash_algorithm)?Core::config()->auth->hash_algorithm:'sha256';
        $this->storage_encryption_method = isset(Core::config()->auth->storage_encryption_method)?Core::config()->auth->storage_encryption_method:'aes-128-gcm';
        $this->storage_secret_key = isset(Core::config()->auth->storage_secret_key)?Core::config()->auth->storage_secret_key:'';
        $this->storage_secret_key = hash($hash_algorithm, $this->storage_secret_key);
        $this->storage_secret_iv = isset(Core::config()->auth->storage_secret_iv)?Core::config()->auth->storage_secret_iv:'';
        $this->storage_secret_iv = substr(hash($hash_algorithm, $this->storage_secret_iv), 0, 16);
    }

    public function auth_set_data(string $data_key, ?string $data_value) : void
    {
        if(Core::config()->auth->use_encoding) $data_value = openssl_encrypt($data_value, 'aes128', 'AA4D5EB4E4C2E', 0, $this->storage_secret_iv);
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

        if(Core::config()->auth->use_encoding) $data_value = openssl_decrypt($data_value, 'aes128', 'AA4D5EB4E4C2E', 0, $this->storage_secret_iv);

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
}