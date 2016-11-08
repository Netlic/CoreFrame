<?php

namespace framework\engine\client\convertors;

use framework\engine\client\utils\Console;
use framework\engine\init\Core;

class JavaScriptConvertor extends ClientConvertor {

    public function __construct() {
        $this->clientEngine = "javascript";
    }

    public function alert($text) {
        Core::client()->addClientText("alert('$text');");
    }

    public function console(): string {
        return Console::class;
    }

}
