<?php
namespace php\app\init;

use php\app\init\Initializator;
use php\app\socialNetworks\{Facebook, ThisApp};
use php\app\routing\RouteHandler;
use php\app\engine\ChladnickaOnLine;
use php\app\schemas\{SocialNetworkSchema, RouteSchema};
use php\helpers\Url;
use php\app\engine\guicontrols\GuiControlSet;

/*
 * ChladnickaSettings
 */
class ChS {
    private static $init;
    private static $social;
    private static $user;
    private static $engine;
    private static $loginSettings;
	
	public static $guiControl = GuiControlSet::class;
	public static $document;
    //private static $moreResponse;
    
    public static function init(){
		return static::$init;
    }
    
    public static function social(){
		return static::$social;
    }
    
    public static function engine(){
		return static::$engine;
    }
    
    public static function start(){
		/*$doc = GuiControlSet::Document(["class" => "test"]);
		$body = GuiControlSet::PageBody(["class" => "body"]);
		$doc->dom->append(GuiControlSet::PageHeader(["class" => "head"]))->append($body);
		$body->dom->append(GuiControlSet::Form());
		echo $doc->render();*/
		static::createPage();
		/*static::$init = new Initializator();
		if(filter_input_array(INPUT_POST) && !filter_input(INPUT_POST, "isAjax")){
			static::$init->authenticated(filter_input_array(INPUT_POST));
		}
		static::$user = static::$init->getUser();
		static::setEngine();
		static::setSocial();
		static::route();
		static::$engine->createResponse();*/
		//var_dump(static::$social);
		//var_dump(memory_get_usage());
    }
    
	public static function createPage(){
		static::setEngine();
		static::setSocial();
	}
	
    public static function user(){
		return static::$user;
    }
    
    public static function route(){
		$r = new RouteHandler();
		$default = true;
		if(static::engine()->isAjax()){
			$route = ChladnickaSettings::engine()->request->post('origUrl');
			$default = false;
		}else{
			$route = static::findDirective();
		}
		$r->redirect($route, $default);
    }
    
    private static function setEngine(){
		static::$engine = static::$engine ?? new ChladnickaOnLine();
    }
    
    private static function setSocial(){
		if(!static::$user){
			static::$social = SocialNetworkSchema::returnSocial(["typ" => "ThisApp", "typId" => "1"]);
		}else{
			$uDet = static::$user->getUserDetails();
			static::$loginSettings = ["typ" => reset($uDet)["prihlasenie"], "typId" => reset($uDet)["prihlId"]];
			static::$social = SocialNetworkSchema::returnSocial(static::$loginSettings);
		}	
    }
    
    private static function findDirective(){
		$directives = RouteSchema::routeDirective();
		$get = static::engine()->request->get();
		//var_dump($get);
		$dirArray = array_intersect(array_keys($get), $directives);
		return !empty($dirArray) ? (strlen($get[reset($dirArray)]) == 0 ? reset($dirArray) : $get[reset($dirArray)]) : null;
    }
}