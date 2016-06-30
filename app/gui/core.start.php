<?php 
use framework\init\Core;

$div = Core::$guiControl::Div(["class" => "welcome-text text-center"]);
$div->dom->append(
    Core::$guiControl::Div()->dom->append(Core::$guiControl::Strong()->text("Core Frame "))
        ->append(Core::$guiControl::Span()->text('("Chladnička Engine")'))->control());

return $div;