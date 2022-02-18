<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Requests\Interfaces\RequestInterface;

class AuthTaskRequest implements RequestInterface
{
    private $username;

    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function generateUrl(): string
    {
        return "api/security/token";
    }

    /**
     * @return array
     */
    public function createRequestQueryParam(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function createRequestBody(): array
    {
        return [
            'grant_type' => config('task.grant_type'),
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
