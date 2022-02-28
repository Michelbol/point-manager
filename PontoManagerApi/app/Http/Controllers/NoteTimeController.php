<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationFillException;
use App\Http\Controllers\Responses\NoteTimeResponse;
use App\Service\NoteTimeService;
use Carbon\Carbon;
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

    public function listToday()
    {
        return $this
            ->service
            ->listByDate(
                Carbon::now()->startOfDay(),
                Carbon::now()->endOfDay(),
                Auth::user()
            );
    }

    public function save(Request $request)
    {
        $fields = $this->validate($request, [
            'start_at' => [
                'nullable',
                'date_format:Y-m-d H:i'
            ],
            'end_at' => [
                'nullable',
                'date_format:Y-m-d H:i'
            ],
            'id_vsts' => [
                'nullable',
                'integer'
            ],
            'id_task' => [
                'nullable',
                'integer'
            ],
        ]);

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
        $fields = $this->validate($request, [
            'start_at' => [
                'nullable',
                'date_format:Y-m-d H:i'
            ],
            'end_at' => [
                'nullable',
                'date_format:Y-m-d H:i'
            ],
            'id_vsts' => [
                'nullable',
                'integer'
            ],
            'id_task' => [
                'nullable',
                'integer'
            ],
        ]);

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
}
