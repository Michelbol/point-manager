<?php

namespace App\Task\Services;

use App\Task\Client\WebServiceClientInterface;
use App\Task\Requests\FindTaskByIdAndIdProjectRequest;
use App\Task\Requests\GetTaskByUserTaskRequest;
use App\Task\Responses\FindTaskByIdAndIdProjectResponse;
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

    public function findTask(FindTaskByIdAndIdProjectRequest $request): FindTaskByIdAndIdProjectResponse
    {
        $response = $this->getResponse(function () use ($request) {
            $method = $request->getMethod();
            return $this->client->$method(
                $request->generateUrl(),
                $request->generateQueryParams()
            );
        });
        return new FindTaskByIdAndIdProjectResponse($response['data']);
    }
}
