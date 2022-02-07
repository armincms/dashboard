<?php

namespace Armincms\Dashboard\Cypress\Widgets;

use Armincms\Contract\Nova\Role;
use Armincms\Dashboard\Gutenberg\Templates\ForgotPasswordForm;
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Widget;   
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\HasTemplate;

class ForgotPassword extends Widget
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
            'action'    => route('password.email'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name,   
            // email
            'email_field' => 'email',
            'email_error' => $this->metaValue('errors.email'),
            'email_value' => old('email'),   
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
            Select::make(__('Forgot Password Form Template'), 'config->template')
                ->options(static::availableTemplates(ForgotPasswordForm::class))
                ->displayUsingLabels()
                ->required()
                ->rules('required'),  

            Select::make(__('Reset Password Page'), 'config->reset_password_fragment')->options(function() {
                return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
            }) 
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
