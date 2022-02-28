<?php

namespace App\Task\Responses;

use App\Http\Controllers\Responses\ResponseInterface;

class GetTaskByUserTaskListResponse
{
    private $taskList;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        foreach ($response['data']['FItens'] as $task){
            $this->taskList[] = new GetTaskByUserTaskResponse(
                $task['Nr_Workflow_Item'],
                $task['Cd_Natureza'],
                $task['Id_Workflow_Wfmc'],
                $task['Cd_Tarefa'],
                $task['Inf_Compl_Clob'],
                $task['Dt_Desejada_Concl'],
                $task['Ds_Compl_Tarefa'],
                $task['Cd_Triagem'],
                $task['Tmp_Previsto'],
                $task['Tmp_Gasto'],
                $task['Cd_ResultadoWorkFlow'],
                $task['Ds_Tarefa'],
                $task['Ds_Resultado'],
                $task['Dt_Cadastro'],
                $task['Cd_TipoResultado'],
                $task['Cd_Projeto'],
                $task['Bo_Executando'],
                $task['ExecucaoList'],
                $task['Dt_Release'],
                $task['Cd_TipoTarefa'],
                $task['AnexoList'],
                $task['Id_Entregavel']
            );
        }
    }

    /**
     * @return array
     */
    public function getTaskList(): array
    {
        return $this->taskList;
    }

    /**
     * @param array $taskList
     */
    public function setTaskList(array $taskList): void
    {
        $this->taskList = $taskList;
    }

    public function toArray(): array
    {
        return [
            'task_list' => $this->taskList
        ];
    }
}
