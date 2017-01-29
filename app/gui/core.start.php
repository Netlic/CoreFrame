<?php

$div = $_cf::_('div', ["class" => "welcome-text text-center"]);
$div->append(
        $_cf::_('div')->append($_cf::_('strong')->text("Core Frame"))
);

$roundDiv = $_cf::_('div', ["class" => "round-center"]);
$innerBorder = $_cf::_('div', ["class" => "inner-round-border-on"]);
$f = $_cf::_('div', ["class" => "letter-f"]);
$c = $_cf::_('div', ["class" => "letter-c"]);
$cfDiv = $_cf::_('div', ["class" => "letters text-center col-lg-8"])->append($c)->append($f);
$div->append($roundDiv->append($innerBorder->append($cfDiv)));


/* $tButton = $_cf::guiControl('button', ["type" => "button"]);
  $div->dom->append($tButton);
  $tButton->events()->click(function() use ($_cf) {
  $_cf::client()->console()::log("bu");
  $_cf::client()->alert('Ono to žije!');
  $_cf::_('this');
  })->text("TU KLIKNI"); */
return $div;
