<?php

namespace app\engine\guicontrols\dom;

use php\app\interfaces\elementsinterface\IjQueryDomHandler;
use php\app\engine\guicontrols\GuiControl;
use php\app\engine\guicontrols\dom\Elements;

class DomHandler implements IjQueryDomHandler{
    private $domElements = [];
    private $elementsObj;
    
    public function __construct(){
        $this->elementsObj = new Elements();
    }
    
    public function after(){
        return $this;
    }
    
    public function append(GuiControl $control, $index = null){
        $this->domElements[] = $control;
        return $this;
    }
    
    public function before(){
        return $this;
    }
    
    public function children(){
        return $this->domElements;
    }
    
    public function find($pattern){
        foreach($this->domElements as $domElement){
            
        }
        //$this->elementsObj
    }
}
