<?php

namespace App\Task\Requests;

class TokenRequest implements BaseRequest
{
    private $grant_type;

    private $username;

    private $password;

    /**
     * @param $grant_type
     * @param $username
     * @param $password
     */
    public function __construct($grant_type, $username, $password)
    {
        $this->grant_type = $grant_type;
        $this->username = $username;
        $this->password = $password;
    }

    public function generateUrl(): string
    {
        return '/api/security/token';
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function generateBody(): array
    {
        return [];
    }

    public function generateQueryParams(): array
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getGrantType()
    {
        return $this->grant_type;
    }

    /**
     * @param mixed $grant_type
     */
    public function setGrantType($grant_type): void
    {
        $this->grant_type = $grant_type;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
