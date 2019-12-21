<?php

namespace LaravelJwt\Http\Resources;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Resources\Json\JsonResource;
use LaravelJwt\Facades\JwtFacade;

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

        return [
            'refresh' => $session->toArray(),
            'access'  => JwtFacade::accessToken($this->resource)
        ];
    }
}
