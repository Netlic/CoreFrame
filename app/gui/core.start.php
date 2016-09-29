<?php

use framework\engine\init\Core;

$div = Core::guiControl('div', ["class" => "welcome-text text-center"]);
$div->dom->append(
        Core::guiControl('div')->dom->append(Core::guiControl('strong')->text("Core Frame "))
                ->append(Core::guiControl('span')->text('("Chladnička Engine")'))->control());

return $div;
