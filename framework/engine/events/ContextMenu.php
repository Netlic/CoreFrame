<?php

namespace framework\engine\events;

class ContextMenu extends ClientEvent {

    public function getEvent(): string {
        return $this->jsEvent = "contextmenu";
    }

}
