<?php
namespace framework\client\convertors;

use framework\interfaces\IClientConvertor;
use framework\schemas\ClientConvertorSchema;

class ClientConvertor implements IClientConvertor{
    protected $clientEngine;
    protected $clientSchema = ClientConvertorSchema::class;
    
    public function getEventFunction(){
        return $this->clientSchema::returnEvents()[$this->clientEngine];
    }
    
    public function getDomFunction(){
        
    }
}