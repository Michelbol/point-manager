<?php

namespace App\Task\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class WebServiceClientAbstract implements WebServiceClientInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $endpoint
     * @param array $queryParams
     *
     * @return ResponseInterface
     * @throws RequestException
     */
    public function get(string $endpoint, array $queryParams = []): ResponseInterface
    {
        return $this->client->get($endpoint, [
            'query' => $queryParams,
        ]);
    }

    /**
     * @param string $endpoint
     * @param array $formParams
     *
     * @return ResponseInterface
     * @throws RequestException
     */
    public function post(string $endpoint,  array $formParams, $contentType = 'form_params'): ResponseInterface
    {
        return $this->client->post($endpoint, [
            $contentType => $formParams
        ]);
    }

    /**
     * @param string $endpoint
     * @param array $formParams
     *
     * @return ResponseInterface
     * @throws RequestException
     */
    public function put(string $endpoint, $formParams, $contentType = 'form_params'): ResponseInterface
    {
        return $this->client->put($endpoint, [
            $contentType => $formParams,
        ]);
    }

    /**
     * @param string $endpoint
     *
     * @return ResponseInterface
     * @throws RequestException
     */
    public function delete(string $endpoint): ResponseInterface
    {
        return $this->client->delete($endpoint);
    }
}
