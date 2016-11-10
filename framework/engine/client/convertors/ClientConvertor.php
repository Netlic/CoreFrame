<?php

namespace framework\engine\client\convertors;

use framework\interfaces\IClientConvertor;
use framework\schemas\ClientConvertorSchema;
use framework\engine\init\Core;
use framework\engine\client\convertors\functions\ClientFunction;
use framework\engine\guicontrols\GuiControl;

class ClientConvertor implements IClientConvertor {

    protected $clientEngine;
    protected $clientSchema = ClientConvertorSchema::class;
    protected $clientText = "";
    protected $findElementBy;
    public $eventName;

    protected function autoSelect(array $atrributes) {
        //$findInDom = ClientConvertorSchema::findInDom();
        $priors = $this->clientSchema::priorAutoSelect();
        $intersect = array_intersect(array_keys($priors), array_keys($atrributes));
        if (empty($intersect)) {
            return "tagName";
        }
        return reset($intersect);
        /*if (count($intersect) > 1) {
            $priorArray = array_intersect(ClientConvertorSchema::priorAutoSelect(), $intersect); 
            return reset($priorArray);
        }
        return $findInDom[reset($intersect)][$this->clientEngine];*/
    }

    public function getSelectorValue(GuiControl $control) {
        if ($this->findElementBy == "tagName") {
            return '"' . $control->controlTag  . '"';
        }
        return '"' . $control->getAttributes()[$this->findElementBy] . '"';
    }
    
    public function getEventFunction() {
        return $this->clientSchema::returnEvents()[$this->eventName][$this->clientEngine];
    }

    public function getDomFunction() {
        //if ("blabla") return;
    }

    public function addClientText($text) {
        $this->clientText .= $text;
    }

    public function getText() {
        return $this->clientText;
    }

    public function setClientText($text) {
        $this->clientText = $text;
    }

    public static function clientFn() {
        return new ClientFunction();
    }

    public static function eventFn() {
        return new functions\EventFunction();
    }

    public static function leftBrace() {
        return "{";
    }

    public static function rigthBrace() {
        return "}";
    }

    public static function toBraces($text = null) {
        return static::leftBrace() . static::findFunctionText($text) . static::rigthBrace();
    }

    public static function leftParenthesis() {
        return "(";
    }

    public static function rightParenthesis() {
        return ")";
    }

    public static function toParenthesis($text = null) {
        return static::leftParenthesis() . static::findFunctionText($text) . static::rightParenthesis();
    }

    private static function findFunctionText($text = null) {
        return $text ?? Core::client()->getText();
    }

}
