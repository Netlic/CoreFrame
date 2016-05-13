<?php
namespace app\entityGroup;

/**
 * Description of MaterialList
 * skupiny surovin so svojimi surovinami 
 * @author Netlic
 */

use php\app\entity\Material;
use php\app\init\LangInitializator;

class MaterialGroup {
    private $sql;
    private $groupId;
    private $entityList = [];
    
    public static $uncategorised = [];
    
    public function __construct($groupId, \PDO $sql) {
	$this->sql = $sql;
	$this->groupId = $groupId;
	$this->populateEntityList();
    }
    
    public static function createMaterialGroups(\PDO $sql){
	$materialGroupArray = [];
	$st = $sql->query('call spGetMaterialSpecifics');
	foreach($st->fetchAll(\PDO::FETCH_ASSOC) as $row){
	    $materialGroupArray[] = new MaterialGroup($row, $sql);
	}
	
	$stUn = $sql->prepare('call spGetUncategorisedMaterial(:lang)');
	$lang = LangInitializator::getJazyk();
	$stUn->bindParam('lang', $lang, \PDO::PARAM_INT);
	$stUn->execute();
	
	static::$uncategorised = $stUn->fetchAll(\PDO::FETCH_ASSOC);
	
	return $materialGroupArray;
    }
    
    private function populateEntityList(){
	$st = $this->sql->prepare("select nazov from vwsurovina where nazov_spec = '".$this->groupId['nazov_spec']."'");
	$st->closeCursor();
	$st->execute();
	foreach($st->fetchAll(\PDO::FETCH_ASSOC) as $row){
	    $this->entityList[] = new Material($row['nazov'], $this->sql);
	}
    }
    
    public function getEntities(){
	return $this->entityList;
    }
    
    public function getGroupId(){
	return $this->groupId;
    }
}
