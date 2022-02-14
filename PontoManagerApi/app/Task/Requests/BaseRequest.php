<?php

namespace App\Task\Requests;

interface BaseRequest
{
    public function generateUrl(): string;

    public function getMethod(): string;

    public function generateBody(): array;

    public function generateQueryParams(): array;
}
