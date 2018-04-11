<?php

namespace AirSlate\UsersManagement\Http;

class Client extends \GuzzleHttp\Client
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}
