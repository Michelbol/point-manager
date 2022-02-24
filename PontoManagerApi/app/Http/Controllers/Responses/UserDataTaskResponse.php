<?php

namespace App\Http\Controllers\Responses;

use Carbon\Carbon;

class UserDataTaskResponse
{
    const USERNAME_KEY = 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name';
    const ROLE_KEY = 'http://schemas.microsoft.com/ws/2008/06/identity/claims/role';
    private $nbf;
    private $exp;
    private $iss;
    private $aud;
    private $username;
    private $role;
    private $expire_at;

    /**
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $user_data = $this->decodeToken($accessToken);
        $this->nbf = $user_data['nbf'];
        $this->exp = $user_data['exp'];
        $this->iss = $user_data['iss'];
        $this->aud = $user_data['aud'];
        $this->username = $user_data[self::USERNAME_KEY];
        $this->role = $user_data[self::ROLE_KEY];
        $this->expire_at = Carbon::createFromTimestamp($user_data['exp']);
    }

    /**
     * @return mixed
     */
    public function getNbf()
    {
        return $this->nbf;
    }

    /**
     * @return mixed
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * @return mixed
     */
    public function getIss()
    {
        return $this->iss;
    }

    /**
     * @return mixed
     */
    public function getAud()
    {
        return $this->aud;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getExpireAt()
    {
        return $this->expire_at;
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
