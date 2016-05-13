<?php

namespace framework\engine\guicontrols\vital;

use framework\engine\guicontrols\GuiControl;

class PageHeader extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "head";
    }
}