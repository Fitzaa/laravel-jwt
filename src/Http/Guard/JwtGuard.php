<?php

namespace LaravelJwt\Http\Guard;

use Ahc\Jwt\JWT;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class JwtGuard implements Guard
{
    use GuardHelpers;
    private $jwt;
    private $userProvider;
    private $request;

    public function __construct(JWT $jwt, UserProvider $userProvider, Request $request)
    {
        $this->jwt          = $jwt;
        $this->userProvider = $userProvider;
        $this->request      = $request;
        $this->user         = null;
    }


    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ( ! is_null($this->user)) {
            return $this->user;
        }

        try {
            $payload = $this->jwt->decode($this->request->bearerToken());
        } catch (\Exception $exception) {
            return null;
        }

        if ( ! empty($payload)) {
            $this->user = $this->userProvider->retrieveById($payload['id']);
        }

        return $this->user;
    }


    public function validate(array $credentials = []): bool
    {
        $this->user = $this->userProvider->retrieveByCredentials($credentials);

        return $this->user && $this->userProvider->validateCredentials($this->user, $credentials);
    }
}
