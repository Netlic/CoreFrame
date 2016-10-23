<?php

namespace schemas\cache;

class CacheSchema {

    public static function cacheList() {
        return array(
            "session" => \cache\Session::called()
        );
    }

    public static function returnCacheObj($cache) {
        $list = static::cacheList();
        return array_key_exists($cache, $list) ? new $list[$cache]() : NULL;
    }

}
