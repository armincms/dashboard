<?php

namespace Armincms\Dashboard\Cypress\Widgets;
  
use Laravel\Nova\Fields\Select;  
use Zareismail\Gutenberg\Gutenberg; 

class ResetPassword extends Widget
{          
    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    { 
        return [
            // form
            'action'    => route('password.update'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'user_token_field' => 'token', 
            'user_token_value' => request('token'), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name,   
            // email   
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),  
            'email_value' => old('email', request('email')),  
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
            Select::make(__('Redirect To'), 'config->redirectTo')
                ->options(Gutenberg::cachedFragments()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->required()
                ->rules('required')
                ->help(__('Page that should be redirect after email sent.')), 
        ];
    }  

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\ResetPasswordForm::class
        );
    }
}
