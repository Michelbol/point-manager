<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationFillException;
use App\Exports\NoteTimeExport;
use App\Http\Controllers\Requests\NoteTimeRequest;
use App\Http\Controllers\Responses\NoteTimeResponse;
use App\Service\NoteTimeService;
use Carbon\Carbon;
use Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteTimeController extends Controller
{
    private $service;

    public function __construct(NoteTimeService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {

        $fields = $this->validate($request, [
            'date' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            'start_at' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            'end_at' => [
                'nullable',
                'date_format:Y-m-d'
            ]
        ]);
        $startAt = Carbon::now();
        $endAt = Carbon::now();
        if (isset($fields['date'])) {
            $startAt = Carbon::createFromFormat('Y-m-d', $fields['date']);
            $endAt = Carbon::createFromFormat('Y-m-d', $fields['date']);
        }
        if(isset($fields['start_at']) && isset($fields['end_at'])){
            $startAt = Carbon::createFromFormat('Y-m-d', $fields['start_at']);
            $endAt = Carbon::createFromFormat('Y-m-d', $fields['end_at']);
        }

        $noteTimes = $this
            ->service
            ->listByDate(
                $startAt->startOfDay(),
                $endAt->endOfDay(),
                Auth::user()
            );
        $response = [];
        foreach ($noteTimes as $noteTime) {
            $response[] = (new NoteTimeResponse($noteTime, $noteTime->task))->toArray();
        }

        return $response;
    }

    public function save(Request $request)
    {
        $fields = $this->validate($request, NoteTimeRequest::VALIDATIONS);

        if (empty($fields)) {
            return $this->validationResponse('Preencha pelo menos 1 dos campos');
        }
        try {
            $model = $this->service->save($fields, Auth::user());
        } catch (ValidationFillException $e) {
            return $this->validationResponse($e->getMessage());
        }

        return $this->createdResponse(new NoteTimeResponse($model));

    }

    public function update(Request $request, $id)
    {
        $fields = $this->validate($request, NoteTimeRequest::VALIDATIONS);

        if (empty($fields)) {
            return $this->validationResponse('Preencha pelo menos 1 dos campos');
        }
        $fields['id'] = $id;
        try {
            $model = $this->service->save($fields, Auth::user());
        } catch (ValidationFillException $e) {
            return $this->validationResponse($e->getMessage());
        } catch (ModelNotFoundException $e) {
            return $this->validationResponse('Lançamento não existe');
        }
        return $this->dataResponse(new NoteTimeResponse($model));
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
            return $this->okResponse();
        } catch (ModelNotFoundException $e) {
            return $this->validationResponse('Lançamento não existe');
        }
    }

    public function deleteMany(Request $request)
    {
        $fields = $this->validate($request, [
            'ids' => [
                'array',
                'required'
            ]
        ]);
        $this->service->deleteMany($fields['ids']);
    }

    public function export(Request $request)
    {
        $fields = $this->validate(
            $request,
            [
                'start_at' => [
                    'required',
                    'date_format:Y-m-d'
                ],
                'end_at' => [
                    'required',
                    'date_format:Y-m-d'
                ]
            ]);
        $startAt = Carbon::createFromFormat('Y-m-d', $fields['start_at'])->startOfDay();
        $endAt = Carbon::createFromFormat('Y-m-d', $fields['end_at'])->endOfDay();
        $name = "Lançamentos-".$startAt->format('Y-m-d')." a ".$endAt->format('Y-m-d').".xlsx";
        return Excel::download(new NoteTimeExport($startAt, $endAt), $name);
    }
}
