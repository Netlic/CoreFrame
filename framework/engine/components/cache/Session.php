<?php

namespace framework\engine\components\cache;

use interfaces\cache\ICache;

class Session implements ICache {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['expire'] = 86400;
    }

    public function add($key, $value) {
        $cached = $this->get($key);
        if (!$cached) {
            $_SESSION[$key] = $value;        
        } else if (is_array($cached)) {
            $_SESSION[$key][] = $value;
        } else if (!is_array($cached) && $cached) {
            $_SESSION[$key] = array($cached, $value);
        }
    }

    public function delete($key) {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    public function get($key) {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function called() {
        return get_called_class();
    }

}
