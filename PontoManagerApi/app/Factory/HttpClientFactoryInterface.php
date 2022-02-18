<?php

namespace App\Factory;

use GuzzleHttp\Client;

interface HttpClientFactoryInterface
{
    static function createClient(): Client;
}
