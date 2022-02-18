<?php

namespace App\Services;

use App\Http\Controllers\Requests\AuthTaskRequest;
use App\Services\Client\WebServiceClientInterface;
use GuzzleHttp\Psr7\Response;

class TaskService
{
    protected $client;

    public function __construct(WebServiceClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * get response
     *
     * @param Callable $callback
     * @param string $type
     * @return array
     */
    protected function getResponse(Callable $callback): array {
        /** @var Response */
        $response = $callback();

        return [
            'code' => $response->getStatusCode(),
            'data' => json_decode($response->getBody()->getContents(), true),
        ];
    }

    public function auth(AuthTaskRequest $request)
    {
        $response = $this->getResponse(function () use ($request) {
            return $this->client->post(
                $request->generateUrl(),
                $request->createRequestBody()
            );
        });
        return $response;
    }
}
