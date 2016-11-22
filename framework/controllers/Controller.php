<?php

namespace framework\controllers;

use framework\schemas\DefaultConstruct;
use framework\view\View;
use framework\schemas\view\ViewSchema;

class Controller {

    protected $dir = "";

    /**
     * Renders given view
     * @return string generated html
     */
    protected function renderView() {
        $script = ViewSchema::returnMasterDir(func_get_args()[0]);
        $view = new View($script);
        return $view->render(func_get_args()[1] ?? []);
    }

    /**
     * Renders default layout
     * @return type
     */
    public function loadLayout() {
        $layOut = DefaultConstruct::returnLayout();
        return $this->renderView($layOut, ["trala" => "trala"]);
    }

    /**
     * If view is not specified, controller returns empty string
     * @return string
     */
    public function none() {
        return "";
    }

}
