<?php

namespace framework\engine\events;

class Reset extends ClientEvent {

    public function getEvent(): string {
        return $this->jsEvent = "reset";
    }

}
