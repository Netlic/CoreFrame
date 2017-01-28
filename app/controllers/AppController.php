<?php

namespace app\controllers;

use framework\controllers\Controller;

class AppController extends Controller {

    public function write($write = "") {
        return reset(array_keys($write));
    }

}
