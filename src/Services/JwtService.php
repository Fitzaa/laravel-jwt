<?php


namespace LaravelJwt\Services;


use Ahc\Jwt\JWT;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LaravelJwt\Entities\AccessToken;
use LaravelJwt\Entities\JwtSession;
use LaravelJwt\Options\JwtConfig;

class JwtService
{
    private $jwt;
    private $request;

    public function __construct(JWT $jwt, Request $request)
    {
        $this->jwt     = $jwt;
        $this->request = $request;
    }

    public function accessToken(User $user): AccessToken
    {
        return new AccessToken($this->jwt->encode($user->getKey()));
    }

    public function refreshToken(User $user): JwtSession
    {
        $session             = new JwtSession();
        $session->ip         = $this->request->ip();
        $session->user_agent = $this->request->userAgent();
        $session->user_id    = $user->getKey();
        $session->expires    = Carbon::now()->addSeconds(JwtConfig::maxRefreshAge())->timestamp;
        $session->saveOrFail();
        $session->refresh();

        return $session;
    }
}
