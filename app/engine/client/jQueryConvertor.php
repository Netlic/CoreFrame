<?php
use app\engine\client;

use app\schemas\DomSchema;

class jQueryConvertor{
    private $elementSelector = "$(document)";
    private $fn;
    private $clientElementObject;
    
    public function __construct($eventObject, $jqFunction = null){
        $this->fn = $jqFunction;
        $this->clientElementObject = $eventObject;
        $this->tryParseSelector();
    }
    
    private function tryParseSelector(){
        foreach(DomSchema::$clientIdent as $id){
            $idValue = $this->clientElementObject->getAttributes()[$id];
            if($idValue){
                $shortSelector = array_search($id, DomSchema::$selector);
                $selector = $shortSelector !== false ? $shortSelector : "";
                $this->elementSelector = str_replace("document", "'".$selector.$idValue."'", $this->elementSelector);
                return true;
            }
        }
        return false;
    }
    
    public function getConvertedCode($clientCode){
        return '<script>'.$this->elementSelector.'.'.$this->fn.'(function(){'.$clientCode.
            '})</script>';
    }
    
}