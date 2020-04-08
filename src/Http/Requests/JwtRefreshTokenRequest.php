<?php


namespace Floinay\LaravelJwt\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class JwtRefreshTokenRequest
 * @package Floinay\LaravelJwt\Http\Requests
 * @property string $token
 */
class JwtRefreshTokenRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string'
        ];
    }
}
