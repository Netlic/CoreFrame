<?php
use app\entity;

class Category extends Entity{
    
    private $categorySchema = [
	"material" => [
	    "saveProcedure" => "spSaveMaterialSpecific", 
	    "newCategorised" => ["saveProcedure" => "spCategoriseMaterial"]]
    ];
    
    public function __construct($entityId, \PDO $sql) {
	$this->entitySchema = $this->categorySchema;
	parent::__construct($entityId, $sql);
    }
    
    public function prepareProc($proc){
	return $this->sql->prepare($proc);
    }
}
