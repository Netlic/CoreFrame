<?php

namespace framework\engine\guicontrols\dom;

use framework\interfaces\elementsinterface\IjQueryDomHandler;
use framework\engine\guicontrols\GuiControl;

class DomContainerHandler implements IjQueryDomHandler {

    private $controlsList;
    public $single;

    public function __construct(array $guiControlsList) {
	$this->controlsList = $guiControlsList;
	if (count($this->controlsList) == 1) {
	    $this->single = reset($this->controlsList);
	}
    }

    public function after() {
	return $this;
    }

    public function append(GuiControl $control, $index = null) {
	return $this;
    }

    public function before() {
	return $this;
    }

    public function children() {
	return $this;
    }

    public function find($pattern) {
	/* foreach($this->domElements as $domElement){

	  } */
	//$this->elementsObj
    }

    public function parents() {
	
    }

}
