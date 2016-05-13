<?php

use app\schemas;

class DomSchema {
    public static $selector = ["." => "class","#" => "id","default" => "controlTag"];
    public static $guiEvents = ["default" => ["click"]];
    public static $clientIdent = ["id", "class", "name"];
    public static $guiControlList = ["form", "pagebody", "pageheader", "document"];
}
