<?php

namespace App\Task\Responses;

class TokenResponse
{
    private $access_token;

    private $expires_in;

    /**
     * @param $access_token
     * @param $expires_in
     * @param $token_type
     */
    public function __construct($access_token, $expires_in, $token_type)
    {
        $this->access_token = $access_token;
        $this->expires_in = $expires_in;
        $this->token_type = $token_type;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token): void
    {
        $this->access_token = $access_token;
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
     * @return mixed
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * @param mixed $token_type
     */
    public function setTokenType($token_type): void
    {
        $this->token_type = $token_type;
    }
    private $token_type;
}
