<?php

namespace Floinay\LaravelJwt\Http\Resources;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Floinay\LaravelJwt\Facades\JwtFacade;

/**
 * Class JwtTokenResource
 * @mixin User
 */
class JwtTokenResource extends JsonResource
{
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $session = JwtFacade::refreshToken($this->resource);
        $access  = JwtFacade::accessToken($this->resource);

        return [
            'refresh' => $session->toArray(),
            'access'  => $access->toArray()
        ];
    }
}
