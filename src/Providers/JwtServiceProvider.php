<?php

namespace LaravelJwt\Providers;

use Ahc\Jwt\JWT;
use Illuminate\Support\ServiceProvider;

class JwtServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = __DIR__ . '/../config/jwt.php';
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom([__DIR__ . '/../migrations/create_sessions_table.php']);
        $this->publishes([$configPath => config_path('jwt.php')], 'config');
        $this->mergeConfigFrom($configPath, 'jwt');
    }

    public function register()
    {
        $this->app->singleton(JWT::class, function () {
            return new JWT(
                config('jwt.signature'),
                config('jwt.algorithm'),
                config('jwt.max_age'),
                config('jwt.leeway'));
        });
    }
}