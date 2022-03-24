<?php

namespace Armincms\Dashboard\Http\Requests\Auth;
 
use Illuminate\Foundation\Http\FormRequest; 
use Zareismail\Gutenberg\Gutenberg;

class AuthRequest extends FormRequest
{ 
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ 
        ];
    } 

    /**
     * Get the login field.
     * 
     * @return string
     */
    public function credentialKey()
    {
        return data_get($this->widget(), 'config.credentials');
    }

    /**
     * Get the redirect url.
     * 
     * @return string
     */
    public function redirectTo($default = '/')
    {
        $websiteId = data_get($this->widget(), 'config.redirectTo');
        $website = Gutenberg::cachedWebsites()->find($websiteId);

        return optional($website)->getUrl() ?? $default;
    }

    /**
     * Get the widget for the given request.
     * 
     * @return \Illuminate\DAtabase\Eloquent\Model
     */
    public function widget()
    {
        return Gutenberg::cachedWidgets()->first(function($widget) {
            return $widget->uriKey() === $this->input('_widget');
        });
    }
}
