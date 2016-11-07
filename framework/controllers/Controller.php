<?php

namespace framework\controllers;

use framework\schemas\DefaultConstruct;
use framework\engine\init\Core;

class Controller {

    private $masterDir;
    protected $dir = "";

    public function __construct() {
        $this->masterDir = str_replace("framework", "app", str_replace("controllers", "", __DIR__));
    }

    protected function content(string $script) {
        if (strrpos($script, "core.") !== false) {
            return include($script);
        }
        Core::engine()->outputBuffer->start();
        include ($script);
        return Core::engine()->outputBuffer->getClean();
    }

    protected function loadView() {
        $script = $this->masterDir . "gui\\" . $this->dir . str_replace(".php", "", func_get_args()[0]) . ".php";
        foreach (func_get_args()[1] as $index => $arg) {
            $$index = $arg;
        }

        return $this->content($script);
    }

    /*public function checkDbErrors() {
        $PDOErrors = "";
        foreach (func_get_args() as $arg) {
            if (get_class($arg) != "\PDO" || get_class($arg) != "\PDOStatement") {
                $PDOErrors .= $arg->errorInfo()[2] . " ";
            }
        }
        if (strlen(trim($PDOErrors)) > 0) {
            error_log($PDOErrors);
            return true;
        }
        return false;
    }*/

    public function loadLayout() {
        $layOut = DefaultConstruct::returnLayout();
        return $this->loadView($layOut, []);
    }

    public function none() {
        return "";
    }

}
