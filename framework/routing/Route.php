<?php

namespace framework\routing;

use framework\engine\init\Core;
use framework\schemas\routing\RouteSchema;
use app\schemas\controller\ControllerSchema;

/**
 * class designed to handle routes
 */
class Route {

    private $controller = "";
    private $method = "";
    private $route = "";
    private $params = [];

    public function __construct() {
        $this->findRoute();
    }

    /**
     * creates parameters array from route 
     * @param array $routeArray - route array
     * @return array
     */
    private function divideRoute(array $routeArray) {
        $params = array_slice($routeArray, 2);
        $paramsArray = [];
        array_walk($params, function($value, $key) use (&$paramsArray, $params) {
            if ($key % 2 == 0) {
                $paramsArray[$value] = array_key_exists($key + 1, $params) ? $params[$key + 1] : "";
            }
        });
        return $paramsArray;
    }

    /**
     * parse route from $_GET
     */
    public function findRoute() {
        $get = Core::engine()->request->get();
        $this->route = array_intersect([RouteSchema::routeMark()], array_keys($get));
        $routeArray = reset($this->route) != false ? explode("/", $get[reset($this->route)]) : [];
        if (!empty($this->route) && $this->checkRoute($get[reset($this->route)])) {
            list($this->controller, $this->method) = explode("/", $get[reset($this->route)]);
            $this->params = $this->divideRoute($routeArray);
        }
    }

    /**
     * check if given url contains route
     * @param string $route - url to check
     * @return bool
     */
    public function checkRoute(string $route): bool {
        return count(explode("/", $route)) >= 2;
    }

    /**
     * returns controller part of route
     * @return type
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * returns method part of route
     * @return type
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * returns whole route
     * @return type
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * creates anonymous function for dispatcher
     * @return type
     */
    public function getFunction() {
        return function() {
            if (strlen($this->method) <= 0) {
                return "";
            }
            return $this->instantiateController()->{$this->method}($this->params);
        };
    }

    /**
     * instantiates controller using controller part of route
     * @return string
     */
    public function instantiateController() {
        $controller = ControllerSchema::controllerNamespace($this->controller);
        return strlen($this->controller) > 0 ? (new $controller()) : new \framework\controllers\Controller();
    }

}
