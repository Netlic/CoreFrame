<?php
namespace php\app\entity;

/**
 * Description of Entity
 * konstrukcna trieda pre vsetky typy entit
 * @author Netlic
 */
abstract class Entity {
    protected $entityId;
    protected $sql;
    protected $entityDetails;
    protected $entitySchema;


    public function __construct($entityId/*, \PDO $sql*/) {
		$this->entityId = $entityId;
		//$this->sql = $sql;
    }
    
    public function getEntity(){
		return $this->entityId;
    }
    
    public function getEntityDetails(){
		return $this->entityDetails;
    }
    
    public function getEntitySchema(){
		return $this->entitySchema;
    }
}
