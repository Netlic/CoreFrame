<?php

namespace framework\engine\helpers\tags;

class tag {

    protected $tag;
    protected $pairTag = ["div", "table", "tr", "td", "th", "span", "head", "title", "html", "script", "body", "form", "strong", "button", "svg", "text"];
    protected $tagOptions;
    protected $isPair;

    public function __construct(array $options = null, $pair = false) {
        if ($options) {
            $this->parseTagOptions($options);
        }
        $this->isPair = in_array($this->tag, $this->pairTag) ? $this->tag : $pair;
    }

    private function parseTagOptions(array $tagOptions) {
        foreach ($tagOptions as $option => $optValue) {
            $this->tagOptions .= $option . '="' . $optValue . '"';
        }
    }

    public function create($content = null, tag $innerHtml = null) {
        return "<" . $this->tag . " " . $this->tagOptions . $this->endElement($content, $innerHtml);
    }

    private function endElement($content = null, tag $innerHtml = null) {
        return $this->isPair ? '>' . $content . '</' . $this->tag . '>' : '/>';
    }

}
