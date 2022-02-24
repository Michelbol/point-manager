<?php

namespace App\Http\Controllers\Responses;

use App\Models\User;
use App\Task\Responses\TokenResponse;

class AuthTaskResponse implements ResponseInterface
{
    private $expires_in;

    private $user_data;

    private $user;

    /**
     * @param TokenResponse $response
     * @param User $user
     */
    public function __construct(TokenResponse $response, User $user)
    {
        $this->expires_in = $response->getExpiresIn();
        $this->user_data = new UserDataTaskResponse($response->getAccessToken());
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @param mixed $expires_in
     */
    public function setExpiresIn($expires_in): void
    {
        $this->expires_in = $expires_in;
    }

    /**
     * @return UserDataTaskResponse
     */
    public function getUserData()
    {
        return $this->user_data;
    }

    /**
     * @param UserDataTaskResponse $user_data
     */
    public function setUserData(UserDataTaskResponse $user_data): void
    {
        $this->user_data = $user_data;
    }

    public function toArray(): array
    {
        return [
            'expires_in' => $this->expires_in,
            'user_data' => [
                'id' => $this->user->id,
                'nbf' => $this->user_data->getNbf(),
                'exp' => $this->user_data->getExp(),
                'iss' => $this->user_data->getIss(),
                'aud' => $this->user_data->getAud(),
                'username' => $this->user_data->getUsername(),
                'role' => $this->user_data->getRole(),
                'expire_at' => $this->user_data->getExpireAt()
            ]
        ];
    }
}
