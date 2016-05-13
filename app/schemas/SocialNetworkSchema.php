<?php
namespace app\schemas;

use php\app\socialNetworks\SocialNetwork;
use php\helpers\Text;

class SocialNetworkSchema {
    public static function returnSocial(array $type){
		$social = Text::capitalize($type["typ"]);
		return SocialNetwork::createSocial($social, $type);
    }
}
