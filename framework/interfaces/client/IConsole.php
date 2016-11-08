<?php

namespace framework\interfaces\client;

interface IConsole {

    public static function assert();

    public static function clear();

    public static function count();

    public static function debug();

    public static function dir();

    public static function log($toLog);

    public static function error();
}
