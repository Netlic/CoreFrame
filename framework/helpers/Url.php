<?php

namespace framework\helpers;

class Url {

    public static function CreateMenu($menu, $default = "menu") {
	return "index.php?" . $default . "=" . $menu;
    }

    public static function CreateUrl(array $urlAttrs) {
	$url = [];
	foreach ($urlAttrs as $index => $urlAttr) {
	    $url[] = $index . "=" . $urlAttr;
	}
	return "index.php?" . implode("&", $url);
    }

    public static function test() {
	var_dump(static::parseUrl());
    }

    public static function Host() {
	return static::parseUrl()["SERVER_NAME"];
    }

    public static function Port() {
	return static::parseUrl()["SERVER_PORT"];
    }

    public static function HostPort() {
	return static::parseUrl()["HTTP_HOST"];
    }

    public static function AppRoute() {
	return static::parseUrl()["PHP_SELF"];
    }

    public static function toAsset() {
	return "php/app/asset/";
    }

    private static function parseUrl() {
	return filter_input_array(INPUT_SERVER);
    }

}
