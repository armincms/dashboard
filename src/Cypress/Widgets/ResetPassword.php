<?php

namespace Armincms\Dashboard\Cypress\Widgets;

use Armincms\Contract\Nova\Role;
use Armincms\Dashboard\Gutenberg\Templates\ResetPasswordForm;
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Widget;   
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\HasTemplate;

class ResetPassword extends Widget
{        
    use HasTemplate;

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {     
        $this->when($this->hasMeta('template'), function() use ($request, $layout) { 
            $this->bootstrapTemplate($request, $layout);   
        }, function() {
            $this->renderable(false);
        }); 

        $this->withMeta([
            'errors' => $this->validationErrors($request),
        ]); 
    }

    /**
     * Get the template id.
     * 
     * @return integer
     */
    public function getTemplateId(): int
    { 
        return $this->metaValue('template');
    } 

    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForTemplate(): array
    { 
        return [
            // form
            'action'    => route('password.update'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'user_token_field' => 'token', 
            'user_token_value' => request('token'), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name,   
            // email   
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),  
            'email_value' => old('email', request('email')),  
            // password   
            'password_field' => 'password',
            'password_error' => $this->metaValue('errors.password'),    
            'password_confirmation_field' => 'password_confirmation',
            'password_confirmation_error' => $this->metaValue('errors.password_confirmation'), 
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
            Select::make(__('Reset Password Form Template'), 'config->template')
                ->options(static::availableTemplates(ResetPasswordForm::class))
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

    protected function validationErrors(CypressRequest $request)
    {
        if (is_null($errors = $request->session()->get('errors'))) {
            return [];
        }

        return collect($errors->messages())->map(function($errors, $field) {
            return $errors[0] ?? null;
        })->toArray();
    }
}
