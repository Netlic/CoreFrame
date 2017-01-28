<?php

namespace app\schemas\controller;

use framework\engine\helpers\Text;

class ControllerSchema {

    /**
     * return either default or specific controller namespace
     * @param string $controllerName - name for specific namespacae
     * @return string
     */
    public static function controllerNamespace(string $controller, string $specificName = ""): string {
        $namespace = static::specificNamespace()[$controller] ?? "app\\controllers\\";
        return $namespace . Text::capitalize($controller) . "Controller";
    }

    /**
     * returns array containing specific namespaces
     * @return array
     */
    public static function specificNamespace(): array {
        return [];
    }

}
