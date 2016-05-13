<?php
namespace app\interfaces;

use php\app\engine\guicontrols\GuiControl;

interface IGuiControl{
    //public function addChild(GuiControl $control, $index = null);
    public function getControlTag();
    public function render();
}