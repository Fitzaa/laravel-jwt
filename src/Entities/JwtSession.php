<?php

namespace Floinay\LaravelJwt\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class JwtSession
 * @property int $id
 * @property int $user_id
 * @property string user_agent
 * @property string $ip
 * @property string $refresh_token
 * @property boolean $active
 * @property int $expires
 */
class JwtSession extends Model
{
    protected $table = 'jwt_sessions';

    public function lock()
    {
        $this->active = false;
        $this->update();
    }

    public function isActive()
    {
        return $this->isNotPast() && $this->isNotLocked();
    }

    public function isNotPast()
    {
        return ! $this->isPast();
    }

    public function isPast()
    {
        return Carbon::parse($this->expires)->isPast();
    }

    public function isLocked()
    {
        return ! $this->active;
    }

    public function isNotLocked()
    {
        return $this->active;
    }

    public function toArray()
    {
        return [
            'token'   => $this->refresh_token,
            'expires' => $this->expires
        ];
    }
}
