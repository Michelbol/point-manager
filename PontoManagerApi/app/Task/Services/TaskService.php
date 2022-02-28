<?php

namespace App\Task\Services;

use App\Http\Controllers\Responses\AuthTaskResponse;
use App\Repository\UserRepository;
use App\Task\Requests\AuthTaskRequest;
use App\Task\Requests\GetTaskByUserTaskRequest;

class TaskService
{
    private $taskService;

    private $repository;

    public function __construct(TaskApiService $service, UserRepository $repository)
    {
        $this->taskService = $service;
        $this->repository = $repository;
    }

    public function auth($username, $password): AuthTaskResponse
    {
        $response = $this->taskService->auth(
            new AuthTaskRequest(
                $username,
                $password
            )
        );
        $user = $this->repository->findUserByUsername($username);

        if(!$user){
            $user = $this->repository->createUserByUsername($username);
        }

        $authResponse = new AuthTaskResponse(
            $response,
            $user
        );

        $this->repository->updateUser(
            $user,
            [
                'task_token' => $response->getAccessToken(),
                'task_expire_at' => $authResponse->getUserData()->getExpireAt(),
                'api_token' => base64_encode("$username:$user->id")
            ]
        );

        return $authResponse;
    }

    public function getTasksLoggedUser()
    {
        /**
         * @var $service TaskApiAuthService
         */
        $service = app(TaskApiAuthService::class);
        $response = $service->getTasksByUser(new GetTaskByUserTaskRequest());
        dd($response->getTaskList()[0]->getExecucaoList());
    }
}
