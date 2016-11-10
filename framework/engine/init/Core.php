<?php

namespace framework\engine\init;
use framework\engine\client\convertors\ClientConvertor;

use app\schemas\{
    social\SocialNetworkSchema,
    route\RouteSchema
};
use framework\{
    init\Initializator,
    routing\RouteHandler
};
use framework\engine\{
    ChladnickaOnLine,
    helpers\HelperSet,
    guicontrols\GuiControlSet,
    socialNetworks\Facebook,
    socialNetworks\ThisApp
};
use framework\engine\containers\ClientContainer;

/**
 * Main class of this framework, almost everything is accessible 
 * via its static methods
 */
class Core {

    //private static $init;
    private static $social;
    private static $user;
    private static $engine;
    private static $loginSettings;
    private static $client;
    public static $document;
    public static $guiControl = GuiControlSet::class;
    public static $helper = HelperSet::class;

    public static function autoLoad() {
        spl_autoload_register(function ($class) {
            $file = $class . ".php";
            if (file_exists($file)) {
                require $file;
                return true;
            } else {
                error_log("Cannot autoload $file");
                return false;
            }
        });
    }

    private static function findRoute() {
        RouteHandler::findRoute();
    }

    private static function findSetMethod($method) {
        if ($method) {
            return HelperSet::Text()::capitalize(strtolower($method));
        }
        return null;
    }

    /**
     * Returns GuiControlClass, if $control parameter is not set
     * else returns GuiControl object
     * @param type $control is name of the particular GuiControl
     * @return type
     */
    public static function guiControl($control = null, array $options = null) {
        $controlToCreate = static::findSetMethod($control);
        if ($controlToCreate && method_exists(static::$guiControl, $controlToCreate)) {
            return call_user_func([static::$guiControl, $controlToCreate], $options);
        }
        return static::$guiControl;
    }

    //aby sa nemusela pouzivat dookola ta ista podmienka, tak pouzit anonymnu funkciu?
    public static function helper($helper = null) {
        $helperToGet = static::findSetMethod($helper);
        if ($helperToGet && method_exists(static::$helper, $helperToGet)) {
            return call_user_func([static::$helper, $helperToGet]);
        }
        return static::$helper;
    }

    public static function social() {
        return static::$social;
    }

    public static function engine() {
        return static::$engine;
    }
    
    public static function client(ClientConvertor $convertor = null): ClientConvertor {
        if ($convertor) {
            static::$client = $convertor;
        }
        if (!static::$client) {
            static::$client = ClientContainer::getConvertor();
        }
        return static::$client;
    }

    public static function start() {
        static::autoLoad();
        static::createPage();
    }

    public static function createPage() {
        static::setStatics();
        static::findRoute();
        $content = RouteHandler::redirect();
        if (!static::engine()->isAjax()) {
            static::engine()->addContent($content);
            static::$document->dom->appendHtml(RouteHandler::$controller->LoadLayout());
            echo static::$document->render(); //var_dump( error_get_last());
        } else {

            if (gettype($content) == "object" && get_class($content) == GuiControlSet::$guiLoader) {
                static::engine()->outputBuffer()->start();
                $content->render();
                $content = static::engine()->outputBuffer()->getClean();
            }
            echo $content;
        }
    }

    private static function setEngine() {
        static::$engine = static::$engine ?? new ChladnickaOnLine();
    }

    private static function setSocial() {
        if (!static::$user) {
            static::$social = SocialNetworkSchema::returnSocial(["typ" => "ThisApp", "typId" => "1"]);
        } else {
            $uDet = static::$user->getUserDetails();
            static::$loginSettings = ["typ" => reset($uDet)["prihlasenie"], "typId" => reset($uDet)["prihlId"]];
            static::$social = SocialNetworkSchema::returnSocial(static::$loginSettings);
        }
    }

    private static function setStatics() {
        static::setEngine();
        static::setSocial();
    }

}
