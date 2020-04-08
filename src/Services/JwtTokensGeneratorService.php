<?php


namespace Floinay\LaravelJwt\Services;


use Ahc\Jwt\JWT;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Floinay\LaravelJwt\Entities\AccessToken;
use Floinay\LaravelJwt\Entities\JwtSession;
use Floinay\LaravelJwt\Options\JwtConfig;

class JwtTokensGeneratorService
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
        return new AccessToken($this->jwt->encode(['id' => $user->getKey()]));
    }

    public function refreshToken(User $user): JwtSession
    {
        $session                = new JwtSession();
        $session->ip            = $this->request->ip();
        $session->user_agent    = $this->request->userAgent();
        $session->refresh_token = uniqid('refresh');
        $session->user_id       = $user->getKey();
        $session->expires       = Carbon::now()->addSeconds(JwtConfig::maxRefreshAge())->timestamp;
        $session->saveOrFail();
        $session->refresh();

        return $session;
    }
}
