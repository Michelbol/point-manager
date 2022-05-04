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

    public function findOrCreate(int $id, ?int $idVsts = 0): ?Task
    {
        try {
            return $this->findById($id);
        }catch (ModelNotFoundException $exception){
            return $this->createTaskByTaskWeb($id, $idVsts);
        } catch (Exception $exception){
            report($exception);
        }
        return null;
    }

    public function createTaskByTaskWeb(int $id, ?int $idVsts = 0): ?Task
    {
        /**
         * @var $response FindTaskByIdAndIdProjectResponse
         */
        $response =  app(\App\Task\Services\TaskService::class)
            ->findTaskByIdAndIdProject(
                self::ID_PROJECT,
                $id
            );
        $dataTask = $this->mapperRequestToTaskModel($response);
        $dataTask['id'] = $id;
        $dataTask['id_vsts'] = $idVsts;
        return $this->save($dataTask);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function mapperRequestToTaskModel(FindTaskByIdAndIdProjectResponse $response): array
    {
        return [
            'id_project' => self::ID_PROJECT,
            'id_team' => $response->cdEquipe(),
            'id_task_type' => $response->tipoDaPrimeiraTriagem(),
            'estimated_time' => $response->tmpPrevisto(),
            'code_area' => $response->codeArea(),
        ];
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findByVsts(int $id)
    {
        return $this->repository->findByIdVsts($id);
    }

    public function save(array $data): Task
    {
        $model = new Task();
        $model = $this->fill($data, $model);
        $model->save();
        return $model;
    }

    public function update(array $data, Task $model): Task
    {
        $model = $this->fill($data, $model);
        $model->save();
        return $model;
    }

    public function updateIdVsts(Task $model, int $idVsts): Task
    {
        $model->id_vsts = $idVsts;
        $model->save();
        return $model;
    }

    public function fill(array $data, Task $model): Task
    {
        $model->id = $data['id'] ?? null;
        $model->id_task_type = $data['id_task_type'] ?? null;
        $model->id_team = $data['id_team'] ?? null;
        $model->id_project = $data['id_project'] ?? null;
        $model->id_vsts = $data['id_vsts'] ?? null;
        $model->code_area = $data['code_area'] ?? null;
        return $model;
    }
}
