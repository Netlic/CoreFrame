<?php
namespace app\part;

use php\app\interfaces\partInterface;

abstract class Part implements partInterface{
    protected $partArray;
    protected $actualPart;
    protected $db;
    
    public function __construct(\PDO $db, $part = null) {
	$this->db = $db;
	$this->actualPart = $part;
	$this->setPartArray();
    }
    
    public function testPartArray(){
	if(!$this->actualPart){
	    return false;
	}
	if(empty($this->partArray)){
	    return false;
	}
	if(!key_exists($this->actualPart, $this->partArray)){
	    return false;
	}
	if(!key_exists("infoMethod", $this->partArray[$this->actualPart])){
	    return false;
	}
	return true;
    }
}
