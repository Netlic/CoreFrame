<?php

namespace php\app\engine\guicontrols\dom;

use php\app\engine\guicontrols\GuiControl;
use php\app\schemas\DomSchema;
use php\app\interfaces\IDomFamily;

class Elements implements IDomFamily{
    
    private $startingElement;
    private $domSelector;
    private $findBy = [];
    
    public function __construct(/*GuiControl $element*/){
        //$this->startingElement = $element;
        $this->domSelector = DomSchema::$selector;
    }
    
    private function parseSelector($selector){
        if(strrpos($selector, "=") !== false){
            $exploded = explode("=",$selector);
            $this->findBy[reset($exploded)] = end($exploded); 
        }else{
            $firstChar = substr($selector, 0, 1);
            if(in_array($firstChar, array_keys($this->domSelector))){
                $this->findBy[$this->domSelector[$firstChar]] = substr($selector, -1*(strlen($selector) - 1));  
            }else{
                $this->findBy[$this->domSelector["default"]] = $selector;
            }
        }
    }
    
    private function recursive(GuiControl $related, $method, array &$findings){
        $e = new Elements($related);
        $e->setfindBy($this->findBy);
        $relArray = $e->$method();
        if(!empty($relArray)){
            $returnArray = array_merge($returnArray, $relArray);
        }
        $prop = reset(array_keys($this->findBy));
        if($child->$prop == end($this->findBy)){
            $returnArray[] = $child;
        }
    }
    
    /*
     * najde elementy spriaznene s aktualnym - bud potomkov alebo parenta
     */
    public function findRelatedElements($pattern, $particular = "children") : array {
        return $this->$particular();
    }
    
    public function children(){
        if($this->startingElement->hasControlChildren()){
            $returnArray = [];
            foreach($this->startingElement->controlChildren() as $child){
                $this->recursive($child, "children", $returnArray);
            }
            return $returnArray;
        }
        return [];
    }
    
    public function parents(){
        if($this->startingElement->hasControlParent()){
            $returnArray = [];
            $parent = $this->startingElement->controlParent();
            $this->recursive($parent, "parents", $returnArray);
            return $returnArray;
        }
        return [];
    }
    
    public function siblings(){
        $start = $this->startingElement;
        if($start->hasControlParent()){
            return $start->controlParents()->controlChildren();
        }
        return [];
    }
    
    public function setfindBy(array $findBy){
        $this->findBy = $findBy;
    }
}
