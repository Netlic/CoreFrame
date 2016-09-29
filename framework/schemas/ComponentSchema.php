<?php

namespace framework\schemas;

use framework\engine\components\{
    Request,
    Session,
    User,
    OutputBuffer
};

class ComponentSchema {

    public static function returnComponents() {
        return [
            "request" => Request::class,
            "user" => User::class,
            "session" => Session::class,
            "outputBuffer" => OutputBuffer::class
        ];
    }

}
