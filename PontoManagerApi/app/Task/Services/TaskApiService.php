<?php

namespace App\Task\Services;

use App\Task\Client\WebServiceClientInterface;
use App\Task\Requests\AuthTaskRequest;
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
            $method = $request->getMethod();
            return $this->client->$method(
                $request->generateUrl(),
                $request->generateBody()
            );
        });
        return new TokenResponse($response);
    }
}
