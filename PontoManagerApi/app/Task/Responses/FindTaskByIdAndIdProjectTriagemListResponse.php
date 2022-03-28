<?php

namespace App\Task\Responses;

class FindTaskByIdAndIdProjectTriagemListResponse
{


    private $cdTipoTarefa;

    public function __construct(int $cdTipoTarefa)
    {
        $this->cdTipoTarefa = $cdTipoTarefa;
    }

    /**
     * @return int
     */
    public function getCdTipoTarefa(): int
    {
        return $this->cdTipoTarefa;
    }

    /**
     * @param int $cdTipoTarefa
     */
    public function setCdTipoTarefa(int $cdTipoTarefa): void
    {
        $this->cdTipoTarefa = $cdTipoTarefa;
    }


    public function toArray(): array
    {
        return [
            'cdTipoTarefa' => $this->cdTipoTarefa,
        ];
    }
}
