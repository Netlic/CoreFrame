<?php

namespace framework\routing;

use app\schemas\RouteSchema;
use framework\init\Core;
use framework\controllers\Controller;
use app\controllers\ControllerSet;

class RouteHandler {
    private static $routes = [];
	public static $controller;
	
	public static function tryParseControllerRoute(&$route){
		if(!is_array($route)){
			$parseString = explode("-", $route);
			if(count($parseString) != 2){
				return false;
			}
			$route = [reset($parseString) => end($parseString)];
			return true;
		}
		return true;
	}
	
	public static function defaultRoute(){
		return RouteSchema::returnDefaultView();
	} 
	
	public static function findRoute(){
		$route = Core::engine()->request->get();
		if(!empty($route)){
			$rdirs = [];
			if(static::isRouteDirective(array_keys($route), $rdirs)){
				foreach($rdirs as $rdir){
					$finalRoute = $route[$rdir];
					if(!static::tryParseControllerRoute($finalRoute)){
						$controller = RouteSchema::returnRoute()[$finalRoute];
						static::$routes[] = [$finalRoute => $controller];
					}
					static::$routes[] = $route;
				}
			}
		}else{
			static::$routes[] = static::defaultRoute();
		}
		$controllerClass = static::findController();
		//tu bude v buducnosti hodeny error, ak nenajde controller
	}
	
	public static function findController(array $routes = null){
		$r = $routes ?? static::$routes;
		$priorRoute = reset($r);
		return static::$controller = ControllerSet::getCollectionPart(reset($priorRoute));
	}
	
	public static function isRouteDirective(array $namespaces,array &$rdirs){
		$directives = RouteSchema::routeDirective();
		$rdirs = array_intersect($namespaces, $directives);
		return !empty($rdirs);
	}
	
    public function redirect(){
		//error, ak neexistuje static::routes
		$routes = array_keys(reset(static::$routes));
		$firstRoute = strlen(reset($routes)) > 0 ? reset($routes) : "none";
		//error, ak nie je controller
		return static::$controller->$firstRoute();		
    }
}
