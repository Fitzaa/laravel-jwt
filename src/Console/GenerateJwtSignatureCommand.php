<?php

namespace Floinay\LaravelJwt\Console;

use Floinay\LaravelJwt\Exceptions\EnvironmentNotExistsException;
use Floinay\LaravelJwt\Exceptions\JwtSignatureExistsException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateJwtSignatureCommand extends Command
{
    protected $signature = 'jwt:secret';

    protected $description = 'Set random signature to your .env file';

    public function handle()
    {
        $envPath = $this->envPath();
        if ( ! file_exists($envPath)) {
            throw new EnvironmentNotExistsException('Please Create .env file and run this command');
        }

        if ($this->signatureExists($envPath)) {
            throw new JwtSignatureExistsException('JWT_SIGNATURE exists in .env file');
        }

        $key = $this->publishKey($envPath);
        $this->info($key);
    }

    protected function envPath()
    {
        return $this->getLaravel()->basePath('.env');
    }

    protected function publishKey(string $path): string
    {
        $key = Str::random(64);
        file_put_contents($path, PHP_EOL . "JWT_SIGNATURE={$key}" . PHP_EOL, FILE_APPEND);

        return $key;
    }

    protected function signatureExists(string $path): bool
    {
        return Str::contains(file_get_contents($path), 'JWT_SIGNATURE');
    }
}
