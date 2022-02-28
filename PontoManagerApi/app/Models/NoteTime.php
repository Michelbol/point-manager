<?php

namespace App\Models;

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
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
