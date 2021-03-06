<?php

namespace framework\engine\socialnetworks;

use framework\engine\socialnetworks\SocialNetwork;

class Facebook extends SocialNetwork {

    public function __construct(array $type) {
        $this->id = $type["typId"];
        $this->typ = $type["typ"];
        $this->element = [
            "share" => [
                "tag" => "div",
                "options" => [
                    "class" => "fb-share-button",
                    "data-layout" => "button_count",
                    "data-href" => "http://localhost:8080/chladnicka_engine_xampp/"
                ]
            ],
            "like" => [
                "tag" => "div",
                "options" => [
                    "class" => "fb-like",
                    /* "data-href" => "http://google.com", */
                    "data-layout" => "button",
                    "data-action" => "like",
                    "data-show-faces" => "true"
                ]
            ]
        ];
        parent::__construct();
    }

}
