<?php

namespace php\app\interfaces\eventinterfaces;

interface IGuiDefaultEvents{
    public function click(callable $callback);
    public function contextmenu();
    public function select();
}