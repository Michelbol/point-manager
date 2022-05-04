<?php

namespace App\Http\Controllers\Responses;


use App\Models\NoteTime;
use App\Models\Task;

class NoteTimeResponse implements ResponseInterface
{
    private $id;

    private $id_vsts;

    private $id_task;

    private $start_at;

    private $end_at;

    private $sync_at;

    private $description;

    private $codeArea;

    private $estimatedTime;

    private $idTaskType;

    public function __construct(NoteTime $model, ?Task $task = null)
    {
        $this->id = $model->id;
        $this->id_vsts = $model->id_vsts;
        $this->id_task = $model->id_task;
        $this->start_at = $model->start_at;
        $this->end_at = $model->end_at;
        $this->sync_at = $model->sync_at;
        $this->description = $model->description;
        if(isset($task)){
            $this->codeArea = $task->code_area;
            $this->estimatedTime = $task->estimated_time;
            $this->idTaskType = $task->id_task_type;
        }
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'id_vsts' => $this->id_vsts ?? 0,
            'id_task' => $this->id_task ?? 0,
            'start_at' => isset($this->start_at) ? $this->start_at->format('Y-m-d H:i') : null,
            'end_at' => isset($this->end_at) ? $this->end_at->format('Y-m-d H:i') : null,
            'sync_at' => isset($this->sync_at) ? $this->sync_at->format('Y-m-d H:i') : null,
            'description' => $this->description,
            'task' => [
                'codeArea' => $this->codeArea,
                'estimatedTime' => $this->estimatedTime,
                'idTaskType' => $this->idTaskType,
            ]
        ];
    }
}
