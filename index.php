<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
require 'app/init/ScriptLoader.php';
use app\init\{ScriptLoader, ChS};

ScriptLoader::AutoLoad();
ChS::start();
/*$form = ChS::$guiControl::Form();
echo $form->render();*/