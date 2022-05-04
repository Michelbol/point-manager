<?php

namespace App\Task\Responses;

use Illuminate\Contracts\Support\Arrayable;

class FindTaskByIdAndIdProjectResponse implements Arrayable
{

    private $dsTarefa;

    private $cdEquipe;

    private $triagemList;

    private $tmpPrevisto;

    private $cdArea;

    /**
     * @return mixed
     */
    public function cdEquipe()
    {
        return $this->cdEquipe;
    }

    /**
     * @return array
     */
    public function getTriagemList()
    {
        return $this->triagemList;
    }

    public function tipoDaPrimeiraTriagem()
    {
        return $this->getTriagemList()[0]->getCdTipoTarefa();
    }

    public function codeArea()
    {
        return $this->cdArea;
    }

    public function tmpPrevisto()
    {
        return $this->tmpPrevisto;
    }

    public function __construct(array $response)
    {
        $this->dsTarefa = $response['Ds_Tarefa'];
        $this->cdEquipe = $response['Cd_Equipe'];
        $this->tmpPrevisto = $response['Tmp_Previsto'];
        $this->cdArea = $response['Cd_Area'];
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
            'triagemList' => $this->triagemList,
            'tmpPrevisto' => $this->tmpPrevisto,
            'cdArea' => $this->cdArea,
        ];
    }
}
