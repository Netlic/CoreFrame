<?php

namespace framework\interfaces\elementsinterface;

use framework\engine\guicontrols\GuiControl;

interface IjQueryDomHandler{
    public function after();
    public function append(GuiControl $control, $index = null);
    public function before();
    public function children();
    public function find($pattern);
}