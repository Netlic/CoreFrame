<?php

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
require 'framework/engine/init/Core.php';

use framework\engine\init\Core;

Core::start();