<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 
 
use Zareismail\Gutenberg\Variable;

class ForgotPasswordForm extends Template 
{       
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        return [  
            Variable::make('method', __('Register form method')), 
            Variable::make('action', __('Register form action')), 
            Variable::make('token_field', __('Name of the csrf_token field')), 
            Variable::make('token_value', __('The csrf_token field value')), 
            Variable::make('widget_field', __('Name of the widget field')), 
            Variable::make('widget_value', __('The widget field value')),  

            Variable::make('email_field', __('Name of the email field')),  
            Variable::make('email_error', __('The email field error')),  
            Variable::make('email_value', __('The email field old value')),   
        ];
    } 
}
