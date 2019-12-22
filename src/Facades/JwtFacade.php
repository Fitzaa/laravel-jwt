<?php

namespace LaravelJwt\Facades;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Facade;
use LaravelJwt\Entities\AccessToken;
use LaravelJwt\Entities\JwtSession;
use LaravelJwt\Services\JwtService;

/**
 * Class JwtFacade
 * @method static AccessToken accessToken(User $user)
 * @method static JwtSession refreshToken(User $user)
 */
class JwtFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return JwtService::class;
    }
}
