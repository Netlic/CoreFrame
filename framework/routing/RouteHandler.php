<?php

namespace framework\routing;

use app\schemas\RouteSchema;
use framework\init\Core;
use controllers\Controller;
use app\controllers\ControllerSet;

class RouteHandler {
    private static $controller;
	
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
		$routes = [];
		if(!empty($route)){
			$rdirs = [];
			if(static::isRouteDirective(array_keys($route), $rdirs)){
				foreach($rdirs as $rdir){
					$finalRoute = $route[$rdir];
					if(!static::tryParseControllerRoute($finalRoute)){
						$controller = RouteSchema::returnRoute()[$finalRoute];
						$routes[] = [$finalRoute => $controller];
					}
					$routes[] = $route;
				}
			}
		}else{
			$routes[] = static::defaultRoute();
		}
		
		$controllerClass = static::findController($routes);
		//var_dump(static::$controller);
		//tu bude v buducnosti hodeny error
	}
	
	public static function findController(array $routes){
		$priorRoute = reset($routes);
		static::$controller = ControllerSet::getCollectionPart(reset($priorRoute));
	}
	
	public static function isRouteDirective(array $namespaces,array &$rdirs){
		$directives = RouteSchema::routeDirective();
		$rdirs = array_intersect($namespaces, $directives);
		return !empty($rdirs);
	}
	
    public function redirect(/*$route = null, $defaultRouting = true*/){
		/*$requestSchema = $this->findRoute($route);
		$controllerRoute = $this->findControllerRoute($requestSchema ?? []);
		$this->controller = new Controller();
		if($defaultRouting){
			ChladnickaSettings::engine()->addContent($this->readContent($controllerRoute, $route, $requestSchema));
			ChladnickaSettings::engine()->addBodyContent($this->controller->loadLayout());
		}else{
			$this->readContent($controllerRoute, $route, $requestSchema);
		}*/
    }
    
    private function readContent(/*$cRoute = null, $route = null, $requestSchema = null*/){
		/*$publicViews = RouteSchema::publicViews();
		if(!$route){
			$defView = RouteSchema::returnDefaultView();
			$defKeys = array_keys($defView);
			if(!empty($defKeys)){
				$method = reset($defKeys);
				$instantiate = str_replace("Controller",reset($defView),get_class($this->controller));
				$controllerInstance = new $instantiate();
				return call_user_func_array([$controllerInstance, $method],[]);
			}
			return null;
		}
		$view = $requestSchema["humanName"] ?? $requestSchema["method"];
		if(in_array($route, $publicViews) || ChladnickaSettings::user()->isAuthorised($view)){
			$instantiate = str_replace("Controller", $cRoute, get_class($this->controller));
			return call_user_func_array([(new $instantiate()),$requestSchema["method"]], $requestSchema["params"]);
		}
		$unauthorised = RouteSchema::returnUnathorised();
		return call_user_func_array([reset(array_keys($unauthorised)), reset($unauthorised)]);
		*/
    }
    
    //private function findRoute(/*$route = null*/){
		/*if(!$route){
			return $route;
		}
		return RouteSchema::requestSchema()[$route] ?? ["method" => $route, "params" => []];*/
    //}
    
    private function findControllerRoute(/*array $requestSchema = []*/){
		/*if(empty($requestSchema)){
			return null;
		}
		return RouteSchema::returnRoute()[$requestSchema["method"]] ?? null;*/
    }
}
