<?php
namespace framework\schemas;

class ClientConvertorSchema {
    public static function returnEvents(){
        return [
            "javascript" => ["click" => "onclick"]    
        ];
    }
}
