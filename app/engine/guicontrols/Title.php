<?php
use app\engine\guicontrols;

class Title extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "title";
    }
}