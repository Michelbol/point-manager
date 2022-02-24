<?php

namespace App\Task\Services;

use App\Http\Controllers\Requests\AuthTaskRequest;
use App\Http\Controllers\Responses\AuthTaskResponse;
use App\Models\User;
use App\Repository\UserRepository;

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

        $this->repository->updateApiToken($user, $response->getAccessToken());

        return new AuthTaskResponse(
            $response,
            $user
        );
    }
}
