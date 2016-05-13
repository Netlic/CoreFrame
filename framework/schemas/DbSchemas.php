<?php

namespace framework\schemas;

class DbSchemas{
    /*
     * attributes allowed when attemting connection to database
     */
    public static $dbConnectionAttrs = ["dbname", "username", "password", "server"];
    /*
     * lists of connections to databases
     */
    public static function connections(){
        return [];
    }
}