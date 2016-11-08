<?php

namespace framework\engine\containers;

class ClientContainer {

    public static function getConvertor() {
        return new \framework\engine\client\convertors\JavaScriptConvertor();
    }

}
