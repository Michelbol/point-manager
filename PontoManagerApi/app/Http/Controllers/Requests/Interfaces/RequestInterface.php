<?php

namespace App\Http\Controllers\Requests\Interfaces;

interface RequestInterface
{
    /**
     * @return string
     */
    public function generateUrl(): string;

    /**
     * @return array
     */
    public function createRequestQueryParam(): array;

    /**
     * @return array
     */
    public function createRequestBody(): array;
}
