<?php

namespace App\Task\Requests;


class GetTaskByUserTaskRequest implements BaseRequest
{

    /**
     * @return string
     */
    public function generateUrl(): string
    {
        return "api/taskweb/ObterOrdemServicoAndamento";
    }

    public function getMethod(): string
    {
        return 'get';
    }

    public function generateBody(): array
    {
        return [];
    }

    public function generateQueryParams(): array
    {
        return [];
    }
}
