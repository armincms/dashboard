<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 

use Zareismail\Gutenberg\Template; 
use Zareismail\Gutenberg\Variable;

class RegisterForm extends Template 
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

            Variable::make('username_field', __('Name of the username field')),  
            Variable::make('username_error', __('The username field error')),  
            Variable::make('username_value', __('The username field old value')),   

            Variable::make('firstname_field', __('Name of the firstname field')),  
            Variable::make('firstname_error', __('The firstname field error')),  
            Variable::make('firstname_value', __('The firstname field old value')),  

            Variable::make('lastname_field', __('Name of the lastname field')),  
            Variable::make('lastname_error', __('The lastname field error')),  
            Variable::make('lastname_value', __('The lastname field old value')),    

            Variable::make('password_field', __('Name of the password field')),  
            Variable::make('password_error', __('The password field error')), 
            Variable::make('password_confirmation_field', __(
                'Name of the password confirmation field'
            )),  
            Variable::make('password_confirmation_error', __(
                'The password confirmation field error'
            )),      
            Variable::make('login_page', __('The login page url')),      
        ];
    } 
}
