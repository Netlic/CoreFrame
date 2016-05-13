<?php

namespace app\engine\components;

class Component {
    public static function createComponent($component){
		$objComp = str_replace("Component", $component, get_called_class());
		return new $objComp();
    }
}
