<?php

namespace App\Service;

use App\Exceptions\ValidationFillException;
use App\Models\NoteTime;
use App\Models\Task;
use App\Models\User;
use App\Repository\NoteTimeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NoteTimeService
{
    private $repository;

    private $taskService;

    public function __construct(NoteTimeRepository $repository, TaskService $taskService)
    {
        $this->repository = $repository;
        $this->taskService = $taskService;
    }

    public function listByDate(Carbon $startAt, Carbon $endAt, User $user)
    {
        return $this->repository->getByRangeAndUser($startAt, $endAt, $user->id);
    }

    /**
     * @param array $data
     * @param User $user
     * @return NoteTime
     * @throws ValidationFillException
     */
    public function save(array $data, User $user): NoteTime
    {
        $model = new NoteTime();
        if(isset($data['id']) && $data['id'] > 0){
            $model = $this->repository->findById($data['id']);
        }else{
            $data['id'] = 0;
        }
        $data['user_id'] = $user->id;
        $model = $this->fill($data, $model);
        $model->save();
        return $model;
    }

    /**
     * @throws ValidationFillException
     */
    private function fill(array $data, NoteTime $model): NoteTime
    {
        $model->id_vsts = $data['id_vsts'] ?? null;
        $model->id_task = $data['id_task'] ?? null;
        if($model->isTaskFill()){
            $this->updateAllTasksWithSameIdVsts($model);
        }
        if($model->isVstsFill() && !$model->isTaskFill()){
            $model->id_task = $this->findTaskByVsts($model->id_vsts);
        }
        $model->sync_at = $data['sync_at'] ?? null;
        $model->description = $data['description'] ?? null;
        $model->user_id = $data['user_id'];
        $model->start_at = $this->createCarbonStartAt($data['start_at']);
        if(isset($data['start_at']) && isset($data['end_at'])){
            $model->end_at = $this->createCarbonEndAt($data['end_at']);
        }else if(isset($data['start_at'])){
            $model->start_at = $this->createCarbonStartAt($data['start_at']);
        }else if(isset($data['end_at'])){
            $model->end_at = $this->createCarbonEndAt($data['end_at']);
        }
        $this->fixSecond($model);
        $this->isUnique($model);
        return $model;
    }

    private function fixSecond($model)
    {
        if($this->repository->existsEndAtAndUser($model->start_at, $model->user_id, $model->id)){
            $model->start_at->addSecond();
        }
        if($this->repository->existsStartAtAndUser($model->end_at, $model->user_id, $model->id)){
            $noteTime = $this->repository->firstStartAtAndUser($model->end_at, $model->user_id, $model->id);
            $noteTime->start_at = $noteTime->start_at->addSecond();
            $noteTime->save();
        }
    }

    public function delete($id)
    {
        $noteTime = $this->repository->findById($id);
        if(isset($noteTime)){
            $noteTime->delete();
        }
    }

    public function deleteMany(array $ids)
    {
        foreach ($ids as $id){
            try {
                $noteTime = $this->repository->findById($id);
                if(isset($noteTime)){
                    $noteTime->delete();
                }
            }catch (ModelNotFoundException $e){
                continue;
            }
        }
    }

    private function createCarbonStartAt(string $date){
        return Carbon::createFromFormat('Y-m-d H:i', $date)->startOfMinute();
    }

    private function createCarbonEndAt(string $date){
        return Carbon::createFromFormat('Y-m-d H:i', $date)->startOfMinute();
    }

    /**
     * @param $model
     * @return void
     * @throws ValidationFillException
     */
    private function isUnique($model){
        if(isset($model->start_at) && isset($model->end_at)){
            if($this->repository->existsByRangeAndUser($model->start_at, $model->end_at, $model->user_id, $model->id)){
                throw new ValidationFillException('Já existe um lançamento para o período informado');
            }
        }else if(isset($model->start_at)){
            if($this->repository->existsStartAtAndUser($model->start_at, $model->user_id, $model->id)){
                throw new ValidationFillException('Já existe um lançamento com esse horário de inicio');
            }
        }
        else if(isset($model->end_at)){
            if($this->repository->existsEndAtAndUser($model->end_at, $model->user_id, $model->id)){
                throw new ValidationFillException('Já existe um lançamento com esse horário de término');
            }
        }
    }

    private function updateBySimilarity(int $idVsts, int $idTask, int $userId)
    {
        $this->repository->updateByIdVsts($idVsts, $idTask, $userId);
    }

    private function updateAllTasksWithSameIdVsts(NoteTime $model): void
    {
        $task = $this->taskService->findOrCreate($model->id_task);
        if (!isset($task)) {
            return;
        }
        if($model->isVstsFill()){
            $this->updateBySimilarity($model->id_vsts, $task->id, $model->user_id);
            $this->updateIdVstsOfTaskFound((int) $model->id_vsts, $task);
        }
    }

    /**
     * @param int $idVsts
     * @param Task $task
     * @return void
     */
    private function updateIdVstsOfTaskFound(int $idVsts, Task $task): void
    {
        if ((int)$task->id_vsts !== $idVsts) {
            $this->taskService->updateIdVsts($task, $idVsts);
        }
    }

    private function findTaskByVsts(int $idVsts): int
    {
        $task = $this->taskService->findByVsts($idVsts);
        if($task){
            return $task->id;
        }
        return 0;
    }
}
