<?php

namespace framework\engine\client\convertors;

use framework\engine\client\utils\Console;
use framework\engine\init\Core;
use framework\engine\guicontrols\GuiControl;

class JavaScriptConvertor extends ClientConvertor {

    

    public function __construct() {
        $this->clientEngine = "javascript";
    }

    protected function selectElement(GuiControl $control) {
        $this->findElementBy = $this->autoSelect($control->getAttributes());
        return $this->clientSchema::findInDom()[$this->findElementBy][$this->clientEngine];
    }

    public function alert($text) {
        Core::client()->addClientText("alert('$text');");
    }

    public function console(): string {
        return Console::class;
    }

    public function getClientEvent(GuiControl $control) {
        return $this->selectElement($control) . 
                ClientConvertor::toParenthesis($this->getSelectorValue($control)) . "." .
                ClientConvertor::eventFn()->fn();
    }

}
