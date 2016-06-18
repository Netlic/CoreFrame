<?php

namespace framework\engine\guicontrols;

use framework\schemas\DomSchema;
use framework\helpers\Text;

use framework\engine\guicontrols\{Link, Title, Form, Meta, Script, GuiControl};
use framework\engine\guicontrols\vital\{PageBody, PageHeader, Document};

class GuiControlSet{
    const DOCUMENT = 'Document';
    const FORM = 'Form';
    const PAGEHEADER = 'PageHeader';
    const PAGEBODY = 'PageBody';
    
    private static $options;
    
    public static $guiControl = GuiControl::class;
    
    public static function Form(array $options = null){
        return new Form($options);
    }
    
    public static function Document(array $options = null){
        return new Document($options);
    }
    
    public static function PageHeader(array $options = null){
        return new PageHeader($options);
    }
    
    public static function PageBody(array $options = null){
        return new PageBody($options);
    }
    
    public static function Title(array $options = null){
        return new Title($options);
    }
    
    public static function Link(array $options = null){
        return new Link($options);
    }
    
    public static function Meta(array $options = null){
        return new Meta($options);
    }
    
    public static function Script(array $options = null){
        return new Script($options);
    }
    
    public static function createGuiControl($guiControl, array $options = null){
        $guiList = DomSchema::$guiControlList;
        static::$options = $options;
        if(in_array(Text::lowerCase($guiControl),$guiList)){
            $guiControl = Text::capitalize(Text::lowerCase($guiControl));
            return call_user_func([get_called_class(), $guiControl]);
        }
        return null;
    }
}