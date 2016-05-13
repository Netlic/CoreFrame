<?php
namespace app\schemas;

use app\socialNetworks\SocialNetwork;
use helpers\Text;

class SocialNetworkSchema {
    public static function returnSocial(array $type){
		$social = Text::capitalize($type["typ"]);
		return SocialNetwork::createSocial($social, $type);
    }
}
