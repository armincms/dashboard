<?php

namespace Armincms\Dashboard\Http\Controllers\Auth;

use Armincms\Contract\Models\User;
use Armincms\Dashboard\Http\Controllers\Controller;
use Armincms\Dashboard\Http\Requests\Auth\AuthRequest;
use Armincms\Dashboard\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(AuthRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]); 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'metadata::firstname' => $request->firstname,
            'metadata::lastname' => $request->lastname, 
        ]);

        if ($roleId = data_get($request->widget(), 'config.roleId')) {  
            $user->roles()->sync([$roleId]);  
        }

        event(new Registered($user));

        if (data_get($request->widget(), 'config.login_after_registration', true)) { 
            Auth::login($user);
        }

        return redirect($request->redirectTo('/'));
    }
}
