<?php

namespace framework\engine\guicontrols\vital;

use framework\engine\guicontrols\GuiControl;

class Document extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "html";
    }
}