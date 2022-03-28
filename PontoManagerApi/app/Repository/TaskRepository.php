<?php

namespace App\Repository;

use App\Models\Task;

class TaskRepository
{
    /**
     * @param int $id
     * @param array|null $fields
     * @return Task|null
     */
    public function findById(int $id, array $fields = null)
    {
        if(isset($fields)){
            return Task::findOrFail($id, $fields);
        }
        return Task::findOrFail($id);
    }
}
