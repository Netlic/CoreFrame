<?php

namespace framework\engine\components;

use framework\schemas\DbSchema;

class Db extends Component {

    public function __construct() {
	
    }

    public function createConnestions() {
	$conns = DbSchema::connections();
	foreach ($conns as $conn) {
	    
	}
    }

}
