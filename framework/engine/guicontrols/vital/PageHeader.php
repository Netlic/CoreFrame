<?php

namespace app\engine\guicontrols\vital;

use app\engine\guicontrols\GuiControl;

class PageHeader extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "head";
    }
}