<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\ResponseInterface;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function dataResponse(ResponseInterface $data, $statusCode = 200): JsonResponse
    {
        return response()->json(
            [
                'data' => $data->toArray(),
                'message' => null
            ],
            $statusCode);
    }

    public function errorResponse(string $msg, int $statusCode = 400): JsonResponse
    {
        return response()->json(
            [
                'data' => null,
                'message' => $msg
            ],
            $statusCode);
    }

    public function validationResponse(string $msg, int $statusCode = 422): JsonResponse
    {
        return response()->json(
            [
                'data' => null,
                'message' => $msg
            ],
            $statusCode);
    }
}
