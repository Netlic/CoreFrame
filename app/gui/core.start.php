<?php

use framework\engine\init\Core;

$div = Core::guiControl('div', ["class" => "welcome-text text-center"]);
$div->dom->append(
        Core::guiControl('div')->dom->append(Core::guiControl('strong')->text("Core Frame "))
                ->append(Core::guiControl('span')->text('("Chladnička Engine")'))->control());
$form = Core::guiControl('form');
$div->dom->append($form);
$form->events()->click(function() {
    Core::client()->console()::log("bu");
    Core::client()->alert('Ono to žije!');
});
return $div;
