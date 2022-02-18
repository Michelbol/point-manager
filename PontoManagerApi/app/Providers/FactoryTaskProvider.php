<?php

namespace App\Providers;

use App\Factory\HttpClientFactory;
use App\Services\Client\WebServiceClientInterface;
use App\Services\Client\WebServiceTaskClient;
use App\Services\TaskService;
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

        $this->app->when(TaskService::class)
            ->needs(WebServiceClientInterface::class)
            ->give(function(){
                return new WebServiceTaskClient(HttpClientFactory::createClient());
            });
    }
}
