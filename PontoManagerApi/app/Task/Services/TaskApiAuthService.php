<?php

namespace App\Task\Services;

use App\Task\Client\WebServiceClientInterface;
use App\Task\Requests\GetTaskByUserTaskRequest;
use App\Task\Responses\GetTaskByUserTaskListResponse;
use GuzzleHttp\Psr7\Response;

class TaskApiAuthService
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

    public function getTasksByUser(GetTaskByUserTaskRequest $request): GetTaskByUserTaskListResponse
    {
        $response = $this->getResponse(function () use ($request) {
            $method = $request->getMethod();
            return $this->client->$method(
                $request->generateUrl(),
                $request->generateQueryParams()
            );
        });
        return new GetTaskByUserTaskListResponse($response);
    }
}
