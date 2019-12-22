<?php


namespace LaravelJwt\Entities;


use Illuminate\Support\Carbon;
use LaravelJwt\Options\JwtConfig;

class AccessToken
{
    private $token;
    private $expires;

    public function __construct(string $token)
    {
        $this->token   = $token;
        $this->expires = Carbon::now()->addSeconds(JwtConfig::maxAge())->timestamp;
    }

    public function toArray()
    {
        return [
            'token'   => $this->token,
            'expires' => $this->expires
        ];
    }
}
