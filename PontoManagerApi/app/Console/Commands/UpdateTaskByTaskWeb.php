<?php

namespace App\Console\Commands;

use App\Factory\HttpClientAuthFactory;
use App\Repository\UserRepository;
use App\Service\TaskService;
use App\Task\Client\WebServiceTaskAuthClient;
use App\Task\Requests\FindTaskByIdAndIdProjectRequest;
use App\Task\Services\TaskApiAuthService;
use Illuminate\Console\Command;

class UpdateTaskByTaskWeb extends Command
{
    private $userRepository;

    private $taskService;

    public function __construct(UserRepository $userRepository, TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
        $this->userRepository = $userRepository;
    }

    protected $signature = 'update:task {id_task}';

    protected $description = 'Update a single task with task web information';


    public function handle()
    {
        $idTask = (int)$this->argument('id_task');
        $this->info("Iniciando Atualização da Task: $idTask\n");
        $user = $this->userRepository->findUserByUsername('MICHEL.REIS');
        $taskApiService = new TaskApiAuthService(new WebServiceTaskAuthClient(
                (new HttpClientAuthFactory($user))
                    ->createClient()
            )
        );
        $this->info("Autenticado Com Sucesso\n");
        $this->info("Buscando no task...\n");
        $response = $taskApiService->findTask(new FindTaskByIdAndIdProjectRequest(TaskService::ID_PROJECT, $idTask));
        $this->info("Atualizando Dados\n");
        $task = $this->taskService->findById($idTask);
        $data = $this->taskService->mapperRequestToTaskModel($response);
        $data['id'] = $idTask;
        $data['id_vsts'] = $task->id_vsts;
        if(!$task){
            $this->info("Criado Task: Id: $data[id]\n");
            $this->taskService->save($data);
            return;
        }
        $this->taskService->update($data, $task);
        $this->info("Atualizado Task: Id: $data[id]\n");
    }
}
