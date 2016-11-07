<?php

namespace framework\engine\events;

class Select extends ClientEvent {

    public function getEvent(): string {
        return $this->jsEvent = "select";
    }

}
