<?php

namespace framework\schemas;

class DbSchemas{
    /*
     * attributes allowed when attemting connection to database
     */
    public static $dbConnectionAttrs = [
        "sql" => ["dbname", "username", "password", "server"],
        "nosql" => []
    ];
    /*
     * lists of connections to databases
     */
    public static function connections(){
        return [];
    }
    
    public static function dbEngines(){
        return [
            "sql" => \PDO::class,
            "nosql" => ""
        ];
    }
}