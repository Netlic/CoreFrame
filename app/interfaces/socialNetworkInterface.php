<?php
namespace php\app\interfaces;

interface socialNetworkInterface {
    public function share();
    public function like();
    public function comment();
}
