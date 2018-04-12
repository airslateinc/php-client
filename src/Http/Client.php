<?php

namespace AirSlate\ApiClient\Http;

class Client extends \GuzzleHttp\Client
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}
