<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 

use Armincms\Contract\Models\User;
use Zareismail\Gutenberg\Template as GutenbergTemplate;  
use Zareismail\Gutenberg\Variable;

class ProfileForm extends GutenbergTemplate 
{         
    /**
     * The logical group associated with the template.
     *
     * @var string
     */
    public static $group = 'Users Dashboard';

    /**
     * Profile the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        $conversions = (new User)->conversions()->implode(',');

        return [  
            Variable::make('method', __('Profile form method')), 
            Variable::make('action', __('Profile form action')), 
            Variable::make('token_field', __('Name of the csrf_token field')), 
            Variable::make('token_value', __('The csrf_token field value')), 
            Variable::make('method_field', __('Name of the method field')), 
            Variable::make('method_value', __('The method field value')), 

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

            Variable::make('mobile_field', __('Name of the mobile field')),  
            Variable::make('mobile_error', __('The mobile field error')),  
            Variable::make('mobile_value', __('The mobile field old value')),    

            Variable::make('phone_field', __('Name of the phone field')),  
            Variable::make('phone_error', __('The phone field error')),  
            Variable::make('phone_value', __('The phone field old value')),    

            Variable::make('birthday_field', __('Name of the birthday field')),  
            Variable::make('birthday_error', __('The birthday field error')),  
            Variable::make('birthday_value', __('The birthday field old value')),    

            Variable::make('gender_field', __('Name of the gender field')),  
            Variable::make('gender_error', __('The gender field error')),  
            Variable::make('gender_value', __('The gender field old value')),   
  
            Variable::make('check_avatar_field', __('Name of the avatar check field')), 
            Variable::make('check_avatar_value', __('The avatar check field value')),     
            Variable::make('avatars', __("List of user avatar images.(conversions:{$conversions})")),  
            Variable::make('avatar_field', __('Name of the avatar uploader field')),  
            Variable::make('avatar_error', __('The avatar field error')),    

            Variable::make('old_password_field', __('Name of the old password field')),  
            Variable::make('old_password_error', __('The old password field error')), 
            Variable::make('password_field', __('Name of the password field')),  
            Variable::make('password_error', __('The password field error')), 
            Variable::make('password_confirmation_field', __(
                'Name of the password confirmation field'
            )), 
        ];
    } 
}
