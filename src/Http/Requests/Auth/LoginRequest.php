<?php

namespace Armincms\Dashboard\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException; 

class LoginRequest extends AuthRequest
{ 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attemp to login.
     * 
     * @return boolean
     */
    public function attempt()
    { 
        $credentialKey = $this->credentialKey(); 

        if ($credentialKey == 'email') {
            return Auth::attempt($this->credentials('email'), $this->input('remember'));
        }

        if ($credentialKey == 'name') {
            return Auth::attempt($this->credentials('name'), $this->input('remember'));
        }

        return 
            Auth::attempt($this->credentials('email'), $this->input('remember')) ||
            Auth::attempt($this->credentials('name'), $this->input('remember'));
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited(); 

        if (! $this->attempt()) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('username')).'|'.$this->ip();
    }

    /**
     * Get the login credentials from the request.
     *
     * @return string
     */
    public function credentials(string $username)
    {
        return [
            $username => $this->input('username'),
            'password' => $this->input('password'),
        ];
    }  
}
