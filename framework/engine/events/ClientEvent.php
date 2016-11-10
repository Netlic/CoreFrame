<?php

namespace framework\engine\events;

use framework\engine\init\Core;
//use framework\engine\client\convertors\ClientConvertor as cC;
use framework\engine\guicontrols\GuiControl;

abstract class ClientEvent extends Event {

    protected $client;
    protected $jsEvent;
    protected $jsElement;

    public function __construct($eventObject) {
        parent::__construct($eventObject);
        $this->client = Core::client();
        $this->client->eventName = $this->getEvent();
    }

    public function trigger(callable $callback = null): GuiControl {
        Core::client($this->client);
        if ($callback) {
            call_user_func($callback);
            //var_dump(cC::eventFn()->fn());
           // var_dump($this->client->getClientEvent($this->eventObject));
            $this->eventObject->dom->after(Core::guiControl('script')->text($this->client->getClientEvent($this->eventObject)));//Core::client()->getText()));
            Core::client()->setClientText("");
        }
        return $this->eventObject;
    }

    public abstract function getEvent(): string;
}
