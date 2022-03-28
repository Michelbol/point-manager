<?php

namespace App\Task\Requests;

class FindTaskByIdAndIdProjectRequest implements BaseRequest
{
    private $idProject;

    private $idTask;


    public function __construct(string $idProject, int $idTask)
    {
        $this->idProject = $idProject;
        $this->idTask = $idTask;
    }


    /**
     * @return string
     */
    public function generateUrl(): string
    {
        return "api/taskweb/ObterOrdemServico";
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
        return [
            'cd_projeto' => $this->idProject,
            'cd_tarefa' => $this->idTask
        ];
    }
}
