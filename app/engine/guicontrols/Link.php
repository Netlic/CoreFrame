<?php
use app\engine\guicontrols;

class Link extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "link";
    }
}