<?php
namespace app\engine\events\eventmodels;

use php\app\interfaces\eventinterfaces\IGuiDefaultEvents;
use php\helpers\Text;
use php\app\engine\events\{Click, ContextMenu, Select};

class BasicEventSet extends EventSet{
    public function click(callable $callback){
        (new Click($this->eventObject))->trigger($callback);
    }
    
    public function contextmenu(){
        (new ContextMenu())->trigger();
    }
    
    public function select(){
        (new Select())->trigger();
    }
}