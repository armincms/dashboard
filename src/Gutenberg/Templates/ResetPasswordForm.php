<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 

use Zareismail\Gutenberg\Template; 
use Zareismail\Gutenberg\Variable;

class ResetPasswordForm extends Template 
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
            Variable::make('user_token_field', __('Name of the user token field')), 
            Variable::make('user_token_value', __('The user token field value')), 
            Variable::make('widget_field', __('Name of the widget field')), 
            Variable::make('widget_value', __('The widget field value')), 

            Variable::make('password_field', __('Name of the password field')),  
            Variable::make('password_error', __('The password field error')),   
            Variable::make('password_confirmation_field', __('Name of the password confirmation field')),  
            Variable::make('password_confirmation_value', __('The password confirmation field error')),   
        ];
    } 
}
