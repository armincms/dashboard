<?php

namespace Armincms\Dashboard\Cypress\Widgets;
 
use Laravel\Nova\Fields\Select;   
use Zareismail\Gutenberg\Gutenberg; 

class ForgotPassword extends Widget
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
            'action'    => route('password.email'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name,   
            // email
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),
            'email_value' => old('email'),   
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
            Select::make(__('Reset Password Page'), 'config->reset_password_fragment')->options(function() {
                return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
            }) 
            ->displayUsingLabels()
            ->required()
            ->rules('required'),  

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
            \Armincms\Dashboard\Gutenberg\Templates\ForgotPasswordForm::class
        );
    }
}
