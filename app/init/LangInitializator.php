<?php

use app\init;

/**
 * Description of UserInitializator
 * prednastavuje jazyk zobrazovanej stranky
 * @author Netlic
 */
class LangInitializator {
    const ID = 'id';
    const SKRATKA = 'skratka';
    const NAZOV = 'nazov';
    
    private static $jazyk = array('id'=>1,'skratka'=>'SK','nazov'=>'Slovenčina');
    
    public static function getJazyk(){
	return self::$jazyk['id'];
    }
    
    public static function getHodnotaJazyk($hodnota){
	return self::$jazyk[$hodnota];
    }
    
    public static function setJazyk(array $jazyk){
	if(self::checkJazyk($jazyk)){
	    self::$jazyk = $jazyk;
	    return true;
	}
	return false;
    }
    
    private static function checkJazyk(array $jazyk){
	$control = ['id','skratka','nazov'];
	$jazykKeys = array_keys($jazyk);
	return count($jazykKeys) == 3 && array_diff($control, $jazykKeys) === array_diff($jazykKeys, $control);
    }
}
