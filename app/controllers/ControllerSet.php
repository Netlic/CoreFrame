<?php
namespace app\controllers;

use app\controllers\{AjaxScriptLoader, GuiLoader};
use framework\controllers\Controller;

class ControllerSet {
    public static function GuiLoader(){
        return new GuiLoader();
    }
    
    public static function AjaxScriptLoader(){
        return new AjaxScriptLoader();
    }
    
    public static function getCollectionPart($partName){
        $thisClass = ControllerSet::class;
        return in_array($partName, get_class_methods($thisClass)) ? call_user_func([$thisClass, $partName]) : null;
    }
}
