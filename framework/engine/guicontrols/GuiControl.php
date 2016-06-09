<?php
namespace framework\engine\guicontrols;

use framework\helpers\Html;
use framework\interfaces\IGuiControl;
use framework\engine\OverLoad;
use framework\engine\guicontrols\dom\{Elements, DomHandler};
use framework\engine\events\eventmodels\EventSet;
use framework\schemas\{DomHandlerSchema, DomSchema};

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
    //protected $controlParent;
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
        $this->dom = new DomHandler($this);
        $this->controlAttributes = $options;
    }
    
    /*
     * Touto funkciou by mal kazdy potomok tejto triedy nastavit, aky tag bude reprezentovat
     */
    protected abstract function setControlTag();
    
    protected function prepareHtml($content){
        $tag = $this->controlTag;
        $cntnt = $this->text.$content;
        $attrs = $this->controlAttributes;
        return Html::returnTag($tag, $cntnt, $attrs).$this->dom->htmlToRender;
    }
    /*
     * prida atribut do reprezentovaneho tagu potom ako bola vytvorena instancia
     */
    public function addAttribute($attribute, $value){
        $this->controlAttributes[] = $attribute;
        $this->$attribute = $value;
    }
    
    /*
     * zoznam eventov(udalosti), definovanych pre dany gui control - eventset
     */
    public function events() : EventSet{
        return $this->events;
    }
    
    /*
     * vrati atributy obsiahnute v tagu
     */
    public function getAttributes(){
        return $this->controlAttributes ?? [];
    }
    
    /*
     * vrati tag reprezentovany danou instanciou
     */
    public function getControlTag(){
        return $this->controlTag;
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
        return $this->prepareHtml($content);
    }
    
    public function text($text = null){
        if(!$text){
            return $this->text;
        }
        $this->text = $text;
        return $this;
    }
}