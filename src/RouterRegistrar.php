<?php


namespace Floinay\LaravelJwt;

use Illuminate\Contracts\Routing\Registrar as Router;
use Floinay\LaravelJwt\Http\Controllers\LoginController;
use Floinay\LaravelJwt\Http\Controllers\RefreshToken;
use Floinay\LaravelJwt\Http\Controllers\RegisterController;

class RouterRegistrar
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function all()
    {
        $this->refreshToken();
        $this->register();
        $this->auth();
    }

    public function auth()
    {
        $this->authEmail();
        $this->authUsername();
    }

    public function register()
    {
        $this->registerEmail();
    }

    public function registerEmail()
    {
        $this->router->post('/register/email', [
            'uses' => $this->path(RegisterController::class, 'email'),
            'as'   => 'jwt.register.email'
        ]);
    }

    public function refreshToken()
    {
        $this->router->post('/token/refresh', [
            'uses' => RefreshToken::class,
            'as'   => 'jwt.token.refresh'
        ]);
    }

    public function authUsername()
    {
        $this->router->get('/auth/username', [
            'uses' => $this->path(LoginController::class, 'username'),
            'as'   => 'jwt.auth.username'
        ]);
    }

    public function authEmail()
    {
        $this->router->get('/auth/email', [
            'uses' => $this->path(LoginController::class, 'email'),
            'as'   => 'jwt.auth.email'
        ]);
    }

    private function path(string $className, string $methodName)
    {
        return "{$className}@{$methodName}";
    }
}
