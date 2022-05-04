<?php

namespace App\Factory;

use App\Models\User;
use GuzzleHttp\Client;

class HttpClientAuthFactory implements HttpClientFactoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createClient(): Client
    {
        return new Client([
            'base_uri' => config('task.url'),
            'headers' => [
                'Authorization' => "Bearer {$this->user->task_token}"
            ]
        ]);
    }
}
