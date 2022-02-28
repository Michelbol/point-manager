<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Task\Services\TaskService;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    public function myTasks()
    {
        try{
//            $this->dataResponse($this->taskService->getTasksLoggedUser());
        } catch (ClientException|ModelNotFoundException $e) {
            return $this->validationResponse('Usuário/Senha incorreto');
        } catch (Exception $e){
            return $this->errorResponse(
                $e->getMessage()
            );
        }
    }

}
