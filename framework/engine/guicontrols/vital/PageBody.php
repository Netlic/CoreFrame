<?php

namespace framework\engine\guicontrols\vital;

use framework\engine\guicontrols\GuiControl;

class PageBody extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "body";
    }
}