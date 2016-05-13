<?php
namespace app\schemas;

use framework\socialNetworks\SocialNetwork;
use framework\helpers\Text;

class SocialNetworkSchema {
    public static function returnSocial(array $type){
		$social = Text::capitalize($type["typ"]);
		return SocialNetwork::createSocial($social, $type);
    }
}
