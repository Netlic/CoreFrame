<?php
namespace app\engine;

class Overload {
    protected $overloadedAttrs = [];

    /**  Overloading not used on declared properties.  */
    public $declared = 1;

    /**  Overloading only used on this when accessed outside the class.  */
    private $hidden = 2;

    public function __set($name, $value){
        $this->overloadedAttrs[$name] = $value;
    }

    public function __get($name){
        //echo "Getting '$name'\n";
        if (array_key_exists($name, $this->overloadedAttrs)) {
            return $this->overloadedAttrs[$name];
        }

        /*$trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);*/
        return null;
    }

    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        //echo "Is '$name' set?\n";
        return isset($this->overloadedAttrs[$name]);
    }

    /**  As of PHP 5.1.0  */
    public function __unset($name)
    {
        //echo "Unsetting '$name'\n";
        unset($this->overloadedAttrs[$name]);
    }
}
