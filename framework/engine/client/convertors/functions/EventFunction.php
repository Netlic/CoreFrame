<?php

namespace framework\engine\client\convertors\functions;

use framework\engine\client\convertors\functions\ClientFunction;
use framework\engine\init\Core;
use framework\engine\client\convertors\ClientConvertor as cC;

class EventFunction extends ClientFunction {

    public function fn($text = null) {
        return Core::client()->getEventFunction() . " = " . parent::fn($text);//cC::toParenthesis(parent::fn($text));
    }

}
