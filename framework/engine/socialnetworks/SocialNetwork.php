<?php

namespace framework\engine\socialnetworks;

use app\interfaces\socialNetworkInterface;
use framework\engine\helpers\Html;

class SocialNetwork implements socialNetworkInterface {

    protected $id;
    protected $name;
    protected $element = [];

    public function __construct() {
        
    }

    public function comment() {
        
    }

    public function like() {
        $method = explode("::", __METHOD__);
        $shareElement = $this->element[end($method)];
        Html::tag($shareElement["tag"], null, $shareElement["options"]);
    }

    public function share() {
        $method = explode("::", __METHOD__);
        $shareElement = $this->element[end($method)];
        Html::tag($shareElement["tag"], null, $shareElement["options"]);
    }

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->name;
    }

    public static function usedClass() {
        return get_called_class();
    }

    public static function createSocial($network, array $initParams) {
        $social = str_replace("SocialNetwork", $network, static::usedClass());
        return new $social($initParams);
    }

    public function getElement() {
        return $this->element;
    }

}
