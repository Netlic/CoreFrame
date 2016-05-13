<?php
namespace php\app\init;

use php\app\init\{ScriptLoader, ChladnickaSettings};

class MenuHandler {
    private static $menuSchema = [
	"1" => [
	    "method" => "materialManager", "params" => []
	],
	"2" => [
	    "method" => "recipeManager", "params" => []
	],
	"3" => [
	    "method" => "categoryManager", "params" => []
	],
	"vr" => [
	    "method" => "generalRecipes", "params" => []
	]
    ];
    private static $nonLoginSchema = [
	"vr"
    ];
    private static $menu;
    
    public static function render($menu){
	self::$menu = $menu;
	if(self::checkAuthorised()){
	    self::checkInit();
	    self::menuSwitcher();
	}else{
	    ScriptLoader::LoadGui()->unauthorised();
	}
    }
    
    private static function checkAuthorised(){
	if(in_array(static::$menu, static::$nonLoginSchema)){
	    return true;
	}
	if(self::isLogged()){
	    foreach(ChladnickaSettings::init()->getUser()->getUserMenu() as $menus){
		if($menus["synonymum"] == self::$menu){
		    return true;
		}
	    }
	    return false;
	}
	return false;
    }
    
    private static function isLogged() : bool {
	return ChladnickaSettings::init()->getUser() ? true : false;
    }
    
    private static function checkInit(){
	if(!ChladnickaSettings::init() instanceof Initializator){
	    ChladnickaSettings::init(new Initializator());
	}
    }
    
    private static function menuSwitcher(){
	$callbackSettings = isset(static::$menuSchema[static::$menu]) ? static::$menuSchema[static::$menu] : "fridge";
	$guiLoader = ScriptLoader::LoadGui();
	call_user_func_array([$guiLoader, $callbackSettings["method"]],$callbackSettings["params"]);
    }
}
