<?php

namespace App\Factory;

use GuzzleHttp\Client;

class HttpClientFactory implements HttpClientFactoryInterface
{
    public function createClient(): Client
    {
        return new Client([
            'base_uri' => config('task.url')
        ]);
    }
}
