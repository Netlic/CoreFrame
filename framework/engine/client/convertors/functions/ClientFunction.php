<?php

namespace framework\engine\client\convertors\functions;

use framework\engine\client\convertors\ClientConvertor as cC;

class ClientFunction {

    public function __construct() {
        
    }

    public function fn($text = null) {
        return "function" . cC::toParenthesis("") . cC::toBraces($text);
    }

}
