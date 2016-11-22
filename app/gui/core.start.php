<?php

$div = $_cf::guiControl('div', ["class" => "welcome-text text-center"]);
$div->dom->append(
        $_cf::guiControl('div')->dom->append($_cf::guiControl('strong')->text("Core Frame "))
                ->append($_cf::guiControl('span')->text('("Chladnička Engine")'))->control());
$tButton = $_cf::guiControl('button', ["type" => "button"]);
$div->dom->append($tButton);
$tButton->events()->click(function() use ($_cf) {
    $_cf::client()->console()::log("bu");
    $_cf::client()->alert('Ono to žije!');
    $_cf::_('this');
})->text("TU KLIKNI");
return $div;
