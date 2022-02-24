<?php

namespace App\Task\Services;

use App\Http\Controllers\Requests\AuthTaskRequest;
use App\Task\Client\WebServiceClientInterface;
use App\Task\Responses\TokenResponse;
use GuzzleHttp\Psr7\Response;

class TaskApiService
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

    public function auth(AuthTaskRequest $request): TokenResponse
    {
        $response = $this->getResponse(function () use ($request) {
            return $this->client->post(
                $request->generateUrl(),
                $request->createRequestBody()
            );
        });
        return new TokenResponse($response);
    }
}
