<?php

namespace App\Factory;

use GuzzleHttp\Client;

interface HttpClientFactoryInterface
{
    public function createClient(): Client;
}
