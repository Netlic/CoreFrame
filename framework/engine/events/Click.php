<?php

namespace framework\engine\events;

class Click extends ClientEvent {

    public function getEvent(): string {
        return $this->jsEvent = "click";
    }

}
