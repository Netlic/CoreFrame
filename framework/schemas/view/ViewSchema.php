<?php

namespace framework\schemas\view;

use app\schemas\view\ViewSchema;

class ViewSchema {

    /**
     * Creates path to specified view (master path)
     * @param type $viewName name of the view
     * @return string full path to view file
     */
    public static function returnMasterDir($viewName) {
        $viewFile = str_replace(".php", "", $viewName) . ".php";
        $path = str_replace(__NAMESPACE__, "app\\", __DIR__);
        return $path . ViewSchema::$masterDir . $viewFile;
    }

}
