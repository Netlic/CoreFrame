<?php
use app\dataReflect;

use app\dataReflect\DataReflect;

class Register extends DataReflect{
    private $registerSchema = ["facebookRegister" => [
	    "columns" => ["email", "meno", "priez", "prihlasenie"], 
	    "colsToSet" => ["rola" => 3]
	]
    ];
     
    public function __construct(array $registerData) {
	$this->saveProcedure = "spRegisterUser";
	$this->orderParams = ["email","meno","priez","rola","heslo","prihlasenie"];
	foreach($registerData as $regIndex => $regValue){
	    $this->$regIndex = $regValue;
	}
	$this->allocateAdditionalColumns();
	$this->procParams = "?,?,?,?,?,?";
    }
    
    private function allocateAdditionalColumns(){
	$addCols = $this->registerSchema[$this->type]["colsToSet"] ?? [];
	foreach($addCols as $addCol => $value){
	    $this->$addCol = $value;
	    $this->dataToSave[$addCol] = $value;
	}
    }

    protected function isValidReflect() {
	$columns = $this->registerSchema[$this->type]["columns"];
	foreach($columns as $column){
	    if(!$this->$column){
		return false;
	    }
	    $this->dataToSave[$column] = $this->$column;
	}
	return true;
    }

}
