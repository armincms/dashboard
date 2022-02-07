<?php

namespace Armincms\Dashboard\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification; 

class ResetPassword extends Notification
{ 
    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $url)
    {
        $this->token = $token;
        $this->url = $url;
    }


    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
    	return $this->url.'?'. http_build_query([
    		'email' => $notifiable->getEmailForPasswordReset(),
    		'token' => $this->token,
    	]);
    }
}