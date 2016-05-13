<?php
namespace framework\engine\events\eventmodels;

use app\interfaces\eventinterfaces\IGuiDefaultEvents;
use framework\helpers\Text;
use framework\engine\events\{Click, ContextMenu, Select};

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