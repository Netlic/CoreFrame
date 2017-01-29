<?php

namespace framework\engine\guicontrols;

use framework\engine\helpers\Html;
use framework\interfaces\IGuiControl;
use framework\interfaces\elementsinterface\IjQueryDomHandler;
use framework\engine\OverLoad;
use framework\engine\guicontrols\dom\{
    Elements,
    DomHandler
};
use framework\engine\events\eventmodels\EventSet;
use framework\schemas\{
    DomHandlerSchema,
    DomSchema
};

abstract class GuiControl extends OverLoad implements IGuiControl, IjQueryDomHandler {
    /**
     * array containing set of attributes from html element
     * @var array 
     */
    protected $controlAttributes;
    /**
     * list of child html elements
     * @var array 
     */
    protected $controls = [];
    protected $events = [];
    protected $html;
    protected $eventModel;
    /**
     * element content
     * @var string 
     */
    protected $text = "";
    /**
     * DOM structure
     * @var type 
     */
    public $dom;
    /*
     * Atribut reprezentujuci css class pre dany html element
     */
    public $class;
    /**
     * tag representing html element
     */
    public $controlTag;

    public function __construct(array $options = null) {
        $this->html = Html::class;
        $this->setControlTag();
        $this->events = EventSet::instantiate($this->controlTag, $this);
        $this->dom = new DomHandler($this);
        $this->controlAttributes = $options;
    }
    /**
     * method to set controll tag
     */
    protected abstract function setControlTag();
    /**
     * 
     * @param type $content
     * @return type
     */
    protected function prepareHtml($content) {
        $tag = $this->controlTag;
        $cntnt = $this->text . $content;
        $attrs = $this->controlAttributes;
        return Html::returnTag($tag, $cntnt, $attrs) . $this->dom->htmlToRender;
    }
    /**
     * adds attribute to element
     * @param type $attribute - attribute to add
     * @param type $value - value of attribute
     */
    public function addAttribute($attribute, $value) {
        $this->controlAttributes[] = $attribute;
        $this->$attribute = $value;
    }

    /*
     * zoznam eventov(udalosti), definovanych pre dany gui control - eventset
     */

    public function events(): EventSet {
        return $this->events;
    }

    /*
     * vrati atributy obsiahnute v tagu
     */

    public function getAttributes() {
        return $this->controlAttributes ?? [];
    }

    /*
     * vrati tag reprezentovany danou instanciou
     */

    public function getControlTag() {
        return $this->controlTag;
    }

    public function setEventModel(EventSet $eventSet) {
        $this->events = $eventSet;
    }

    /*
     * vykresli dany element na stranku aj so vsetkymi jeho potomkami
     */

    public function render() {
        $content = "";
        foreach ($this->dom->children() as $child) {
            $content .= $child->render();
        }
        return $this->prepareHtml($content);
    }

    public function text($text = null) {
        if (!$text) {
            return $this->text;
        }
        $this->text = $text;
        return $this;
    }

    public function after(GuiControl $control) {
        $this->dom->after($control);
        return $this;
    }

    public function append(GuiControl $control, $index = null) {
        $this->dom->append($control, $index);
        return $this;
    }

    public function before() {
        $this->dom->before();
        return $this;
    }

    public function children() {
        return $this->dom->children();
    }

    public function find($pattern) {
        return $this->dom->find($pattern);
    }

    public function parents() {
        return $this->dom->parents();
    }

}
