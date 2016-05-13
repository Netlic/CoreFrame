<?php

use app\schemas;

class DefaultChladnickaConstruct {
    public static function returnMeta(){
		return [
			["http-equiv" => "X-UA-Compatible", "content" => "IE=edge"],
			["charset" => "utf-8"],
			["name" => "description", "content" => "Miesto, pre varenie"],
			/*["content" => "My awesome site", "property" => "og:title"],
			["content" => "sdfgsdfgdsfg sdf sgh fg hderherhterthe rh  hrthertherthert erthertherhrt hrth ertherthertherh", "property" => "og:description"],
			["content" => "http://localhost:8080/chladnicka_engine_xampp/index.php", "property" => "og:url"]*/
		];
    }
    public static function returnAssets(){
			return [
				"head" => [
					"css" => [
						["tagName" => "link", "rel" => "stylesheet", "typ" => "text/css", "href" => "bootstrap.min.css"],
						["tagName" => "link", "rel" => "stylesheet", "typ" => "text/css", "href" => "jquery.mCustomScrollbar"],
						["tagName" => "link", "rel" => "stylesheet", "typ" => "text/css", "href" => "external:https://fonts.googleapis.com/css?family=Poiret+One"],
						["tagName" => "link", "rel" => "stylesheet", "typ" => "text/css", "href" => "site"],
					],
					"js" => [
						["tagName" => "script", "src" => "jquery"],
						["tagName" => "script", "src" => "bootstrap.min"],
						["tagName" => "script", "src" => "plugins/richtext"],
						["tagName" => "script", "src" => "plugins/boxer"],
						["tagName" => "script", "src" => "plugins/window"],
						["tagName" => "script", "src" => "apis/facebook"],
						["tagName" => "script", "src" => "plugins/jquery.mCustomScrollbar.concat.min"],
						["tagName" => "script", "src" => "initFrontend"],
					]
				],
				"body" => [
					"js" => [
						/*["tagName" => "script", "src" => "okno"],
						["tagName" => "script", "src" => "modal_windows"],
						["tagName" => "script", "src" => "start"],
						["tagName" => "script", "src" => "part_handler"],*/
					]
				]
			];
    }
    
    public static function notParsingAttrs(){
		return ["tagName"];
    }
    
    public static function returnAssetTags(){
		return [
			"link" => ["attr" => "href", "fileEnd" => "css"], 
			"script" => ["attr" => "src", "fileEnd" => "js"]
		];
    }
    
    public static function returnLayout(){
		return "start";
    }
}
