<?php

namespace App\Http\Controllers\Requests;

class NoteTimeRequest
{
    const VALIDATIONS = [
        'start_at' => [
            'nullable',
            'date_format:Y-m-d H:i'
        ],
        'end_at' => [
            'nullable',
            'date_format:Y-m-d H:i'
        ],
        'id_vsts' => [
            'nullable',
            'integer'
        ],
        'description' => [
            'nullable',
            'string',
            'max:255'
        ],
        'id_task' => [
            'nullable',
            'integer'
        ],
    ];
}
