<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 
 
use Zareismail\Gutenberg\Variable;

class LoginForm extends Template 
{       
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        return [  
            Variable::make('method', __('Login form method')), 
            Variable::make('action', __('Login form action')), 
            Variable::make('token_field', __('Name of the csrf_token field')), 
            Variable::make('token_value', __('The csrf_token field value')), 
            Variable::make('widget_field', __('Name of the widget field')), 
            Variable::make('widget_value', __('The widget field value')), 

            Variable::make('username_field', __('Name of the username/email field')),  
            Variable::make('username_error', __('The username/email field error')),  
            Variable::make('username_value', __('The username/email field old value')),  

            Variable::make('password_field', __('Name of the password field')),  
            Variable::make('password_error', __('The password field error')),     

            Variable::make('remember_field', __('Name of the remember field')),   
            Variable::make('remember_checked', __('The remember field checked status')),   
            Variable::make('registration_page', __('The registration page url')),   
        ];
    } 
}
