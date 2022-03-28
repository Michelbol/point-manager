<?php

namespace App\Service;

use App\Models\Task;
use App\Repository\TaskRepository;
use App\Task\Responses\FindTaskByIdAndIdProjectResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskService
{

    const ID_PROJECT = 'IT_BRKAMBIENTAL';

    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findOrCreate(int $id)
    {
        try {
            return $this->findById($id);
        }catch (ModelNotFoundException $exception){
            /**
             * @var $response FindTaskByIdAndIdProjectResponse
             */
            $response =  app(\App\Task\Services\TaskService::class)
                ->findTaskByIdAndIdProject(
                    self::ID_PROJECT,
                    $id
                );
            $dataTask = [
                'id' => $id,
                'id_project' => self::ID_PROJECT,
                'id_team' => $response->getCdEquipe(),
                'id_task_type' => $response->getTriagemList()[0]->getCdTipoTarefa()
            ];
            return $this->save($dataTask);
        } catch (Exception $exception){
            report($exception);
        }
        return null;
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function save(array $data): Task
    {
        $model = new Task();
        $model = $this->fill($data, $model);
        $model->save();
        return $model;
    }

    public function fill(array $data, Task $model): Task
    {
        $model->id = $data['id'] ?? null;
        $model->id_task_type = $data['id_task_type'] ?? null;
        $model->id_team = $data['id_team'] ?? null;
        $model->id_project = $data['id_project'] ?? null;
        return $model;
    }
}
