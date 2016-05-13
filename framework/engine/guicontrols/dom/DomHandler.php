<?php

namespace framework\engine\guicontrols\dom;

use app\interfaces\elementsinterface\IjQueryDomHandler;
use app\engine\guicontrols\GuiControl;
use app\engine\guicontrols\dom\Elements;

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
