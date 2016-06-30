<?php
namespace framework\client\convertors;

class JavaScriptConvertor extends ClientConvertor{
    public function __construct(){
        $this->clientEngine = "javascript";
    }
}