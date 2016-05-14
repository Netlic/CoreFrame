<?php
namespace framework\engine;

use framework\schemas\{DefaultChladnickaConstruct, ComponentSchema};
use framework\helpers\{Html, Text, Url};
use app\interfaces\IChladnickaEngine;
use framework\engine\components\Component;
use framework\init\Core;

class ChladnickaOnLine implements IChladnickaEngine{
    private $data = [];
    private $header = ["meta" => "", "css" => "", "js" => ""];
    private $body = ["js" => ""];
    private $createdHeader;
    private $createdMetaHeader;
    private $createdCssHeader;
    private $createdJsHeader;
    private $createdJsBody;
    private $createdBody;
    private $notParse;
    private $content;
    private $bodyContent;
    public $doctype = "<!DOCTYPE Html>";
    public $title = "It has never been easier";
    public $pathToAsset = "php/app/asset/";
    
    public function __construct() {
		$this->createDom();
		$this->loadDefaultConstruct();
		$this->loadEngineComponents();
	}
    
    public function __call($name, $arguments){
        call_user_func_array($this->$name, $arguments);
    }

    public static function __callStatic($name, $arguments){
        
    }
    
    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __isset($name){
        return isset($this->data[$name]);
    }

    public function __unset($name){
        unset($this->data[$name]);
    }
	
	private function createDom(){
		Core::$document = Core::$guiControl::Document(["class" => "test"]);
		$body = Core::$guiControl::PageBody(["class" => "body"]);
		Core::$document->dom->append(Core::$guiControl::PageHeader(["class" => "head"]))->append($body);
		$this->createHeader();
	}
    
    private function loadDefaultConstruct(){
		$assets = DefaultChladnickaConstruct::returnAssets();
		$this->header["meta"] = DefaultChladnickaConstruct::returnMeta();
		$this->header["css"] = $assets["head"]["css"];
		$this->header["js"] = $assets["head"]["js"];
		$this->body["js"] = $assets["body"]["js"];
		$this->notParse = DefaultChladnickaConstruct::notParsingAttrs();
    }
    
    private function loadEngineComponents(){
		foreach(ComponentSchema::returnComponents() as $component => $class){
			$this->$component = new $class();
		}
    }
    
    public function isAjax(){
		return !empty($this->request->post("isAjax")) && $this->request->post("isAjax") === "true";
    }
    
    public function createResponse(){
		if(!$this->isAjax()){
			$this->createChladnicka();
		}
    }
    
    public function addMeta(array $meta){
		$this->header["meta"][] = $this->parseTags($meta);
    }
    
    public function addMultipleMeta(array $metas){
		foreach($metas as $meta){
			if(is_array($meta)){
				$this->addMeta($meta);
			}
		}
    }
    
    public function createChladnicka(){
		echo $this->doctype;
		echo $this->createSkelet();
    }
    
    public function createHeader(){
		if(!$this->createdHeader){
			$head = Core::$document->dom->find("head");
			$this->createDefaultTags("header");
			$head->dom->append((Core::$guiControl::Title)->text($this->title));
			/*$title = Html::returnTag("title", Html::encode($this->title));
			$this->createdHeader = Html::returnTag("head", $this->createDefaultTags("header").$title);*/
		}
		return $this->createdHeader;
    }
    
    public function createDefaultTags($type){
		$createdTags = "";
		$head = Core::$document->dom->find("head");
		foreach($this->$type as $tagType => $tags){
			//$attr = "created".Text::capitalize($tagType).Text::capitalize($type);
			//if(!$this->$attr){
				$core = Core::class;
				foreach($tags as $tag){
					$tagOpts = $this->filterOptions($tag);
					$tagToCreate = $tag['tagName'] ?? $tagType;
					$this->configureAsset($tagToCreate, $tagOpts);
					//$head->append(Core::$guiControl::class);		
					//$this->$attr .= Html::returnTag($tagToCreate, null, $tagOpts);
				}
			//}
			//$createdTags .= $this->$attr;
		}
		//return $createdTags;
    }
    
    public function createBody(){
		if(!$this->createdBody){
			$this->createdBody = Html::returnTag("body", $this->bodyContent.$this->createDefaultTags("body"));
		}
		return $this->createdBody;
    }
    
    public function createSkelet(){
		$content = $this->createHeader().$this->createBody();
		$skelet = Html::returnTag("html", $content);
		return $skelet;
    }
    
    public function addAsset($assetName, $where, $tagName){
	
    }
    
    public function addMultipleAsset(array $assets){
	
    }
    
    public function addContent($html){
		$this->content = $html;
    }
    
    public function addViewScriptFile($scriptFile) {
		Html::tag("script", null, ["src" => Url::toAsset()."js/".$scriptFile]);
    }
    
    public function loadContent(){
		return $this->content;
    }
    
    public function addBodyContent($html){
		$this->bodyContent = $html;
    }
    
    private function parseTags(array $meta){
		$returnArray = [];
		$keys = array_keys($meta);
		foreach($keys as $key){
			$returnArray[$key] = $meta[$key];
		}
		return $returnArray;
    }
    
    private function filterOptions($tagOptions){
		$toUnset = array_intersect(array_keys($tagOptions), $this->notParse);
		foreach($toUnset as $key){
			unset($tagOptions[$key]);
		}
		return $tagOptions;
    }
    
    private function configureAsset($tag, &$tagOpts){
		if($this->isAsset($tag)){
			$attr = $this->findAttrToConfigure($tag);
			$fileRemaster = str_replace(".css", "", $tagOpts[$attr]).".".$this->findFileType($tag);
			$assetFile = $fileRemaster;
			//echo $assetFile." :: ";
			$tagOpts[$attr] = file_exists($assetFile) ? $assetFile : $this->createAssetPath().$this->findFileType($tag)."/".$fileRemaster;
		}
    }
    
    private function isAsset($tag){
		return in_array($tag, array_keys(DefaultChladnickaConstruct::returnAssetTags()));
    }
    
    private function findAttrToConfigure($tag){
		return DefaultChladnickaConstruct::returnAssetTags()[$tag]["attr"];
    }
    
    private function findFileType($tag){
		return DefaultChladnickaConstruct::returnAssetTags()[$tag]["fileEnd"];
    }
    
    private function createAssetPath(){
		return $this->pathToAsset;
    }
    
    private function baseAssetPath(){
		return str_replace("\php\app\ChladnickaOnLine.php", "", __FILE__);
    }
}