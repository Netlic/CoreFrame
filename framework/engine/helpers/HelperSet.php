<?php

namespace framework\engine\helpers;

use framework\engine\helpers\{
    Html,
    Text,
    Url
};

class HelperSet {
    public static function Html() {
        return Html::class;
    }
    public static function Text() {
        return Text::class;
    }
    public static function Url() {
        return Url::class;
    }
}
