<?php

namespace app\entity;

/**
 * Description of User
 * uchovava udaje o prihlasenom uzivatelovi 
 * @author Netlic
 */

use app\entity\Entity;
use app\init\ChladnickaSettings;
use app\schemas\route\RouteSchema;

class User extends Entity{
    private $userMenu;
    private $userDetails;
    public function __construct($userName/*, \PDO $sql*/) {
		parent::__construct($userName/*, $sql*/);
		$this->userMenu = $this->populateUserMenu();
		$this->userDetails = $this->populateUserDetails();
		$this->entityDetails = $this->userDetails;
		//$this->populateSocialNetwork();
    }
    
    private function populateSocialNetwork(){
		ChladnickaSettings::social(["typ" => reset($this->userDetails)["prihlasenie"], "typId" => reset($this->userDetails)["prihlId"]]);
    }
    
    private function populateUserMenu() : array {
		/*$stmnt = $this->sql->prepare("call spGetUserMenu('$this->entityId')");
		$stmnt->execute();*/
		return [];/*$stmnt->fetchAll(\PDO::FETCH_ASSOC);*/
    }
    
    private function populateUserDetails() : array {
		/*$stmnt = $this->sql->prepare("call spGetUserFullName('$this->entityId')");
		$stmnt->execute();*/
		return [];/*$stmnt->fetchAll(\PDO::FETCH_ASSOC);*/
    }
    
    public function getUserMenu() : array {
		return $this->userMenu;
    }
    
    public function getUserDetails() : array {
		return $this->userDetails;
    }
    
    public function isAuthorised($view = null) : bool{
		if(!$view){
			$routeSchema = RouteSchema::requestSchema();//route z url helpera
		}
		//var_dump($this->userMenu);
		foreach($this->userMenu as $menu){
			if($menu["nazov_polozky"] == $view){
				return true;
			}
		}
		return false;
    }
}
