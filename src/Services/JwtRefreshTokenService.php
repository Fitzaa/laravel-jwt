<?php


namespace Floinay\LaravelJwt\Services;


use Floinay\LaravelJwt\Entities\JwtSession;
use Floinay\LaravelJwt\Exceptions\LockedSessionException;
use Floinay\LaravelJwt\Exceptions\PastSessionException;
use Floinay\LaravelJwt\Exceptions\WrongIpException;
use Floinay\LaravelJwt\Exceptions\WrongRefreshTokenException;
use Floinay\LaravelJwt\Exceptions\WrongUserAgentException;
use Floinay\LaravelJwt\Http\Requests\JwtRefreshTokenRequest;
use Illuminate\Foundation\Auth\User;

class JwtRefreshTokenService
{

    public function refresh(JwtRefreshTokenRequest $request): User
    {
        $session = $this->getSessionByToken($request->token);
        $this->checkUserAgent($session, $request->userAgent());
        $this->checkIp($session, $request->ip());
        $this->checkDate($session);
        $this->checkIsActive($session);
        $session->lock();

        return User::whereId($session->user_id)->firstOrFail();
    }

    public function getSessionByToken(string $token): JwtSession
    {
        try {
            $session = JwtSession::whereRefreshToken($token)->firstOrFail();
        } catch (\Exception$exception) {
            throw new WrongRefreshTokenException("Request token '{$token} is not equals current session'");
        }

        return $session;
    }

    private function checkUserAgent(JwtSession $session, string $ua)
    {
        if ($session->user_agent && ! strcmp($session->user_agent, $ua)) {
            throw new WrongUserAgentException(
                "Request user agent '{$ua}' not equals current session user agent",
                403
            );
        }
    }

    private function checkIsActive(JwtSession $session)
    {
        if ($session->isLocked()) {
            throw new LockedSessionException('This session is locked');
        }
    }

    private function checkDate(JwtSession $session)
    {
        if ($session->isPast()) {
            throw new PastSessionException("The token {$session->refresh_token} is past");
        }
    }

    private function checkIp(JwtSession $session, string $ip)
    {
        if ( ! strcmp($ip, $session->ip)) {
            throw new WrongIpException('You ip address is not equals current session ip');
        }
    }
}
