<?php
use app\dataReflect;

use app\init\ChladnickaSettings;

abstract class DataReflect {
    private static $st;
    
    protected $dbTypes = ["integer" => 1, "string" => 2];
    protected $saveProcedure = "";
    protected $data = [];
    protected $dataToSave = [];
    protected $procParams;
    protected $orderParams;
    
    protected abstract function isValidReflect();
    
    private function bindValues(\PDOStatement $st){
	$i = 1;
	foreach($this->orderParams as $param){
	    $value = $this->dataToSave[$param] ?? null;
	    $type = $this->dbTypes[gettype($value)] ?? 0;
	    $st->bindParam($i, $this->dataToSave[$param], $type);
	    $i++;
	}
    }
    
    public function save(){
	if($this->isValidReflect()){
	    $db = ChladnickaSettings::init()->getDb();
	    $st = $db->prepare("call ".$this->saveProcedure."(".$this->procParams.")");
	    $this->bindValues($st);
	    $st->execute();
	    if($this->checkDbErrors($db, $st)){
		echo "dbError";
	    }
	}
    }
    
    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        //echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        /*$trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);*/
        return null;
    }

    public function __isset($name){
        //echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    public function __unset($name){
        //echo "Unsetting '$name'\n";
        unset($this->data[$name]);
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
}
