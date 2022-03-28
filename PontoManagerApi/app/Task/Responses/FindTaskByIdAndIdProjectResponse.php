<?php

namespace App\Task\Responses;

class FindTaskByIdAndIdProjectResponse
{

    private $dsTarefa;

    private $cdEquipe;

    private $triagemList;

    /**
     * @return mixed
     */
    public function getDsTarefa()
    {
        return $this->dsTarefa;
    }

    /**
     * @param mixed $dsTarefa
     */
    public function setDsTarefa($dsTarefa): void
    {
        $this->dsTarefa = $dsTarefa;
    }

    /**
     * @return mixed
     */
    public function getCdEquipe()
    {
        return $this->cdEquipe;
    }

    /**
     * @param mixed $cdEquipe
     */
    public function setCdEquipe($cdEquipe): void
    {
        $this->cdEquipe = $cdEquipe;
    }

    /**
     * @return array
     */
    public function getTriagemList()
    {
        return $this->triagemList;
    }

    /**
     * @param array $triagemList
     */
    public function setTriagemList(array $triagemList): void
    {
        $this->triagemList = $triagemList;
    }

    public function __construct(array $response)
    {
        $this->dsTarefa = $response['Ds_Tarefa'];
        $this->cdEquipe = $response['Cd_Equipe'];
        $this->triagemList = [];
        foreach ($response['TriagemList'] as $triagem){
            $this->triagemList[] = new FindTaskByIdAndIdProjectTriagemListResponse($triagem['Cd_Tipotarefa']);
        }
    }


    public function toArray(): array
    {
        return [
            'dsTarefa' => $this->dsTarefa,
            'cdEquipe' => $this->cdEquipe,
            'triagemList' => $this->triagemList
        ];
    }
}
