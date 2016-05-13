<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
require 'framework/init/Core.php';
use framework\init\Core;

Core::start();