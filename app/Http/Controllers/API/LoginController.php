<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $tokenResult;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        )
        ) {
            $this->tokenResult = $request->user()->createToken('login-token');

            return true;
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = $this->tokenResult;

        return [
            'token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'expires_at' => $token->accessToken->updated_at
                                ->addMinutes(config('airlock.expiration'))
                                ->toDateTimeString(),
        ];
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => __('auth.logout.success'),
        ];
    }
}
