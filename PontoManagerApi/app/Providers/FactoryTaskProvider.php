<?php

namespace App\Providers;

use App\Factory\HttpClientAuthFactory;
use App\Factory\HttpClientFactory;
use App\Task\Client\WebServiceClientInterface;
use App\Task\Client\WebServiceTaskAuthClient;
use App\Task\Client\WebServiceTaskClient;
use App\Task\Services\TaskApiAuthService;
use App\Task\Services\TaskApiService;
use Illuminate\Support\ServiceProvider;

class FactoryTaskProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->when(TaskApiService::class)
            ->needs(WebServiceClientInterface::class)
            ->give(function(){
                return new WebServiceTaskClient((new HttpClientFactory())->createClient());
            });

        $this->app->when(TaskApiAuthService::class)
            ->needs(WebServiceClientInterface::class)
            ->give(function(){
                return new WebServiceTaskAuthClient(
                    (new HttpClientAuthFactory(\Auth::user()))
                        ->createClient()
                );
            });
    }
}
