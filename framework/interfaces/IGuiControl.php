<?php
namespace framework\interfaces;

use framework\engine\guicontrols\GuiControl;

interface IGuiControl{
    public function getControlTag();
    public function render();
}