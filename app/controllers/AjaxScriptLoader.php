<?php

namespace controllers;

use app\init\{Initializator, LangInitializator, ChladnickaSettings};
use app\part\RecipePart;
use helpers\{Html, Text};
use controllers\Controller;
use app\entity\Category;
use app\dataReflect\Register;

class AjaxScriptLoader extends Controller{
    private $init;
    private $db;
    
    public function __construct($script = null) {
	parent::__construct();
	$this->dir = "ajax\\";
	$this->init = ChladnickaSettings::init();
	$this->db = $this->init->getDb();
	if($script){
	    $this->$script();
	}
    }
    
    public function recipeName(){
	$receptInfoArray = array();
	$fr = $this->init->getDb();
	$st = $fr->prepare("call chladnickadb.spGetRecipeInfo(".LangInitializator::getJazyk().")");
	$st->execute();
	if(!$st->errorInfo()[1]){
	    while($l = $st->fetch(\PDO::FETCH_ASSOC)){
		$receptInfoArray[] = $l['nazov'];
	    }
	    echo json_encode($receptInfoArray);
	    return true;
	}
	return false;
    }
    
    public function login(){
	$fr = $this->db;
	$json = filter_input(INPUT_POST, 'user');
	
	$st = $fr->prepare("SELECT heslo FROM chladnickadb.uzivatel WHERE email = '$json'");
	$st->execute();
	if(count($st->rowCount()) > 0){
	    $l = $st->fetch(\PDO::FETCH_ASSOC);
	    echo $l['heslo'];
	    return true;
	}
	return false;
    }
    
    public function recipeInstruction(){
	$fr = $this->db;
	$recept = ChladnickaSettings::engine()->request->post("recept");//filter_input(INPUT_POST, "recept");

	$inst = $fr->prepare("call chladnickadb.spGetRecipeInstruction('".$recept."',".LangInitializator::getJazyk().")");
	$inst->execute();
	$rinst = $inst->fetchAll(\PDO::FETCH_ASSOC);
	
	echo $rinst[0]['postup'];
        return true;
    }
    
    public function recipeList(){
	$list = ChladnickaSettings::engine()->request->post("list");//filter_input(INPUT_POST, "list");
	$recept = ChladnickaSettings::engine()->request->post("recept");//filter_input(INPUT_POST, "recept");
	$st = $this->setRecipeList($list, $recept);
	$st->execute();
	if($st->errorInfo()[1]){
	    error_log($st->errorInfo()[1]);
	}
	return $this->loadView('asynch_vyber_recepty_detaily',["st" => $st, "list" => $list]);
    }
    
    private function setRecipeList($list,$recept){
	$fr = $this->db;
	switch($list){
	    case 1:{$lisStatement = $fr->prepare("call chladnickadb.spGetRecipeMaterial('".$recept."',".LangInitializator::getJazyk().")");
		break;
	    }
	    case 2:{$lisStatement = $fr->prepare("call chladnickadb.spGetRecipeMaterial('".$recept."',".LangInitializator::getJazyk().")");
		break;
	    }
	    case 3:{$lisStatement = $fr->prepare("call chladnickadb.spGetRecipeMaterial('".$recept."',".LangInitializator::getJazyk().")");
		break;
	    }
	    case 4:{$lisStatement = $fr->prepare("call chladnickadb.spGetRecipeMaterial('".$recept."',".LangInitializator::getJazyk().")");
		break;
	    }
	    default:{$lisStatement = null;
		break;
	    }
	}
	return $lisStatement;
    }
    
    public function getRecipeListInfo(){
	$part = ChladnickaSettings::engine()->request->post("part");
	$rpInfo = new RecipePart($this->db, $part);
	$infoArray = $rpInfo->getInfoArray();
	echo $this->loadView('asynch_recipe_list_info',["infoArray" => $infoArray]);
    }
    
    public function materialToSession() {
	$material = ChladnickaSettings::engine()->request->post("material");//filter_input(INPUT_POST, "material");
	$input = ChladnickaSettings::engine()->request->post("input");//filter_input(INPUT_POST, "input");
	$_SESSION["baseMaterial"] = [$input => $material];
    }
    
    public function saveRecipe(){
	try{
	    $recept = ChladnickaSettings::engine()->request->post("data");//filter_input(INPUT_POST, "data", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	    $userId = $this->init->getUser()->getUserDetails();
	    $recept["user"] = reset($userId)['id'];

	    $this->db->beginTransaction();
	    
	    $rp = new RecipePart($this->db);
	    $rp->saveAllParts($recept);
	    
	    $this->db->commit();
	}
	catch(Exception $e){
	    $this->db->rollBack();
	    error_log($e->getMessage());
	}
    }
    
    public function saveMaterial(){
	$data = ChladnickaSettings::engine()->request->post("material");//filter_input(INPUT_POST, "material", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	$userId = $this->init->getUser()->getUserDetails();
	$lang = LangInitializator::getJazyk();
	$mName = Text::capitalize($data["name"]);
	$st = $this->db->prepare("call chladnickadb.spSaveMaterial(:cook, :material, :descr, :lang)");
	$st->bindParam('cook', reset($userId)["id"], \PDO::PARAM_INT);
	$st->bindParam('material', $mName, \PDO::PARAM_STR);
	$st->bindParam('descr', $data["descr"], \PDO::PARAM_STR);
	$st->bindParam('lang', $lang, \PDO::PARAM_INT);
	$st->execute();
	if($this->checkDbErrors($st, $this->db)){
	    echo "dbError";
	}
    }
    
    public function saveCategory(){
	$category = ChladnickaSettings::engine()->request->post("category");//filter_input(INPUT_POST, "category", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	$c = new Category($category["name"], $this->init->getDb());
	$eSchema = $c->getEntitySchema()[$category['relatedTo']];
	$fr = $this->init->getDb();
	$params = "(";
	if(is_array($category['procParams'])){
	    foreach($category['procParams'] as $procParam){
		$params .= "?,"; 
	    }
	}
	$params .= "@categoryId)";
	$st = $fr->prepare("call ".$eSchema["saveProcedure"].$params);
	$iterator = 1;
	$pdoStatic = new \ReflectionClass("\PDO");
	foreach($category['procParams'] as $param){
	    $type = $pdoStatic->getConstant("PARAM_".$param['type']);
	    $st->bindParam($iterator, $param['value'], $type);
	    $iterator++;
	}
	$st->execute();
	
	$outputArray = $fr->query("select @categoryId")->fetchAll(\PDO::FETCH_ASSOC);
	echo json_encode(["newCategory" => $outputArray[0]["@categoryId"]]);
    }
    
    public function categorise(){
	$data = ChladnickaSettings::engine()->request->post("categorise");//filter_input(INPUT_POST, "categorise", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	
	$lang = LangInitializator::getJazyk();
	$c = new Category($data["category"], $this->init->getDb());
	$proc = $c->getEntitySchema()[$data["relatedTo"]]["newCategorised"]["saveProcedure"];
	$st = $c->prepareProc("call ".$proc." (?,?,?)");
	$st->bindParam(1,$data["toCategorise"], \PDO::PARAM_STR);
	$st->bindParam(2,$data["category"], \PDO::PARAM_STR);
	$st->bindParam(3,$lang, \PDO::PARAM_INT);

	$st->execute();
	if($this->checkDbErrors($st)){
	    echo "dbError";
	}
    }
    
    public function registerUser(){
	$user = ChladnickaSettings::engine()->request->post("toRegister");//filter_input_array(INPUT_POST)["toRegister"];
	$reg = new Register($user);
	$reg->save();
    }
}
