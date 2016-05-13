<?php

namespace app\engine\guicontrols\vital;

use php\app\engine\guicontrols\GuiControl;

class PageHeader extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "head";
    }
}