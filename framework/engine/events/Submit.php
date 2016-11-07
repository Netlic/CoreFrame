<?php

namespace framework\engine\events;

class Submit extends ClientEvent {

    public function getEvent(): string {
        return $this->jsEvent = "submit";
    }

}
