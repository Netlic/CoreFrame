<?php

namespace php\app\interfaces\elementsinterface;

use php\app\engine\guicontrols\GuiControl;

interface IjQueryDomHandler{
    public function after();
    public function append(GuiControl $control, $index = null);
    public function before();
    public function children();
    public function find($pattern);
}