<?php
namespace app\engine\events;

use app\engine\client\jQueryConvertor;

class ClientEvent extends Event{
    protected $client;
    protected $jsEvent;
    protected $jsElement;
    
    public function __construct($eventObject){
        $this->jsEvent = $this->determineEvent();
        parent::__construct($eventObject);
        $this->client = new jQueryConvertor($eventObject, $this->jsEvent);
    }
    
    public function determineEvent() : string{
        return strtolower(end(explode("\\",get_called_class())));
    }
    
    public function trigger(callable $callback){
        
        echo $this->client->getConvertedCode(parent::trigger($callback));
        echo parent::trigger($callback);
    }
}
