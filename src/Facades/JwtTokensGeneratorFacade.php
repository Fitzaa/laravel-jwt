<?php

namespace Floinay\LaravelJwt\Facades;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Facade;
use Floinay\LaravelJwt\Entities\AccessToken;
use Floinay\LaravelJwt\Entities\JwtSession;
use Floinay\LaravelJwt\Services\JwtTokensGeneratorService;

/**
 * Class JwtFacade
 * @method static AccessToken accessToken(User $user)
 * @method static JwtSession refreshToken(User $user)
 */
class JwtTokensGeneratorFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return JwtTokensGeneratorService::class;
    }
}
