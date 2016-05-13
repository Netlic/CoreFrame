<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
require 'php/app/init/ScriptLoader.php';
use php\app\init\{ScriptLoader, ChS};

ScriptLoader::AutoLoad();
ChS::start();
/*$form = ChS::$guiControl::Form();
echo $form->render();*/