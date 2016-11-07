<?php

namespace framework\engine\guicontrols\dom;

use framework\interfaces\elementsinterface\IjQueryDomHandler;
use framework\engine\guicontrols\GuiControl;
use framework\engine\guicontrols\dom\Elements;
use framework\schemas\DomSchema;

class DomHandler implements IjQueryDomHandler {

    /**
     * Current dom element
     * @var type GuiControl
     */
    private $curControl;
    private $domElements = [];
    private $domParent;
    private $elementsObj;
    private $curDescendant;
    /*
     * potomkovia s danymi ordinalmi
     */
    private $descendantsByOrdinals;
    public $htmlToRender;
    public $ordinals;

    public function __construct(GuiControl $currentControl) {
        $this->elementsObj = new Elements();
        $this->curControl = $currentControl;
    }

    private function directOrdinal() {
        foreach (end($this->domElements)->dom->ordinals as $ordinal) {
            $this->addDescendants($this->curControl, $ordinal);
        }
    }

    private function setDescentdants($ordinalName, $string) {
        $lastChild = end($this->domElements);
        $lastChild->dom->ordinals[$ordinalName] = $string; //implode("", unpack('C*', $string));
        $this->addDescendants($this->curControl, $lastChild->dom->ordinals[$ordinalName]);
    }

    private function updateDomStructure(GuiControl $control = null) {
        if (!$control->dom->ordinals) {
            if (!$control) {
                $control = $this->curControl;
            }
            $this->setDescentdants("tagName", $control->controlTag);
            $attributes = $control->getAttributes();
            $ordinalMap = array_intersect(array_keys($attributes), DomSchema::$findElementByAttributes);
            foreach ($ordinalMap as $attr) {
                $selector = DomSchema::returnSelectorByAttribute($attr);
                $this->setDescentdants($attr, $selector . $attributes[$attr]);
            }
        } else {
            $this->directOrdinal();
        }
    }

    public function addDescendants(GuiControl $control, $key) {
        $dom = $control->dom;
        $dom->addOrdinalDescendant($key);
        $parent = $control->dom->parents();
        if ($parent) {
            $this->addDescendants($parent, $key);
        }
    }

    public function addOrdinalDescendant($key) {
        $this->descendantsByOrdinals[$key][] = $this->curDescendant;
    }

    public function after(GuiControl $control) {
        $this->parents()->dom->append($control);
        return $this;
    }

    public function append(GuiControl $control, $index = null) {
        $control->dom->setParent($this->curControl);
        $this->domElements[] = $control;
        $this->curDescendant = $control;
        $this->updateDomStructure($control);
        return $this;
    }

    public function appendHtml($html) {
        if (gettype($html) == "string") {
            $this->htmlToRender = $html;
        } else {
            $this->append($html);
        }
        return $this;
    }

    public function before() {
        return $this;
    }

    public function children() {
        return $this->domElements;
    }

    public function find($pattern) {
        $ordinalToFind = $pattern;
        $findings = $this->descendantsByOrdinals[$ordinalToFind] ?? $this->curControl;
        $domElements = new DomContainerHandler($findings);
        return $domElements->single ?? $domElements;
    }

    public function parents() {
        return $this->domParent;
    }

    public function setParent(GuiControl $parent) {
        $this->domParent = $parent;
    }

    public function control() {
        return $this->curControl;
    }

}
