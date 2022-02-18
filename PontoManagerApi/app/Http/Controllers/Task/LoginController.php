<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\AuthTaskRequest;
use App\Services\TaskService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $taskService;

    public function __construct(TaskService $service)
    {
        $this->taskService = $service;
    }

    public function token(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
        try {
            $response = $this->taskService->auth(
                new AuthTaskRequest($data['username'], $data['password'])
            );
            $user_data = $this->decodeToken($response['data']['access_token']);
            $user_data['username'] = $user_data["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name"];
            $user_data['role'] = $user_data["http://schemas.microsoft.com/ws/2008/06/identity/claims/role"];
            $user_data['expire_at'] = Carbon::createFromTimestamp($user_data['exp']);

            unset($user_data["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name"]);
            unset($user_data["http://schemas.microsoft.com/ws/2008/06/identity/claims/role"]);

            $response['data']['user_data'] = $user_data;

            return response()->json([
                'access_token' => $response['data']['access_token'],
                'token_type' => $response['data']['token_type'],
                'expires_in' => $response['data']['expires_in'],
                'user_data' =>[
                    'nbf' => $response['data']['user_data']['nbf'],
                    'exp' => $response['data']['user_data']['exp'],
                    'iss' => $response['data']['user_data']['iss'],
                    'aud' => $response['data']['user_data']['aud'],
                    'username' => $response['data']['user_data']['username'],
                    'role' => $response['data']['user_data']['role'],
                    'expire_at' => $response['data']['user_data']['expire_at'],
                ]
            ]);
        }catch (ClientException $e){
            dd((string)$e->getRequest()->getBody(), (string)$e->getResponse()->getBody());
        }
    }

    private function decodeToken(string $token): array
    {
        return json_decode(
            base64_decode(
                str_replace('_', '/',
                    str_replace('-','+',
                        explode('.', $token)[1]
                    )
                )
            ),
            true
        );
    }
}
