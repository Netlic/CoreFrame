<?php

namespace app\controllers;

use framework\controllers\Controller;

class AppController extends Controller {

    public function write($write = "") {
        $toWrite = array_keys($write);
        return reset($toWrite);
    }

}
