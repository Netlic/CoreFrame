<?php
namespace framework\app\engine\guicontrols;

class Form extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "form";
    }
}