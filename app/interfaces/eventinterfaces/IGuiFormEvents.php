<?php

use app\interfaces\eventinterfaces;

interface IGuiFormEvents{
    public function submit();
    public function reset();
}