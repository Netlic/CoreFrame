<?php

namespace framework\engine\events;

use framework\engine\init\Core;

abstract class ClientEvent extends Event {

    protected $client;
    protected $jsEvent;
    protected $jsElement;

    public function __construct($eventObject) {
        parent::__construct($eventObject);
        $this->client = Core::clientConvertor();
        $this->client->eventName = $this->getEvent();
    }

    public function trigger(callable $callback) {
        $this->eventObject->dom->after(Core::guiControl('script')->text("alert('blabla')"));
        /* echo $this->client->getConvertedCode(parent::trigger($callback));
          echo parent::trigger($callback); */
    }

    public abstract function getEvent() : string;
}
