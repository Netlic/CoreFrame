<?php

namespace app\interfaces;

interface IDomFamily{
    public function children();
    public function parents();
    public function siblings();
}