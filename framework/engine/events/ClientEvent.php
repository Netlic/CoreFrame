<?php

namespace framework\engine\events;

use framework\engine\init\Core;

abstract class ClientEvent extends Event {

    protected $client;
    protected $jsEvent;
    protected $jsElement;

    public function __construct($eventObject) {
        parent::__construct($eventObject);
        $this->client = Core::client();
        $this->client->eventName = $this->getEvent();
    }

    public function trigger(callable $callback = null) {
        if ($callback) {
            call_user_func($callback);
            $this->eventObject->dom->after(Core::guiControl('script')->text(Core::client()->getText()));
            Core::client()->setClientText("");
        }
        /* echo $this->client->getConvertedCode(parent::trigger($callback));
          echo parent::trigger($callback); */
    }

    public abstract function getEvent() : string;
}
