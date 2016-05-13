<?php
namespace framework\engine\events\eventmodels;

use app\interfaces\eventinterfaces\IGuiFormEvents;
use app\engine\events\{Reset, Submit};

class FormEventSet extends BasicEventSet implements IGuiFormEvents{
    public function submit(){
        (new Submit())->trigger();
    }
    
    public function reset(){
        (new Reset())->trigger();
    }
}
