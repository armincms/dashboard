<?php

namespace Armincms\Dashboard\Http\Controllers\Auth;

use Armincms\Dashboard\Http\Controllers\Controller;
use Armincms\Dashboard\Http\Requests\Auth\AuthRequest;
use Armincms\Dashboard\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Zareismail\Gutenberg\Gutenberg;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return redirect()->intended('/');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Armincms\Dashboard\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate(); 

        return redirect()->intended($request->redirectTo('/'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AuthRequest $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken(); 

        return redirect($request->redirectTo('/'));
    }
}
