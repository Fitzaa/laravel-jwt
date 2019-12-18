<?php

namespace LaravelJwt\Http\Guard;

use Ahc\Jwt\JWT;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class JwtMiddleware implements Guard
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
     * @inheritDoc
     */
    public function guest()
    {
        // TODO: Implement guest() method.
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->user;
    }



    public function validate(array $credentials = []): bool
    {
        $this->user = $this->userProvider->retrieveByCredentials($credentials);

        return $this->user && $this->userProvider->validateCredentials($this->user, $credentials);
    }

    /**
     * @inheritDoc
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
