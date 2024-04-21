<?php

namespace App\ValueObjects;

class ZohoCredentials
{
    public $access_token;
    public $refresh_token;
    public $expires;

    public function __construct($access_token, $refresh_token, $expires)
    {
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->expires = $expires;
    }
}
