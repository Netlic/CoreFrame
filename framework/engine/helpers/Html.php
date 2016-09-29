<?php

namespace framework\engine\helpers;

use framework\engine\helpers\tags\tag;

class Html {

    /*public static function className() {
        return get_called_class();
    }*/

    public static function encode($content) {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true);
    }

    public static function div() {
        
    }

    public static function tag($tag, $content = null, array $options = null) {
        echo static::returnTag($tag, $content, $options, $tagElem);
        return $tagElem;
    }

    public static function returnTag($tag, $content = null, array $options = null, &$tagElem = null) {
        $tagObj = (new class($tag, $options) extends tag {

                    public
                            function __construct($tag, $options = null) {
                        $this->tag = $tag;
                        parent::__construct($options);
                    }
                });
        if ($tagElem) {
            $tagElem = $tagObj;
        }
        return $tagObj->create($content);
    }

}
