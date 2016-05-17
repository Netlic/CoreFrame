<?php

namespace framework\schemas;

class DomSchema {
    public static $clientIdent = ["id", "class", "name"];
    public static $findElementByAttributes = ["id", "class", "name" , "data-*"];
    public static $guiControlList = ["form", "pagebody", "pageheader", "document"];
    public static $guiEvents = ["default" => ["click"]];
    public static $selector = ["." => "class","#" => "id","default" => "controlTag"];
    
    public static function returnSelectorByAttribute($attr){
        $selector = array_search($attr, static::$selector);
        return $selector === false ? "" : $selector;
    }
}
