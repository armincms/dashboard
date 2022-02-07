<?php

namespace Armincms\Dashboard\Http\Controllers\Auth;

use Armincms\Dashboard\Http\Requests\Auth\AuthRequest;
use Armincms\Dashboard\Http\Controllers\Controller; 
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Zareismail\Gutenberg\Gutenberg;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(AuthRequest $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]); 

        ResetPassword::createUrlUsing(function($user, $token) use ($request) {  
            $fragmentId = data_get($request->widget(), 'config.reset_password_fragment');
            $fragment = Gutenberg::cachedFragments()->find($fragmentId);

            throw_unless($fragment, __('Missing reset password page'));

            return $fragment->getUrl().'?'.http_build_query([
                'email' => $user->getEmailForPasswordReset(),
                'token' => $token,
            ]);
        });

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($request->only('email'));

        return $status == Password::RESET_LINK_SENT
                    ? redirect($this->redirectTo($request))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    /**
     * Get the redirect url.
     * 
     * @return string
     */
    public function redirectTo($request)
    {
        $fragmentId = data_get($request->widget(), 'config.redirectTo');
        $fragment = Gutenberg::cachedFragments()->find($fragmentId);

        return optional($fragment)->getUrl() ?? '/';
    }
}
