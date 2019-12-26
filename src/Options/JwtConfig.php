<?php


namespace Floinay\LaravelJwt\Options;


use Floinay\LaravelJwt\Exceptions\EmptySignatureException;

class JwtConfig
{
    public static function signature(): string
    {
        $signature = config('signature');

        throw_if(
            empty($signature),
            EmptySignatureException::class,
            'jwt.signature is empty'
        );

        return $signature;
    }

    public static function maxRefreshAge(): int
    {
        return (int)config('jwt.max_refresh_age', 3600 * 60);
    }

    public static function maxAge(): int
    {
        return (int)config('jwt.max_age', 3600);
    }
}
