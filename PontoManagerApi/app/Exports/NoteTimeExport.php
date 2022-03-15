<?php

namespace App\Exports;

use App\Models\NoteTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NoteTimeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return NoteTime::get();
    }

    /**
     * @param NoteTime $noteTime
     * @return array
     */
    public function map($noteTime): array
    {
        return [
            'IT_BRKAMBIENTAL',
            $noteTime->id_task,
            'MICHEL.REIS',//Auth::user()->username,
            $noteTime->start_at,
            $noteTime->end_at,
            1,
            null,
            //tipo da tarefa
            // cd equipe
        ];
    }

    public function headings(): array
    {
        return [
            'CD_PROJETO',
            'CD_TAREFA',
            'CD_RESPONSAVEL',
            'DH_INICIO',
            'DH_TERMINO',
            '',
            '',
            'CD_TIPOTAREFA',
            'CD_EQUIPE',
            '',
            'OBS',
            'OBS2',
        ];
    }
}
