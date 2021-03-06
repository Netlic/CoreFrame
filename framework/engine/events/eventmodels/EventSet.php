<?php

namespace framework\engine\events\eventmodels;

use framework\engine\helpers\Text;
use framework\engine\events\Event;

class EventSet {

    public $eventObject;

    public function addEvent(Event $event) {
	
    }

    public static function instantiate($type, $eventObject) {
	
        $thisClass = __class__;
	$classArray = explode("\\", $thisClass);
	$classArray[count($classArray) - 1] = Text::capitalize($type) . "EventSet";
	$toInst = implode("\\", $classArray);
        $evSet = class_exists($toInst, false) === true ? new $toInst() : new BasicEventSet();
        $evSet->eventObject = $eventObject;
	return $evSet;
    }

}
