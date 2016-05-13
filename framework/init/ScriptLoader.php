<?php

namespace framework\init;

/**
 * Description of ScriptLoader
 * nacitava PHP scripty
 * @author Netlic
 */

use controllers\{GuiLoader,AjaxScriptLoader};

class ScriptLoader {
    private static $gui;
    private static $ajax;
    public static $init;

    public static function AutoLoad() {
		spl_autoload_register(function ($class) {
			$file = $class.".php";
			if(file_exists($file)){
				require $file;
				return true;
			}else{
				error_log("Cannot autoload $file");
				return false;
			} 
		});
    }
    
    public static function LoadGui() : GuiLoader {
	try{
	    if(!self::$gui){
		self::$gui = new GuiLoader();
	    }
	    return self::$gui;
	}
	catch (Exception $e){
	    error_log($e->getMessage());
	}
    }
    
    public static function LoadAjax($script = null) : AjaxScriptLoader {
	if(!self::$ajax){
	    self::$ajax = new AjaxScriptLoader($script);
	}
	return self::$ajax;
    }
}
