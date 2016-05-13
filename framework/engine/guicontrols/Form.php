<?php
namespace framework\engine\guicontrols;

class Form extends GuiControl{
    protected function setControlTag(){
        $this->controlTag = "form";
    }
}