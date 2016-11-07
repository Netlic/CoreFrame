<?php

namespace framework\engine\events;

class Event {
    protected $eventObject;
    public function __construct($eventObject) {
	$this->eventObject = $eventObject;
    }

    public function trigger(callable $callback) {
	return $callback();
    }

}
