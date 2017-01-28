<?php

namespace framework\engine\init;

use framework\engine\client\convertors\ClientConvertor;
use app\schemas\{
    social\SocialNetworkSchema
};
use framework\{
    routing\Route
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

    /**
     * autoload function
     */
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

    /**
     * Returns client parser
     * @param ClientConvertor $convertor
     * @return ClientConvertorreturn
     */
    public static function client(ClientConvertor $convertor = null): ClientConvertor {
        if ($convertor) {
            static::$client = $convertor;
        }
        if (!static::$client) {
            static::$client = ClientContainer::getConvertor();
        }
        return static::$client;
    }

    /**
     * staic method to render page
     */
    public static function start() {
        static::autoLoad();
        static::setStatics();
        static::createPage();
    }

    /**
     * Dispatches anonymouse function (action)
     * @param callable $function
     * @return type
     */
    public static function dispatch(callable $function) {
        return call_user_func($function);
    }

    public static function createPage() {
        $route = new Route();
        $html = $route->instantiateController()->LoadLayout() . static::dispatch($route->getFunction());
        static::$document->dom->appendHtml($html);
        ob_start();
        echo static::$document->render();
        echo ob_get_clean();
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

    public static function _() {
        
    }

}
