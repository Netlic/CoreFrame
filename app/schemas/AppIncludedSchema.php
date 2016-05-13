<?php

namespace app\schemas\AppIncludedSchema;

class AppIncludedModule{
    public static $appModules = ["db", "user"];
    public static function appModulesToInit(){
        return [];
    }
}