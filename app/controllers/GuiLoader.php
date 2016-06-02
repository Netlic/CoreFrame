<?php
namespace app\controllers;

/**
 * Description of GuiLoader
 * nacitava gui PHP scripty
 * @author Netlic
 */
//use gui\gui_parts\GuiPartLoader;
use framework\controllers\Controller;
use app\init\{Initializator, LangInitializator, ChladnickaSettings};
use app\entityGroup\MaterialGroup;
use app\schemas\DefaultConstruct;

class GuiLoader extends Controller{
    private $guiParts;
    
    public function __construct() {
		parent::__construct();
    }
    
	public function Start(){
		
	}
	
    /*public function getGuiParts(){
		if(!$this->guiParts){
			$this->guiParts = new GuiPartLoader();
		}
		return $this->guiParts;
    }*/
    
    /*public function fridge(){
		return $this->loadView('platno',[]);
    }*/
    
    /*public function materialManager(/*\PDO $sql = null){
		/*$sql = ChladnickaSettings::init()->getDb();
		$st = $sql->prepare('call spGetMaterialList(:lang)');
		$lang = LangInitializator::getJazyk();
		$st->bindParam('lang', $lang, \PDO::PARAM_INT);
		$st->execute();
		$matList = $st->fetchAll(\PDO::FETCH_ASSOC);
		$this->checkDbErrors($sql, $st);
		return $this->loadView('sprava_surovin',["sql" => $sql, "matList" => $matList]);
    }*/
    
    /*public function recipeManager(){
		return $this->loadView('sprava_receptov',[]);
    }
    
    public function unauthorised(){
	
    }*/
    
    /*public function categoryManager(){
		$mGroups = MaterialGroup::createMaterialGroups(ChladnickaSettings::init()->getDb());
		$mUnCat = MaterialGroup::$uncategorised;
		return $this->loadView('kategorizacia',["mGroups" => $mGroups, "mUnCat" => $mUnCat]);
    }
    
    public function generalRecipes(){
		$sql = ChladnickaSettings::init()->getDb();
		$st = $sql->prepare("select * from vwgeneralrecipes where `jazyk` = ".LangInitializator::getJazyk());
		$st->execute();
		$grecipes = $st->fetchAll(\PDO::FETCH_ASSOC);
		$social = ChladnickaSettings::social();
		if(!$this->checkDbErrors($sql,$st)){
			return $this->loadView('vseobecne_recepty',["grecipes" => $grecipes, "social" => $social]);
		}
    }
    
    public function odhlas(){
		session_destroy();
		header('Location: index.php');
    }
    
    public function recept(){
		$idRecept = ChladnickaSettings::engine()->request->get("id");
		$fr = ChladnickaSettings::init()->getDb();
		$st = $fr->prepare("call chladnickadb.spGetRecipeDetails(".$idRecept.",".LangInitializator::getJazyk().")");
		$st->execute();
		$rDetails = $st->fetchAll(\PDO::FETCH_ASSOC);
		if(!$this->checkDbErrors($st)){
			return $this->loadView("recept",["rDetails" => $rDetails]);
		}
    }*/
}
