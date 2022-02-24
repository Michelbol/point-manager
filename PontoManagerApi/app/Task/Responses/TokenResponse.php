<?php

namespace App\Task\Responses;

class TokenResponse
{
    private $access_token;

    private $expires_in;

    private $token_type;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->access_token = $response['data']['access_token'];
        $this->expires_in = $response['data']['expires_in'];
        $this->token_type = $response['data']['token_type'];
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
}
