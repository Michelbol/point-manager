<?php

namespace App\Factory;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class HttpClientAuthFactory implements HttpClientFactoryInterface
{
    public static function createClient(): Client
    {
        $user = Auth::user();
        return new Client([
            'base_uri' => config('task.url'),
            'headers' => [
                'Authorization' => "Bearer $user->task_token"
            ]
        ]);
    }
}
