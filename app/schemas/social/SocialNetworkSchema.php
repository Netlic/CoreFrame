<?php

namespace app\schemas\social;

use framework\engine\socialNetworks\SocialNetwork;
use framework\engine\helpers\Text;

class SocialNetworkSchema {

    public static function returnSocial(array $type) {
        $social = Text::capitalize($type["typ"]);
        return SocialNetwork::createSocial($social, $type);
    }

}
