<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NoteTime
 *
 * @property int $id
 * @property string|null $id_vsts
 * @property string|null $id_task
 * @property string|null $description
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property string|null $sync_at
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|NoteTime newModelQuery()
 * @method static Builder|NoteTime newQuery()
 * @method static Builder|NoteTime query()
 * @method static Builder|NoteTime whereCreatedAt($value)
 * @method static Builder|NoteTime whereDescription($value)
 * @method static Builder|NoteTime whereEndAt($value)
 * @method static Builder|NoteTime whereId($value)
 * @method static Builder|NoteTime whereIdTask($value)
 * @method static Builder|NoteTime whereIdVsts($value)
 * @method static Builder|NoteTime whereStartAt($value)
 * @method static Builder|NoteTime whereSyncAt($value)
 * @method static Builder|NoteTime whereUpdatedAt($value)
 * @method static Builder|NoteTime whereUserId($value)
 * @mixin \Eloquent
 */
class NoteTime extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_vsts',
        'id_task',
        'start_at',
        'end_at',
        'sync_at',
        'user_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'id_task', 'id');
    }

    public function getStartAtAttribute($value)
    {
        if(isset($value) && is_string($value)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }

    public function getEndAtAttribute($value)
    {
        if(isset($value) && is_string($value)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }

    public function isTaskFill(): bool
    {
        return isset($this->id_task) && $this->id_task > 0;
    }

    public function isVstsFill(): bool
    {
        return isset($this->id_vsts) && $this->id_vsts > 0;
    }
}
