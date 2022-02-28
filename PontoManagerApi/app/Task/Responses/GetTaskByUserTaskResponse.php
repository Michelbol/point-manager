<?php

namespace App\Task\Responses;

use App\Http\Controllers\Responses\ResponseInterface;
use Carbon\Carbon;

class GetTaskByUserTaskResponse
{
    private $nrWorkFlowItem;

    private $cdNatureza;

    private $idWorkFlowWfmc;

    private $cdTarefa;

    private $infComplClob;

    private $dtDesejadaConcl;

    private $dsComplTarefa;

    private $cdTriagem;

    private $tmpPrevisto;

    private $tmpGasto;

    private $cdResultadoWorkFlow;

    private $dsTarefa;

    private $dsResultado;

    private $dtCadastro;

    private $cdTipoResultado;

    private $cdProjeto;

    private $boExecutando;

    private $execucaoList;

    private $dtRelease;

    private $cdTipoTarefa;

    private $anexoList;

    private $idEntregavel;

    /**
     * @param int $nrWorkFlowItem
     * @param int $cdNatureza
     * @param string $idWorkFlowWfmc
     * @param int $cdTarefa
     * @param string $infComplClob
     * @param string $dtDesejadaConcl
     * @param string $dsComplTarefa
     * @param int $cdTriagem
     * @param string $tmpPrevisto
     * @param string $tmpGasto
     * @param int $cdResultadoWorkFlow
     * @param string $dsTarefa
     * @param string $dsResultado
     * @param string $dtCadastro
     * @param int $cdTipoResultado
     * @param string $cdProjeto
     * @param string $boExecutando
     * @param array $execucaoList
     * @param string $dtRelease
     * @param int $cdTipoTarefa
     * @param array $anexoList
     * @param string $idEntregavel
     */
    public function __construct(
        int $nrWorkFlowItem,
        int $cdNatureza,
        string $idWorkFlowWfmc,
        int $cdTarefa,
        string $infComplClob,
        string $dtDesejadaConcl,
        string $dsComplTarefa,
        int $cdTriagem,
        string $tmpPrevisto,
        string $tmpGasto,
        int $cdResultadoWorkFlow,
        string $dsTarefa,
        string $dsResultado,
        string $dtCadastro,
        int $cdTipoResultado,
        string $cdProjeto,
        string $boExecutando,
        array $execucaoList,
        string $dtRelease,
        int $cdTipoTarefa,
        array $anexoList,
        string $idEntregavel
    )
    {
        $this->nrWorkFlowItem = $nrWorkFlowItem;
        $this->cdNatureza = $cdNatureza;
        $this->idWorkFlowWfmc = $idWorkFlowWfmc;
        $this->cdTarefa = $cdTarefa;
        $this->infComplClob = $infComplClob;
        $this->dtDesejadaConcl = Carbon::createFromFormat('d/m/Y', $dtDesejadaConcl);
        $this->dsComplTarefa = $dsComplTarefa;
        $this->cdTriagem = $cdTriagem;
        $this->tmpPrevisto = $tmpPrevisto;
        $this->tmpGasto = Carbon::createFromFormat('H:i:s', $tmpGasto); // 00:57:58
        $this->cdResultadoWorkFlow = $cdResultadoWorkFlow;
        $this->dsTarefa = $dsTarefa;
        $this->dsResultado = $dsResultado;
        $this->dtCadastro = Carbon::createFromFormat('d/m/Y', $dtCadastro); // "13/08/2021"
        $this->cdTipoResultado = $cdTipoResultado;
        $this->cdProjeto = $cdProjeto;
        $this->boExecutando = $boExecutando;
        foreach ($execucaoList as $execucao){
            $this->execucaoList[] = new GetTaskByUserTaskExecutionResponse(
                $execucao['Dh_Termino_Original'],
                $execucao['Cd_Tarefa'],
                $execucao['Dh_Inicio_Original'],
                $execucao['Cd_Triagem'],
                $execucao['Dh_Termino'],
                $execucao['Inf_Compl'],
                $execucao['Dh_Inicio'],
                $execucao['Cd_Projeto'],
            );
        }
        $this->dtRelease = $dtRelease;
        $this->cdTipoTarefa = $cdTipoTarefa;
        $this->anexoList = $anexoList;
        $this->idEntregavel = $idEntregavel;
    }

    /**
     * @return mixed
     */
    public function getNrWorkFlowItem()
    {
        return $this->nrWorkFlowItem;
    }

    /**
     * @param mixed $nrWorkFlowItem
     */
    public function setNrWorkFlowItem($nrWorkFlowItem): void
    {
        $this->nrWorkFlowItem = $nrWorkFlowItem;
    }

    /**
     * @return mixed
     */
    public function getCdNatureza()
    {
        return $this->cdNatureza;
    }

    /**
     * @param mixed $cdNatureza
     */
    public function setCdNatureza($cdNatureza): void
    {
        $this->cdNatureza = $cdNatureza;
    }

    /**
     * @return mixed
     */
    public function getIdWorkFlowWfmc()
    {
        return $this->idWorkFlowWfmc;
    }

    /**
     * @param mixed $idWorkFlowWfmc
     */
    public function setIdWorkFlowWfmc($idWorkFlowWfmc): void
    {
        $this->idWorkFlowWfmc = $idWorkFlowWfmc;
    }

    /**
     * @return mixed
     */
    public function getCdTarefa()
    {
        return $this->cdTarefa;
    }

    /**
     * @param mixed $cdTarefa
     */
    public function setCdTarefa($cdTarefa): void
    {
        $this->cdTarefa = $cdTarefa;
    }

    /**
     * @return mixed
     */
    public function getInfComplClob()
    {
        return $this->infComplClob;
    }

    /**
     * @param mixed $infComplClob
     */
    public function setInfComplClob($infComplClob): void
    {
        $this->infComplClob = $infComplClob;
    }

    /**
     * @return mixed
     */
    public function getDtDesejadaConcl()
    {
        return $this->dtDesejadaConcl;
    }

    /**
     * @param mixed $dtDesejadaConcl
     */
    public function setDtDesejadaConcl($dtDesejadaConcl): void
    {
        $this->dtDesejadaConcl = $dtDesejadaConcl;
    }

    /**
     * @return mixed
     */
    public function getDsComplTarefa()
    {
        return $this->dsComplTarefa;
    }

    /**
     * @param mixed $dsComplTarefa
     */
    public function setDsComplTarefa($dsComplTarefa): void
    {
        $this->dsComplTarefa = $dsComplTarefa;
    }

    /**
     * @return mixed
     */
    public function getCdTriagem()
    {
        return $this->cdTriagem;
    }

    /**
     * @param mixed $cdTriagem
     */
    public function setCdTriagem($cdTriagem): void
    {
        $this->cdTriagem = $cdTriagem;
    }

    /**
     * @return mixed
     */
    public function getTmpPrevisto()
    {
        return $this->tmpPrevisto;
    }

    /**
     * @param mixed $tmpPrevisto
     */
    public function setTmpPrevisto($tmpPrevisto): void
    {
        $this->tmpPrevisto = $tmpPrevisto;
    }

    /**
     * @return mixed
     */
    public function getTmpGasto()
    {
        return $this->tmpGasto;
    }

    /**
     * @param mixed $tmpGasto
     */
    public function setTmpGasto($tmpGasto): void
    {
        $this->tmpGasto = $tmpGasto;
    }

    /**
     * @return mixed
     */
    public function getCdResultadoWorkFlow()
    {
        return $this->cdResultadoWorkFlow;
    }

    /**
     * @param mixed $cdResultadoWorkFlow
     */
    public function setCdResultadoWorkFlow($cdResultadoWorkFlow): void
    {
        $this->cdResultadoWorkFlow = $cdResultadoWorkFlow;
    }

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
    public function getDsResultado()
    {
        return $this->dsResultado;
    }

    /**
     * @param mixed $dsResultado
     */
    public function setDsResultado($dsResultado): void
    {
        $this->dsResultado = $dsResultado;
    }

    /**
     * @return mixed
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * @param mixed $dtCadastro
     */
    public function setDtCadastro($dtCadastro): void
    {
        $this->dtCadastro = $dtCadastro;
    }

    /**
     * @return mixed
     */
    public function getCdTipoResultado()
    {
        return $this->cdTipoResultado;
    }

    /**
     * @param mixed $cdTipoResultado
     */
    public function setCdTipoResultado($cdTipoResultado): void
    {
        $this->cdTipoResultado = $cdTipoResultado;
    }

    /**
     * @return mixed
     */
    public function getCdProjeto()
    {
        return $this->cdProjeto;
    }

    /**
     * @param mixed $cdProjeto
     */
    public function setCdProjeto($cdProjeto): void
    {
        $this->cdProjeto = $cdProjeto;
    }

    /**
     * @return mixed
     */
    public function getBoExecutando()
    {
        return $this->boExecutando;
    }

    /**
     * @param mixed $boExecutando
     */
    public function setBoExecutando($boExecutando): void
    {
        $this->boExecutando = $boExecutando;
    }

    /**
     * @return mixed
     */
    public function getExecucaoList()
    {
        return $this->execucaoList;
    }

    /**
     * @param mixed $execucaoList
     */
    public function setExecucaoList($execucaoList): void
    {
        $this->execucaoList = $execucaoList;
    }

    /**
     * @return mixed
     */
    public function getDtRelease()
    {
        return $this->dtRelease;
    }

    /**
     * @param mixed $dtRelease
     */
    public function setDtRelease($dtRelease): void
    {
        $this->dtRelease = $dtRelease;
    }

    /**
     * @return mixed
     */
    public function getCdTipoTarefa()
    {
        return $this->cdTipoTarefa;
    }

    /**
     * @param mixed $cdTipoTarefa
     */
    public function setCdTipoTarefa($cdTipoTarefa): void
    {
        $this->cdTipoTarefa = $cdTipoTarefa;
    }

    /**
     * @return mixed
     */
    public function getAnexoList()
    {
        return $this->anexoList;
    }

    /**
     * @param mixed $anexoList
     */
    public function setAnexoList($anexoList): void
    {
        $this->anexoList = $anexoList;
    }

    /**
     * @return mixed
     */
    public function getIdEntregavel()
    {
        return $this->idEntregavel;
    }

    /**
     * @param mixed $idEntregavel
     */
    public function setIdEntregavel($idEntregavel): void
    {
        $this->idEntregavel = $idEntregavel;
    }

    public function toArray(): array
    {
        return [
            'nrWorkFlowItem' => $this->nrWorkFlowItem,
            'cdNatureza' => $this->cdNatureza,
            'idWorkFlowWfmc' => $this->idWorkFlowWfmc,
            'cdTarefa' => $this->cdTarefa,
            'infComplClob' => $this->infComplClob,
            'dtDesejadaConcl' => $this->dtDesejadaConcl,
            'dsComplTarefa' => $this->dsComplTarefa,
            'cdTriagem' => $this->cdTriagem,
            'tmpPrevisto' => $this->tmpPrevisto,
            'tmpGasto' => $this->tmpGasto,
            'cdResultadoWorkFlow' => $this->cdResultadoWorkFlow,
            'dsTarefa' => $this->dsTarefa,
            'dsResultado' => $this->dsResultado,
            'dtCadastro' => $this->dtCadastro,
            'cdTipoResultado' => $this->cdTipoResultado,
            'cdProjeto' => $this->cdProjeto,
            'boExecutando' => $this->boExecutando,
            'execucaoList' => $this->execucaoList,
            'dtRelease' => $this->dtRelease,
            'cdTipoTarefa' => $this->cdTipoTarefa,
            'anexoList' => $this->anexoList,
            'idEntregavel' => $this->idEntregavel,
        ];
    }
}
