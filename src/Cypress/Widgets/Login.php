<?php

namespace Armincms\Dashboard\Cypress\Widgets;
   
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest;  
use Zareismail\Gutenberg\Gutenberg; 

class Login extends Widget
{      
    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {      
        parent::boot($request, $layout);

        $this->when($this->hasMeta('register_fragment'), function() {  
            $registration = Gutenberg::cachedFragments()->find($this->metaValue('register_fragment'));
            $forgot = Gutenberg::cachedFragments()->find($this->metaValue('forgot_password_fragment'));

            $this->withMeta([
                'registration_page' => $registration ? $registration->getUrl('/') : null,
                'forgot_password_page' => $forgot ? $forgot->getUrl('/') : null,
            ]);
        }); 
    } 

    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    {   
        return [
            // form
            'action'    => route('login'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name, 
            'registration_page' => $this->metaValue('registration_page'),  
            'forgot_password_page' => $this->metaValue('forgot_password_page'),  
            // username
            'username_field' => 'username',
            'username_error' => $this->metaValue('errors.username'),
            'username_value' => old('username'), 
            // password
            'password_field' => 'password',
            'password_error' => $this->metaValue('errors.password'),    
            'remember_field' => 'remember', 
            // remember me
            'remember_value' => 'remember_me', 
            'remember_checked' => old('remember') == 'remember_me',  
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {
        return [  
            Select::make(__('Can Login By'), 'config->credentials')
                ->options([
                    'name' => __('Username'),
                    'email' => __('Email'),
                    'both' => __('Email And Username'),
                ])
                ->displayUsingLabels()
                ->required()
                ->rules('required'),

            Select::make(__('Redirect To'), 'config->redirectTo')
                ->options(Gutenberg::cachedWebsites()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->required()
                ->rules('required')
                ->help(__('Page that should be redirect after login.')),        

            Select::make(__('Registration Page'), 'config->register_fragment')->options(function() {
                return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
            })->displayUsingLabels(),  

            Select::make(__('Forgot password Page'), 'config->forgot_password_fragment')->options(function() {
                return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
            })->displayUsingLabels(),  
        ];
    }  

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\LoginForm::class
        );
    }
}
