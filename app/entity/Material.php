<?php
use app\entity;

/**
 * Description of Material
 * uchovava informacie o surovine
 * @author Netlic
 */

use app\entity\Entity;

class Material extends Entity{
    private $materialDetails;
    public function __construct($entityId, \PDO $sql) {
	parent::__construct($entityId, $sql);
	$this->populateDetails();
    }
    
    private function populateDetails(){
	$st = $this->sql->prepare("select popis, id_suroviny, nazov_spec from vwsurovina where nazov = '".$this->entityId."'");
	$st->execute();
	$this->materialDetails = $st->fetch(\PDO::FETCH_ASSOC);
	$this->entityDetails = $this->materialDetails;
    }
    
    public function getMaterialDetails(){
	return $this->materialDetails;
    }
}
