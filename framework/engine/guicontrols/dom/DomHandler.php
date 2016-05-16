<?php

namespace framework\engine\guicontrols\dom;

use framework\interfaces\elementsinterface\IjQueryDomHandler;
use framework\engine\guicontrols\GuiControl;
use framework\engine\guicontrols\dom\Elements;

class DomHandler implements IjQueryDomHandler{
    private $domElements = [];
    private $elementsObj;
    private $curControl;
    
    public function __construct(GuiControl $currentControl){
        $this->elementsObj = new Elements();
        $this->curControl = $currentControl;
    }
    
    public function after(){
        return $this;
    }
    
    public function append(GuiControl $control, $index = null){
        $control->setParent($this->curControl);
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
        /*foreach($this->domElements as $domElement){
            
        }*/
        //$this->elementsObj
    }
}
