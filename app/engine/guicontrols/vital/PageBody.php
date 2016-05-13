<?php

use app\engine\guicontrols\vital;

use app\engine\guicontrols\GuiControl;

class PageBody extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "body";
    }
}