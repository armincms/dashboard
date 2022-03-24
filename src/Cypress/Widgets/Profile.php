<?php

namespace Armincms\Dashboard\Cypress\Widgets;
 
use Zareismail\Cypress\Http\Requests\CypressRequest;   
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\GutenbergWidget;

class Profile extends Widget
{       
    /**
     * The logical group associated with the widget.
     *
     * @var string
     */
    public static $group = 'Users Dashboard';  

    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    {    
        return [
            // form
            'action'    => route('profile.update'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            // email
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),
            'email_value' => old('email', $this->value('email')), 
            // username
            'username_field' => 'name',
            'username_error' => $this->metaValue('errors.name'),
            'username_value' => old('name', $this->value('name')), 
            // firstname
            'firstname_field' => 'firstname',
            'firstname_error' => $this->metaValue('errors.firstname'),
            'firstname_value' => old('firstname', $this->value('firstname')),
            // lastname 
            'lastname_field' => 'lastname',
            'lastname_error' => $this->metaValue('errors.lastname'),
            'lastname_value' => old('lastname', $this->value('lastname')), 
            // mobile 
            'mobile_field' => 'mobile',
            'mobile_error' => $this->metaValue('errors.mobile'),
            'mobile_value' => old('mobile', $this->value('mobile')), 
            // phone 
            'phone_field' => 'phone',
            'phone_error' => $this->metaValue('errors.phone'),
            'phone_value' => old('phone', $this->value('phone')), 
            // birthday 
            'birthday_field' => 'birthday',
            'birthday_error' => $this->metaValue('errors.birthday'),
            'birthday_value' => old('birthday', $this->value('birthday')), 
            // gender 
            'gender_field' => 'gender',
            'gender_error' => $this->metaValue('errors.gender'),
            'gender_value' => old('gender', $this->value('gender')),
            // avatar 
            'avatar' => $avatar = $this->value('avatar'),
            'check_avatar_field' => 'hasAvatar',
            'check_avatar_value' => ! empty($avatar),
            'hasAvatar' => ! empty($avatar),
            'avatar_field' => 'avatar', 
            'avatar_error' => $this->metaValue('errors.avatar'),
            // password
            'password_field' => 'password',
            'password_error' => $this->metaValue('errors.password'),    
            'password_confirmation_field' => 'password_confirmation',
            'password_confirmation_error' => $this->metaValue('errors.password_confirmation'),  
            'errors' => $this->metaValue('errors'),
            'message' => session('message'),  
        ];
    }

    protected function value($key, $default = null)
    {
        return data_get(
            request()->user()->serializeForWidget($this->getRequest()), 
            $key, 
            $default
        );
    } 

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\ProfileForm::class
        );
    } 
}
