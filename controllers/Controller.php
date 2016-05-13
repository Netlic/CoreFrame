<?php
namespace controllers;

use app\schemas\DefaultChladnickaConstruct;

class Controller {
    private $masterDir;
    protected $dir = "";
    
    public function __construct() {
		$this->masterDir = str_replace("controllers","",__DIR__);
    }
    
    protected function loadView(){
		$script = $this->masterDir."gui\\".$this->dir.str_replace(".php", "", func_get_args()[0]).".php";
		foreach(func_get_args()[1] as $index => $arg){
			 $$index = $arg;
		}
		ob_start();
		include $script;
		return ob_get_clean();
    }
    
    public function checkDbErrors(){
		$PDOErrors = "";
		foreach(func_get_args() as $arg){
			if(get_class($arg) != "\PDO" || get_class($arg) != "\PDOStatement"){
			$PDOErrors .= $arg->errorInfo()[2]." ";
			}
		}
		if(strlen(trim($PDOErrors)) > 0){
			error_log($PDOErrors);
			return true;
		}
		return false;
    }
    
    public function getClass(){
		return get_called_class();
    }
    
    public function loadLayout(){
		$layOut = DefaultChladnickaConstruct::returnLayout();
		return $this->loadView($layOut,[]);
    }
}
