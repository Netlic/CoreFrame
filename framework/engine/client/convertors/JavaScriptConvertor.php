<?php
namespace framework\engine\client\convertors;

class JavaScriptConvertor extends ClientConvertor{
    public function __construct(){
        $this->clientEngine = "javascript";
    }
}