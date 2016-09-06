<?php

namespace framework\helpers;

class Text {

    public static function capitalize($str) {
	return ucfirst($str);
    }

    public static function upperCase($str) {
	return strtoupper($str);
    }

    public static function lowerCase($str) {
	return strtolower($str);
    }

}
