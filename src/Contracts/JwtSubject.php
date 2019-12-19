<?php

namespace LaravelJwt\Http\Contracts;

interface JwtSubject
{
    /**
     * What data to save in the token data.
     * @return array
     */
    public function getJwtPayload(): array;

    /**
     * By default do return $this->getKey();
     * @return string
     */
    public function getJwtIdentifier(): string;
}
