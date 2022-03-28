<?php

namespace App\Exports;

use App\Models\NoteTime;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NoteTimeExport implements FromCollection, WithHeadings, WithMapping
{
    private $startAt;

    private $endAt;

    public function __construct(Carbon $startAt, Carbon $endAt)
    {
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return NoteTime
            ::join('tasks', 'tasks.id', 'note_times.id_task')
            ->whereBetween('note_times.start_at', [$this->startAt, $this->endAt])
            ->get([
                'note_times.id_task',
                'note_times.start_at',
                'note_times.end_at',
                'note_times.description',
                'tasks.id',
                'tasks.id_project',
                'tasks.id_task_type',
                'tasks.id_team',
            ]);
    }

    /**
     * @param NoteTime $noteTime
     * @return array
     */
    public function map($noteTime): array
    {
        return [
            $noteTime->id_project,
            $noteTime->id_task,
            Auth::user()->username,
            $noteTime->start_at->format('d/m/Y h:i:s'),
            $noteTime->end_at->format('d/m/Y h:i:s'),
            1,
            null,
            $noteTime->id_task_type,
            $noteTime->id_team,
            null,
            $noteTime->description
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
