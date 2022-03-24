<?php

namespace Armincms\Dashboard\Cypress\Widgets;

use Armincms\Contract\Nova\Role; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest;    
use Zareismail\Gutenberg\Gutenberg; 

class Register extends Widget
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

        $this->when($this->hasMeta('login_fragment'), function() { 
            $fragmentId = $this->metaValue('login_fragment');
            $fragment = Gutenberg::cachedFragments()->find($fragmentId);

            $this->withMeta([
                'login_page' => $fragment ? $fragment->getUrl('/') : null
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
            'action'    => route('register'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name, 
            'login_page' => $this->metaValue('login_page'),  
            'login_after_registration' => $this->metaValue('login_after_registration') ? true : false,  
            // email
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),
            'email_value' => old('email'), 
            // username
            'username_field' => 'name',
            'username_error' => $this->metaValue('errors.name'),
            'username_value' => old('name'), 
            // firstname
            'firstname_field' => 'firstname',
            'firstname_error' => $this->metaValue('errors.firstname'),
            'firstname_value' => old('firstname'),
            // lastname 
            'lastname_field' => 'lastname',
            'lastname_error' => $this->metaValue('errors.lastname'),
            'lastname_value' => old('lastname'), 
            // password
            'password_field' => 'password',
            'password_error' => $this->metaValue('errors.password'),    
            'password_confirmation_field' => 'password_confirmation',
            'password_confirmation_error' => $this->metaValue('errors.password_confirmation'),  
            'errors' => $this->metaValue('errors'),   
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
            Select::make(__('User Role'), 'config->roleId')
                ->options(Role::newModel()->get()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->nullable(),  

            Select::make(__('Redirect To'), 'config->redirectTo')
                ->options(Gutenberg::cachedWebsites()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->required()
                ->rules('required')
                ->help(__('Page that should be redirect after login.')),  

            Select::make(__('Login Page'), 'config->login_fragment')->options(function() {
                return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
            })->displayUsingLabels(),  

            Boolean::make(__('Login after registration'), 'config->login_after_registration')
                ->default(true),
        ];
    }  

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\RegisterForm::class
        );
    }
}
