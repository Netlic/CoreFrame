<?php
namespace framework\app\init;

use app\entity\User;
/**
 * Description of DbInitializator
 * inicializuje databazu
 * @author Netlic
 */
class Initializator {
    private $sql;
    private $userName;
    private $sessionId;
    public function __construct() {
		//$this->sql = new \PDO('mysql:dbname=chladnickadb;charset=utf8;host=127.0.0.1','root','adlm582@');
		$this->setSession();	
    }
    
    public function getDb(){
		return $this->sql;
    }
    
    private function setSession(){
		session_set_cookie_params(0);
		session_start();
		$this->sessionId = session_id();
		if(!isset($_SESSION[$this->sessionId])){
			$_SESSION[$this->sessionId] = null;
		}else{
			$this->authenticated(["usr_txt_n" => $_SESSION[$this->sessionId]]);
		}
	
    }
    
    public function authenticated(array $data){
		$this->userName = $this->checkUserName($data);
		if($this->userName && !$_SESSION[$this->sessionId]){
			$_SESSION[$this->sessionId] = $this->userName;
			setcookie("user", $this->userName);
			setcookie("logins", $this->checkSource($data));
			header('Location: index.php');
		}
    }
    
    private function checkUserName(array $data){
		return key_exists("usr_txt_n", $data) === true ? $data["usr_txt_n"] : null;
    }
    
    private function checkSource(array $data){
		return key_exists("source", $data) === true ? $data["source"] : "app";
    }
    
    public function getUser(){
		$user = new User($this->userName/*, $this->sql*/);
		return $this->userName ? $user : null;
    }
    
    public function findError(){
		if($this->sql->errorCode()){
		    return "{Stav} - ".$this->sql->errorInfo()[0]." {Code} - ".$this->sql->errorInfo()[1]." {Správa} - ".$this->sql->errorInfo()[2];
		}
		return null;
    }
    
    public static function checkUser($user){
		$class = User::getClassName();
		return $user instanceof $class;
    }
}