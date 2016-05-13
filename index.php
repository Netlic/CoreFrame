<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
require 'framework/init/ScriptLoader.php';
use framework\init\{ScriptLoader, Core};

ScriptLoader::AutoLoad();
Core::start();
/*$form = ChS::$guiControl::Form();
echo $form->render();*/