<?php
namespace app\interfaces;

interface partInterface {
    public function setPartArray();
    public function getInfoArray();
    public function saveAllParts(array $recipeDetails);
}
