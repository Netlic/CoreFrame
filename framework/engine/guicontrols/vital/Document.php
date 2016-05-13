<?php

namespace framework\app\engine\guicontrols\vital;

use app\engine\guicontrols\GuiControl;

class Document extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "html";
    }
}