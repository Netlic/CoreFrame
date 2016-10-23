<?php

namespace framework\engine\components;

use interfaces\cache\ICache;
use schemas\cache\CacheSchema;

class Cache implements ICache {

    private $cacheObj;

    public function __construct($cache = "session") {
        $this->cacheObj = CacheSchema::returnCacheObj($cache);
    }

    public function add($key, $value) {
        $this->cacheObj->add($key, $value);
    }

    public function delete($key) {
        $this->cacheObj->delete($key);
    }

    public function get($key) {
        return $this->cacheObj->get($key);
    }

    public function set($key, $value) {
        $this->cacheObj->set($key, $value);
    }

}
