<?php

namespace App\Service;

use App\Exceptions\ValidationFillException;
use App\Models\NoteTime;
use App\Models\User;
use App\Repository\NoteTimeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class NoteTimeService
{
    private $repository;

    public function __construct(NoteTimeRepository $repository)
    {
        $this->repository = $repository;
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
     * @param array $data
     * @param $model
     * @return mixed
     * @throws ValidationFillException
     */
    public function fill(array $data, $model)
    {
        $model->id_vsts = $data['id_vsts'] ?? null;
        $model->id_task = $data['id_task'] ?? null;
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

    public function fixSecond($model)
    {
        if($this->repository->existsEndAtAndUser($model->start_at, $model->user_id, $model->id)){
            $model->start_at->addSecond();
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
                throw new ValidationFillException('Já existe um lançamento para o horário informado');
            }
        }else if(isset($model->start_at)){
            if($this->repository->existsStartAtAndUser($model->start_at, $model->user_id, $model->id)){
                throw new ValidationFillException('Já existe um lançamento para o horário informado');
            }
        }
        else if(isset($model->end_at)){
            if($this->repository->existsEndAtAndUser($model->end_at, $model->user_id, $model->id)){
                throw new ValidationFillException('Já existe um lançamento para o horário informado');
            }
        }
    }
}
