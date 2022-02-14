<?php

namespace App\Task\Services;

use App\Task\Requests\TokenRequest;

class TaskService
{
    public function token($username, $password)
    {
        $request = new TokenRequest($username, $password);
//        $request->
    }
}
