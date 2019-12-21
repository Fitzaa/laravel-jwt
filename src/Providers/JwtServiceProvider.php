<?php

namespace LaravelJwt\Providers;

use Ahc\Jwt\JWT;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use LaravelJwt\Jwt as JwtBase;
use LaravelJwt\Options\JwtConfig;

class JwtServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = __DIR__ . '/../config/jwt.php';
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom([__DIR__ . '/../migrations/create_sessions_table.php']);
        $this->publishes([$configPath => config_path('jwt.php')], 'config');
        $this->mergeConfigFrom($configPath, 'jwt');
        $this->extendAuth();
    }

    public function register()
    {
        $this->app->singleton(JWT::class, function () {
            return new JWT(
                JwtConfig::signature(),
                config('jwt.algorithm'),
                JwtConfig::maxAge(),
                config('jwt.leeway'));
        });
    }

    private function extendAuth()
    {
        Auth::extend('jwt', function (Application $app, $name, array $config) {
            $jwt     = $app->make(JWT::class);
            $request = $app->make(Request::class);

            return new JwtGuard($jwt, Auth::createUserProvider($config['provider']), $request);
        });
    }
}
