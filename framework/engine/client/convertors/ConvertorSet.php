<?php
namespace framework\client\convertors;

class ConvertorSet {
    public static $javascript = JavaScriptConvertor::class;
    
    public static function JavaScriptConvertor(){
        return new static::$javascript;    
    } 
}
