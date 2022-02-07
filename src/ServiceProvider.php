<?php

namespace Armincms\Dashboard;
 
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;   
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\Gutenberg\Gutenberg as ZareismailGutenberg;

class ServiceProvider extends RouteServiceProvider 
{  
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {  
        $this->routes(function () { 
            Route::middleware('web')
                ->prefix('auth')
                ->namespace($this->namespace)
                ->group(__DIR__.'/../routes/auth.php');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {  
        parent::register();
        $this->resources();
        $this->components();
        $this->fragments();
        $this->widgets();
        $this->templates();
        $this->menus(); 
    } 

    /**
     * Set media conversions for resources.
     * 
     * @return 
     */
    protected function conversions()
    {
        $this->app->afterResolving('conversion', function($manager) {
            $manager->extend('property-gallery', function() { 
            }); 
        });
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {  
        LaravelNova::resources([
            Nova\Dashboard::class,
        ]);
    }

    /**
     * Register the application's Gutenberg components.
     *
     * @return void
     */
    protected function components()
    {  
        ZareismailGutenberg::components([ 
            Cypress\Dashboard::class, 
        ]);
    }

    /**
     * Register the application's Gutenberg fragments.
     *
     * @return void
     */
    protected function fragments()
    {   
        ZareismailGutenberg::fragments([  
        ]);
    }

    /**
     * Register the application's Gutenberg widgets.
     *
     * @return void
     */
    protected function widgets()
    {   
        ZareismailGutenberg::widgets([ 
            Cypress\Widgets\Login::class, 
            Cypress\Widgets\Logout::class, 
            Cypress\Widgets\Register::class, 
            Cypress\Widgets\ForgotPassword::class, 
            Cypress\Widgets\ResetPassword::class, 
            Cypress\Widgets\SendEmailVerification::class, 
        ]);
    }

    /**
     * Register the application's Gutenberg templates.
     *
     * @return void
     */
    protected function templates()
    {   
        ZareismailGutenberg::templates([  
            Gutenberg\Templates\LoginForm::class,
            Gutenberg\Templates\LogoutForm::class,
            Gutenberg\Templates\RegisterForm::class,
            Gutenberg\Templates\ForgotPasswordForm::class,
            Gutenberg\Templates\ResetPasswordForm::class,
            Gutenberg\Templates\SendEmailVerificationForm::class,
        ]); 
    }

    /**
     * Register the application's menus.
     *
     * @return void
     */
    protected function menus()
    {    
        $this->app->booted(function() {   
        }); 
    }   
}
