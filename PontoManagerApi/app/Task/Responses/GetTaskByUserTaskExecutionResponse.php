<?php

namespace App\Task\Responses;

use App\Http\Controllers\Responses\ResponseInterface;
use Carbon\Carbon;

class GetTaskByUserTaskExecutionResponse
{

    private $dhTerminoOriginal;

    private $cdTarefa;

    private $dhInicioOriginal;

    private $cdTriagem;

    private $dhTermino;

    private $infCompl;

    private $dhInicio;

    private $cdProjeto;

    /**
     * @param string $dhTerminoOriginal
     * @param int $cdTarefa
     * @param string $dhInicioOriginal
     * @param int $cdTriagem
     * @param string $dhTermino
     * @param string $infCompl
     * @param string $dhInicio
     * @param string $cdProjeto
     */
    public function __construct(
        string $dhTerminoOriginal,
        int $cdTarefa,
        string $dhInicioOriginal,
        int $cdTriagem,
        string $dhTermino,
        string $infCompl,
        string $dhInicio,
        string $cdProjeto
    )
    {
        $this->dhTerminoOriginal = Carbon::createFromFormat('d/m/Y H:i:s', $dhTerminoOriginal);
        $this->cdTarefa = $cdTarefa;
        $this->dhInicioOriginal = Carbon::createFromFormat('d/m/Y H:i:s', $dhInicioOriginal);
        $this->cdTriagem = $cdTriagem;
        $this->dhTermino = Carbon::createFromFormat('d/m/Y H:i:s', $dhTermino);
        $this->infCompl = $infCompl;
        $this->dhInicio = Carbon::createFromFormat('d/m/Y H:i:s', $dhInicio);
        $this->cdProjeto = $cdProjeto;
    }

    /**
     * @return mixed
     */
    public function getDhTerminoOriginal()
    {
        return $this->dhTerminoOriginal;
    }

    /**
     * @param mixed $dhTerminoOriginal
     */
    public function setDhTerminoOriginal($dhTerminoOriginal): void
    {
        $this->dhTerminoOriginal = $dhTerminoOriginal;
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
    public function getDhInicioOriginal()
    {
        return $this->dhInicioOriginal;
    }

    /**
     * @param mixed $dhInicioOriginal
     */
    public function setDhInicioOriginal($dhInicioOriginal): void
    {
        $this->dhInicioOriginal = $dhInicioOriginal;
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
    public function getDhTermino()
    {
        return $this->dhTermino;
    }

    /**
     * @param mixed $dhTermino
     */
    public function setDhTermino($dhTermino): void
    {
        $this->dhTermino = $dhTermino;
    }

    /**
     * @return mixed
     */
    public function getInfCompl()
    {
        return $this->infCompl;
    }

    /**
     * @param mixed $infCompl
     */
    public function setInfCompl($infCompl): void
    {
        $this->infCompl = $infCompl;
    }

    /**
     * @return mixed
     */
    public function getDhInicio()
    {
        return $this->dhInicio;
    }

    /**
     * @param mixed $dhInicio
     */
    public function setDhInicio($dhInicio): void
    {
        $this->dhInicio = $dhInicio;
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


    public function toArray(): array
    {
        return [
            'dhTerminoOriginal' => $this->dhTerminoOriginal,
            'cdTarefa' => $this->cdTarefa,
            'dhInicioOriginal' => $this->dhInicioOriginal,
            'cdTriagem' => $this->cdTriagem,
            'dhTermino' => $this->dhTermino,
            'infCompl' => $this->infCompl,
            'dhInicio' => $this->dhInicio,
            'cdProjeto' => $this->cdProjeto,
        ];
    }
}
