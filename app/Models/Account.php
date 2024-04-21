<?php

namespace App\Models;

class Account
{
    public $name;
    public $website;
    public $phone;

    public function __construct($accName, $accSite, $accPhone)
    {
        $this->name = $accName;
        $this->website = $accSite;
        $this->phone = $accPhone;
    }
}
