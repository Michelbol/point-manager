<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    public function getStartAtAttribute($value)
    {
        if(isset($value) && is_string($value)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->startOfMinute();
        }
        return $value;
    }

    public function getEndAtAttribute($value)
    {
        if(isset($value) && is_string($value)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->startOfMinute();
        }
        return $value;
    }
}
