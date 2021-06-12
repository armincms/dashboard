<?php

namespace Armincms\Dashboard;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Support\ServiceProvider;   
use Illuminate\Support\Facades\Route;   

class DashboardServiceProvider extends ServiceProvider implements DeferrableProvider
{   
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Site::push('profile', function($profile) {
            $profile->directory('profile')->pushMiddleware(Http\Middleware\Authenticate::class);
   
            $profile->pushComponent(new Components\Index);  
        });

        \Site::push('login-register', function($profile) {   
            $profile->directory('login-register');

            $profile->pushComponent(new Components\Login);   
        }); 

        Route::middleware('web')->post('attempt-login', [
            'uses'  => Http\Controllers\LoginController::class.'@login',
            'as'    => 'login-register.attempt',
        ]);

        Route::middleware('web')->post('login-register/logout', [
            'uses'  => Http\Controllers\LoginController::class.'@logout',
            'as'    => 'login-register.logout',
        ]);

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [
            \Illuminate\Console\Events\ArtisanStarting::class, 
            \Core\HttpSite\Events\ServingFront::class, 
        ];
    }
}
