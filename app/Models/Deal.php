<?php

namespace App\Models;

class Deal
{
    public $name;
    public $stage;

    public function __construct($dealName, $stage)
    {
        $this->name = $dealName;
        $this->stage = $stage;
    }
}
