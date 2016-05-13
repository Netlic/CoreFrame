<?php
namespace app\engine\components;

class Request extends Component{
    private $post;
    private $get;
    public function __construct(){
		$this->post = filter_input_array(INPUT_POST) ?? [];
		$this->get = filter_input_array(INPUT_GET) ?? [];
    }
    
    public function post($key = null){
		return $this->post[$key] ?? $this->post;
    }
    
    public function get($key = null){
		return $this->get[$key] ?? $this->get;
    }
}
