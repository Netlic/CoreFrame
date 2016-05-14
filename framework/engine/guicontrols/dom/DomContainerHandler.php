<?php
namespace framework\engine\guicontrols\dom;

use framework\interfaces\elementsinterface\IjQueryDomHandler;

class DomContainerHandler implements IjQueryDomHandler{
    private $controlsList;
    public function __construct(array $guiControlsList){
        $this->controlsList = $guiControlsList;
    }
    
    public function after(){
        return $this;
    }
    
    public function append(GuiControl $control, $index = null){
        return $this;
    }
    
    public function before(){
        return $this;
    }
    
    public function children(){
        return $this;
    }
    
    public function find($pattern){
        /*foreach($this->domElements as $domElement){
            
        }*/
        //$this->elementsObj
    }
}
