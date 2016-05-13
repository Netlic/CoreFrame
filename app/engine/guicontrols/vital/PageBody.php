<?php

namespace php\app\engine\guicontrols\vital;

use php\app\engine\guicontrols\GuiControl;

class PageBody extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "body";
    }
}