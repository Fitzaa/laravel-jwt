<?php


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

trait JwtAuthenticatesUsers
{
    use AuthenticatesUsers;

    public function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return [];
    }
}
