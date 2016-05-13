<?php
namespace app\engine\events\eventmodels;

use php\app\interfaces\eventinterfaces\IGuiFormEvents;
use php\app\engine\events\{Reset, Submit};

class FormEventSet extends BasicEventSet implements IGuiFormEvents{
    public function submit(){
        (new Submit())->trigger();
    }
    
    public function reset(){
        (new Reset())->trigger();
    }
}
