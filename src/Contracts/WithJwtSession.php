<?php


namespace LaravelJwt\Http\Contracts;


use Illuminate\Database\Eloquent\Relations\HasMany;

interface WithJwtSession
{
    public function sessions(): HasMany;
}
