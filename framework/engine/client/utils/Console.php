<?php

namespace framework\engine\client\utils;

use framework\interfaces\client\IConsole;
use framework\engine\init\Core;

class Console implements IConsole {

    private static $comm = "console.";

    public static function assert() {
        
    }

    public static function clear() {
        
    }

    public static function count() {
        
    }

    public static function debug() {
        
    }

    public static function dir() {
        
    }

    public static function error() {
        Core::client()->addClientText(static::$comm . "error()");
    }

    public static function log($toLog) {
        $log = is_array($toLog) ? json_encode($toLog) : $toLog;
        Core::client()->addClientText(static::$comm . "log('$log');");
    }

}
