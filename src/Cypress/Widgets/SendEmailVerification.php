<?php

namespace Armincms\Dashboard\Cypress\Widgets; 

class SendEmailVerification extends Widget
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
            'action'    => route('verification.send'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(),  
            'widget_field' => '_widget', 
            'widget_value' => $this->name,   
            'email_sent' => session('status') == 'verification-link-sent',   
            // email   
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),  
            'email_value' => old('email', request('email')),  
            'errors' => $this->metaValue('errors'), 
        ];
    }

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\SendEmailVerificationForm::class
        );
    } 
}
