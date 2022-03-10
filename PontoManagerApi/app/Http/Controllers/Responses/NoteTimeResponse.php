<?php

namespace App\Http\Controllers\Responses;


use App\Models\NoteTime;

class NoteTimeResponse implements ResponseInterface
{
    private $id;

    private $id_vsts;

    private $id_task;

    private $start_at;

    private $end_at;

    private $sync_at;

    private $description;

    /**
     * @param NoteTime $model
     */
    public function __construct(NoteTime $model)
    {
        $this->id = $model->id;
        $this->id_vsts = $model->id_vsts;
        $this->id_task = $model->id_task;
        $this->start_at = $model->start_at;
        $this->end_at = $model->end_at;
        $this->sync_at = $model->sync_at;
        $this->description = $model->description;
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
        ];
    }
}
