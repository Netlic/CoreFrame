<?php
namespace app\interfaces;

interface IChladnickaEngine {
    public function createDefaultTags($type);
    public function createHeader();
    public function createBody();
   // public function createSkelet();
    public function addMeta(array $meta);
    public function addMultipleMeta(array $metas);
    public function addAsset($assetName, $where, $tagName);
    public function addMultipleAsset(array $assets);
    public function addViewScriptFile($scriptFile);
}
