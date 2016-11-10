<?php

namespace framework\schemas;

class ClientConvertorSchema {

    public static function returnEvents() {
        return [
            "click" => ["javascript" => "onclick"]
        ];
    }

    public static function findInDom() {
        return [
            "class" => [
                "javascript" => "document.getElementsByClassName"],
            "id" => [
                "javascript" => "document.getElementsById"],
            "name" => [
                "javascript" => "document.getElementsByName"],
            "tagName" => [
                "javascript" => "document.getElementsByTagName"]
        ];
    }
    
    public static function priorAutoSelect() {
        return ["id", "name", "class", "tagName"];
    } 

}
