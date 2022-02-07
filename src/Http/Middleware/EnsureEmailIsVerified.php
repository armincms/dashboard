<?php

namespace Armincms\Dashboard\Http\Middleware;

use Armincms\Dashboard\Nova\Dashboard;
use Closure;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;   
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\URL;   
use Zareismail\Cypress\Http\Requests\ComponentRequest;
use Zareismail\Gutenberg\Gutenberg;

class EnsureEmailIsVerified  
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {  
        if (! $this->mustVerifyEmail($request)) {  
            return $next($request);
        }

        optional($request->user())->sendEmailVerificationNotification();

        return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : redirect($this->redirectTo())->withErrors([
                    'email' => 'Your email address is not verified.'
                ])->with('status', 'verification-link-sent');
    }

    /**
     * Determine if user must verify email.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return boolean          
     */
    protected function mustVerifyEmail($request)
    { 
        if (! Dashboard::mustVerifyEmail($this->website()->getKey())) {
            return false;
        }

        return ! $request->user() || (
            $request->user() instanceof MustVerifyEmail && 
            ! $request->user()->hasVerifiedEmail()
        );     
    }

    /**
     * Get the website instance.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function website()
    {
        return app(ComponentRequest::class)->resolveComponent()->website();
    } 

    /**
     * Get the email verification page.
     * 
     * @return string
     */
    public function redirectTo()
    {
        $fragmentId = Dashboard::verificationPage($this->website()->getKey()); 
        $fragment = Gutenberg::cachedFragments()->find($fragmentId);

        return optional($fragment)->getUrl() ?? '/';
    } 
}
