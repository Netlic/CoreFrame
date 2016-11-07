<?php

namespace interfaces\cache;

interface ICache {
    public function add($key, $value);
    public function get($key);
    public function delete($key);
    public function set($key, $value);
}
