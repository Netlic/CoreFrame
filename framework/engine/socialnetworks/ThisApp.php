<?php

namespace framework\engine\socialnetworks;

use framework\engine\socialnetworks\SocialNetwork;

class ThisApp extends SocialNetwork {

    public function __construct(array $type) {
        $this->id = $type["typId"];
        $this->typ = $type["typ"];
        $fb = new Facebook($type);
        $this->element = $fb->getElement();
        parent::__construct();
    }

}
