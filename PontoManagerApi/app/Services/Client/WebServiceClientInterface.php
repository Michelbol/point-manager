<?php


namespace App\Services\Client;


interface WebServiceClientInterface
{
    public function get(string $endpoint, array $queryParams = []);

    public function post(string $endpoint, array $formParams);

    public function put(string $endpoint, $formParams);

    public function delete(string $endpoint);
}
