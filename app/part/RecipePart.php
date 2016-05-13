<?php
namespace app\part;

use php\app\part\Part;
use php\app\init\LangInitializator;

class RecipePart extends Part{
    const MaterialInfo = 1;
    const SubstInfo = 2;
    const CompInfo = 3;
    const RecipeInfo = 4;
    
    private $recipeSaveSchema = ["required" => ["nazov", "navod", "suroviny", "user"]];
    private $recipeId;
    
    public function setPartArray() {
	$this->partArray = [
	    "1" => ["infoMethod" => "materialInfo"],
	    "2" => ["infoMethod" => "substInfo"],
	    "3" => ["infoMethod" => "complInfo"],
	    "4" => ["infoMethod" => "recipeInfo"]
	];
    }

    public function getInfoArray($part = null) {
	if(!$this->actualPart){
	    $this->actualPart = $part;
	}
	if($this->testPartArray()){
	    $method = $this->partArray[$this->actualPart]["infoMethod"];
	    return $this->$method();
	}
	return false;
    }
    
    public function materialInfo(){
	$st = $this->db->prepare("call chladnickadb.spGetMaterialInfo(".LangInitializator::getJazyk().")");
	$st->execute();
	if($st->errorInfo()[1]){
	    return false;
	}
	
	$materialInfoArray = $st->fetchAll(\PDO::FETCH_ASSOC);
	return $materialInfoArray;
    }
    
    public function substInfo(){
	if(!isset($_SESSION["baseMaterial"])){
	    return false;
	}
	$array = [];
	foreach($_SESSION["baseMaterial"] as $base){
	    $array[] = ["nazov" => $base];
	}
	return $array;
    }
    
    public function complInfo(){
	$info = $this->materialInfo();
	if(!isset($_SESSION["baseMaterial"])){
	    return $info;
	}
	$baseList = implode(",",$_SESSION["baseMaterial"]);
	$rArray = [];
	foreach($info as $i){
	    if(strrpos($baseList, $i["nazov"]) === false){
		$rArray[] = ["nazov" => $i["nazov"]];
	    }    
	}
	return $rArray;
    }
    
    public function recipeInfo(){
	$st = $this->db->prepare("call chladnickadb.spGetRecipeInfo(".LangInitializator::getJazyk().")");
	$st->execute();
	if($st->errorInfo()[1]){
	    return false;
	}
	$recipeInfoArray = $st->fetchAll(\PDO::FETCH_ASSOC);
	return $recipeInfoArray;
    }
    
    public function saveAllParts(array $recipeDetails){
	if($this->checkSaveSchema($recipeDetails)){
	    $this->saveRecipeDefault($recipeDetails);
	    $this->saveMaterials($recipeDetails["suroviny"]);
	    if(isset($recipeDetails["recepty"])){
		$this->saveIncludedRecipes($recipeDetails["recepty"]);
	    }
	}
    }
    
    public function checkSaveSchema($schema){
	return count(array_intersect(array_keys($schema), $this->recipeSaveSchema["required"])) == 4;
    }
    
    public function saveRecipeDefault(array $recipeDef){
	$lang = LangInitializator::getJazyk();
	
	$db = $this->db;
	$st = $db->prepare("call chladnickadb.spSaveRecipe(:cook,:name,:inst,:lang,@rec_id);");

	$st->bindParam('cook',$recipeDef['user'], \PDO::PARAM_INT);
	$st->bindParam('name',$recipeDef['nazov'], \PDO::PARAM_STR);
	$st->bindParam('inst',$recipeDef['navod'], \PDO::PARAM_STR);
	$st->bindParam('lang',$lang, \PDO::PARAM_INT);
	$st->execute();
	
	$outputArray = $db->query("select @rec_id")->fetchAll(\PDO::FETCH_ASSOC);
	$this->recipeId = $outputArray[0]["@rec_id"];
	
	$error = $st->errorInfo()[2]." ".$db->errorInfo()[2];
	if(strlen(trim($error)) > 0){
	    error_log($error);
	}
    }
    
    public function saveMaterials($suroviny){
	$lang = LangInitializator::getJazyk();
	$db = $this->db;
	
	$stRemMat = $db->prepare("call chladnickadb.spRemoveMaterial(:recipe)");
	$stRemMat->bindParam('recipe', $this->recipeId, \PDO::PARAM_INT);
	$stRemMat->execute();
	
	foreach($suroviny as $index => $surovina){
	    $stAddMat = $db->prepare("call chladnickadb.spAddMaterialToRecipe(:recipe,:material,:quant,:lang);");
	    $stAddMat->bindParam(':recipe', $this->recipeId, \PDO::PARAM_INT);
	    $stAddMat->bindParam(':material', $index, \PDO::PARAM_STR,100);
	    $stAddMat->bindParam(':quant', $surovina, \PDO::PARAM_STR,20);
	    $stAddMat->bindParam(':lang', $lang, \PDO::PARAM_INT);
	    $stAddMat->execute();
	}
	$error = $stAddMat->errorInfo()[2]." ".$stRemMat->errorInfo()[2]." ".$db->errorInfo()[2];
	if(strlen(trim($error)) > 0){
	    error_log($error);
	}
    }
    
    public function saveIncludedRecipes($recepty){
	$lang = LangInitializator::getJazyk();
	$db = $this->db;
	
	$stRemMat = $db->prepare("call chladnickadb.spRemoveRecipe(:recipe)");
	$stRemMat->bindParam('recipe', $this->recipeId, \PDO::PARAM_INT);
	$stRemMat->execute();
	
	foreach($recepty as $recept){
	    $stAddMat = $db->prepare("call chladnickadb.spAddRecipeToRecipe(:recipe,:includedRecipe,:lang);");
	    $stAddMat->bindParam(':recipe', $this->recipeId, \PDO::PARAM_INT);
	    $stAddMat->bindParam(':includedRecipe', $recept, \PDO::PARAM_STR,100);
	    $stAddMat->bindParam(':lang', $lang, \PDO::PARAM_INT);
	    $stAddMat->execute();
	}
	$error = $stAddMat->errorInfo()[2]." ".$stRemMat->errorInfo()[2]." ".$db->errorInfo()[2];
	if(strlen(trim($error)) > 0){
	    error_log($error);
	}
    }
}
