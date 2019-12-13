<?php

namespace LaravelJwt;

use Illuminate\Support\ServiceProvider;

class JwtServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom([__DIR__ . '/migrations/create_sessions_table.php']);
    }

    public function register()
    {
        parent::register();
    }
}
