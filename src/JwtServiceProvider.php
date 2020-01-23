<?php

namespace Floinay\LaravelJwt;

use Ahc\Jwt\JWT;
use Floinay\LaravelJwt\Console\GenerateJwtSignatureCommand;
use Floinay\LaravelJwt\Guards\JwtGuard;
use Floinay\LaravelJwt\Options\JwtConfig;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class JwtServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = __DIR__ . '/../config/jwt.php';
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom([__DIR__ . '/../database/migrations/2019_31_12_0001_create_sessions_table.php']);
        $this->publishes([$configPath => config_path('jwt.php')], 'config');
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
        $this->registerCommands();
    }

    private function extendAuth()
    {
        Auth::extend('jwt', function (Application $app, $name, array $config) {
            $jwt     = $app->make(JWT::class);
            $request = $app->make(Request::class);

            return new JwtGuard($jwt, Auth::createUserProvider($config['provider']), $request);
        });
    }

    private function registerCommands()
    {
        $this->commands([
            GenerateJwtSignatureCommand::class
        ]);
    }
}
