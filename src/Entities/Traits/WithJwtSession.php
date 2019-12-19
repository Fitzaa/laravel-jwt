<?php


namespace LaravelJwt\Entities\Traits;

use LaravelJwt\Entities\JwtSession;

/***
 * Trait WithJwtSession
 * @package LaravelJwt\Entities\Traits
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait WithJwtSession
{
    public function sessions()
    {
        return $this->hasMany(JwtSession::class, 'user_id');
    }

    public function clearAllSessions(): void
    {
        $this->sessions()->delete();
    }

    public function hasActiveSessions(): bool
    {
        return $this->sessions()->exists();
    }
}
