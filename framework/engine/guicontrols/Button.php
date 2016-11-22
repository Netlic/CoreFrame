<?php

namespace framework\engine\guicontrols;

use framework\engine\guicontrols\GuiControl;

class Button extends GuiControl {

    protected function setControlTag() {
        $this->controlTag = "button";
    }

}
