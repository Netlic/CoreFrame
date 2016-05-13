<?php
namespace framework\app\engine\events;

class Event {
    public function __construct($eventObject){
        
    }
    
    public function trigger(callable $callback){
        return $callback();
    }
}
