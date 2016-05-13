<?php
namespace framework\engine\guicontrols;

use framework\helpers\Html;
use framework\interfaces\IGuiControl;
use framework\engine\OverLoad;
use framework\engine\guicontrols\dom\{Elements, DomHandler};
use framework\engine\events\eventmodels\EventSet;
//use framework\engine\guicontrols\dom\DomHandler;

abstract class GuiControl extends OverLoad implements IGuiControl{
    
    /*
     * Pole atributov, ktorymi by mal html tag disponovat ("name","id"...)
     */
    protected $controlAttributes;
    /*
     * Pole html elementov, ktore by mali byt potomkami aktualneho elementu
     */
    protected $controls = [];
    protected $events = [];
    protected $html;
    /*
     * Element nadriadeny tomu aktualnemu (parent)
     */
    protected $controlParent;
    protected $eventModel;
    /*
     *  premmena obsahuje, text obsiahnuty v tagu
     */
    protected $text = "";
    /*
     * struktura DOM
     */
    public $dom;
    
    /*
     * Atribut reprezentujuci css class pre dany html element
     */
    public $class;
    /*
     * Tento atribut urcuje tag reprezentovany v HTML
     */
    public $controlTag;
    
    public function __construct(array $options = null){
        $this->html = Html::className();
        $this->setControlTag();
        $this->events = EventSet::instantiate($this->controlTag, $this);
        $this->dom = new DomHandler();
        if($options){
            $this->controlAttributes = $options;
        }
    }
    
    /*
     * Touto funkciou by mal kazdy potomok tejto triedy nastavit, aky tag bude reprezentovat
     */
    protected abstract function setControlTag();
    
    /*
     * prida atribut do reprezentovaneho tagu potom ako bola vytvorena instancia
     */
    public function addAttribute($attribute, $value){
        $this->controlAttributes[] = $attribute;
        $this->$attribute = $value;
    }
    
    /*
     * Prida potomka do aktualneho elementu
     */
    /*public function addChild(GuiControl $control, $index = null){
        $control->setParent($this);
        if($index){
            if(key_exists($index, $this->controls)){
                $this->controls[] = $this->controls[$index];
                $this->controls[$index] = $control;
            }else{
                $this->controls[$index] = $control; 
            }
        }
        $this->controls[] = $control;
    }
    
    /*
     * Najde potomka podla daneho vzorca(selektor ako jQuery) alebo vsetkych potomkov
     */
    /*public function controlChildren($pattern = null){
        if($pattern){
            $e = new Elements($this);
            $e->findRelatedElements($pattern);
        }
        return $this->controls;
    }
    
    /*
     * Najde predka podla daneho vzorca(selektor ako jQuery) alebo prveho predka
     */
    /*public function controlParents($pattern = null){
        if($pattern){
            $e = new Elements($this);
            $e->findRelatedElements($pattern,"parents");
        }
        return $this->controlParent;
    }
    
    /*
     * 
     */
    public function events() : EventSet{
        return $this->events;
    }
    
    /*
     * vrati atributy obsiahnute v tagu
     */
    public function getAttributes(){
        return $this->controlAttributes;
    }
    
    /*
     * vrati tag reprezentovany danou instanciou
     */
    public function getControlTag(){
        return $this->controlTag;
    }
    
    /*
     * vrati "true" alebo "false" v zavislosti ci ma dany element predka
     */
    public function hasControlParent(){
        return $this->controlParent ? true : false;
    }
    
     /*
     * vrati "true" alebo "false" v zavislosti ci ma dany element potomkov
     */
    public function hasControlChildren(){
        return !empty($this->controls);
    }
    
    /*
     * nastavi predka (parenta) danemu tagu
     */
    public function setParent(GuiControl $parent){
        $this->controlParent = $parent;
    }
    
    public function setEventModel(EventSet $eventSet){
        $this->events = $eventSet;
    }
    
    /*
     * vykresli dany element na stranku aj so vsetkymi jeho potomkami
     */
    public function render(){
        $content = "";
        foreach($this->dom->children() as $child){
            $content .= $child->render();
        };
        return Html::returnTag($this->controlTag, $this->text.$content, $this->controlAttributes);
    }
    
    public function text($text = null){
        if(!$text){
            return $this->text;
        }
        $this->text = $text;
    }
}
