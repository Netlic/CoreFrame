<?php
namespace app\schemas;

use app\controllers\ControllerSet;

class RouteSchema {
    public static function publicViews(){
		return [
			"vr", "login", "recipeName", "getRecipeListInfo", "saveRecipe", "recipeList", 
			"recipeName", "materialToSession", "materialToSession","recipeInstruction",
			"saveCategory", "categorise", "saveCategory", "odhlas", "registerUser", "recept"];
    }
    
    public static function requestSchema(){
		return [
			"1" => [
				"method" => "materialManager", "params" => [], "humanName" => "Správa surovín"
			],
			"2" => [
				"method" => "recipeManager", "params" => [], "humanName" => "Správa receptov"
			],
			"3" => [
				"method" => "categoryManager", "params" => [], "humanName" => "Kategorizácia"
			],
			"vr" => [
				"method" => "generalRecipes", "params" => []
			]
		];
    }
    
    public static function returnRoute(){
		return [
			"materialManager" => "GuiLoader", "recipeManager" => "GuiLoader", "categoryManager" => "GuiLoader",
			"generalRecipes" => "GuiLoader", "unauthorised" => "GuiLoader", "login" => "AjaxScriptLoader", 
			"recipeName" => "AjaxScriptLoader", "getRecipeListInfo" => "AjaxScriptLoader", "saveRecipe" => "AjaxScriptLoader",
			"recipeList" => "AjaxScriptLoader", "recipeName" => "AjaxScriptLoader", "materialToSession" => "AjaxScriptLoader",
			"recipeInstruction" => "AjaxScriptLoader", "saveCategory" => "AjaxScriptLoader", "categorise" => "AjaxScriptLoader",
			"saveCategory" => "AjaxScriptLoader", "odhlas" => "GuiLoader", "registerUser" => "AjaxScriptLoader",
			"recept" => "GuiLoader"
		];
    }
    
	public static function returnDefaultView(){
		return [
			"fridge" => "GuiLoader"
			//"home" => "GuiLoader"
		];
    }
    
    public static function returnUnathorised(){
		return [
			"unauthorised" => "GuiLoader"
		];
    }
    
    public static function routeDirective(){
		return [
			"menu", "odhlas"
		];
    }
}
