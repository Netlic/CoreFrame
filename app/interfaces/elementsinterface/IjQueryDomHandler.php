<?php

use app\interfaces\elementsinterface;

use app\engine\guicontrols\GuiControl;

interface IjQueryDomHandler{
    public function after();
    public function append(GuiControl $control, $index = null);
    public function before();
    public function children();
    public function find($pattern);
}