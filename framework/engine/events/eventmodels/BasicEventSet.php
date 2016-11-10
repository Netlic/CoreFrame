<?php

namespace framework\engine\events\eventmodels;

use app\interfaces\eventinterfaces\IGuiDefaultEvents;
use framework\helpers\Text;

use framework\engine\events\ {
    Click, ContextMenu, Select
};

class BasicEventSet extends EventSet {

    public function click(callable $callback) {
	return (new Click($this->eventObject))->trigger($callback);
    }

    public function contextmenu() {
	return (new ContextMenu())->trigger();
    }

    public function select() {
	return (new Select())->trigger();
    }

}
