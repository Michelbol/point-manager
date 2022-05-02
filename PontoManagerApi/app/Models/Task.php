<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int $id_task_type
 * @property int $id_team
 * @property string $id_project
 * @property string|null $id_vsts
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereIdProject($value)
 * @method static Builder|Task whereIdTaskType($value)
 * @method static Builder|Task whereIdTeam($value)
 * @method static Builder|Task whereIdVsts($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_task_type',
        'id_team',
        'id_project',
        'id_vsts',
    ];
}
