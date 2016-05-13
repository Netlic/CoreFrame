<?php

namespace framework\routing;

use app\schemas\RouteSchema;
use app\init\ChladnickaSettings;
use controllers\Controller;

class RouteHandler {
    private $controller;
    public function redirect($route = null, $defaultRouting = true){
		$requestSchema = $this->findRoute($route);
		$controllerRoute = $this->findControllerRoute($requestSchema ?? []);
		$this->controller = new Controller();
		if($defaultRouting){
			ChladnickaSettings::engine()->addContent($this->readContent($controllerRoute, $route, $requestSchema));
			ChladnickaSettings::engine()->addBodyContent($this->controller->loadLayout());
		}else{
			$this->readContent($controllerRoute, $route, $requestSchema);
		}
    }
    
    private function readContent($cRoute = null, $route = null, $requestSchema = null){
		$publicViews = RouteSchema::publicViews();
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
	
    }
    
    private function findRoute($route = null){
		if(!$route){
			return $route;
		}
		return RouteSchema::requestSchema()[$route] ?? ["method" => $route, "params" => []];
    }
    
    private function findControllerRoute(array $requestSchema = []){
		if(empty($requestSchema)){
			return null;
		}
		return RouteSchema::returnRoute()[$requestSchema["method"]] ?? null;
    }
}
