<?php

namespace App\Http\Controllers\Responses;

interface ResponseInterface
{
    public function toArray(): array;
}
