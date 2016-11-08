<?php
namespace framework\engine\client\convertors;

use framework\interfaces\IClientConvertor;
use framework\schemas\ClientConvertorSchema;

class ClientConvertor implements IClientConvertor{
    protected $clientEngine;
    protected $clientSchema = ClientConvertorSchema::class;
    
    protected $clientText = "";
    
    public function getEventFunction(){
        return $this->clientSchema::returnEvents()[$this->clientEngine];
    }
    
    public function getDomFunction(){
        
    }
    
    public function addClientText($text) {
        $this->clientText .= $text; 
    }
    
    public function getText() {
        return $this->clientText;
    }
    
    public function setClientText($text) {
        $this->clientText = $text;
    }
}