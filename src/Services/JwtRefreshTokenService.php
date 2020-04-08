<?php


namespace Floinay\LaravelJwt\Services;


use Floinay\LaravelJwt\Entities\JwtSession;
use Floinay\LaravelJwt\Exceptions\WrongIpException;
use Floinay\LaravelJwt\Exceptions\WrongRefreshTokenException;
use Floinay\LaravelJwt\Exceptions\WrongUserAgentException;
use Floinay\LaravelJwt\Http\Requests\JwtRefreshTokenRequest;
use Illuminate\Foundation\Auth\User;

class JwtRefreshTokenService
{

    public function refresh(JwtRefreshTokenRequest $request): User
    {

        try {
            $session = JwtSession::whereRefreshToken($request->token)->firstOrFail();
        } catch (\Exception$exception) {
            throw new WrongRefreshTokenException("Request token '{$request->token} is not equals current session'");
        }

        $this->validateUserAgent($session, $request->userAgent());
        $this->validateIp($session, $request->ip());

        return User::whereId($session->user_id)->firstOrFail();
    }

    private function validateUserAgent(JwtSession $session, string $ua)
    {
        if ($session->user_agent && $session->user_agent !== $ua) {
            throw new WrongUserAgentException(
                "Request user agent '{$ua}' not equals current session user agent",
                403
            );
        }
    }

    private function validateIp(JwtSession $session, string $ip)
    {
        if ($session->ip !== $ip) {
            throw new WrongIpException('You ip address is not equals current session ip');
        }
    }
}
