<?php

namespace Armincms\Dashboard\Cypress\Widgets;
 
use Armincms\Dashboard\Gutenberg\Templates\LogoutForm;
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Cypress\Widget;   
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\HasTemplate;

class Logout extends Widget
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
            'action'    => route('logout'),
            'method'    => 'post',
            'token_field' => '_token', 
            'token_value' => csrf_token(), 
            'widget_field' => '_widget', 
            'widget_value' => $this->name,  
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
            Select::make(__('Logout Form Template'), 'config->template')
                ->options(static::availableTemplates(LogoutForm::class))
                ->displayUsingLabels()
                ->required()
                ->rules('required'), 

            Select::make(__('Redirect To'), 'config->redirectTo')
                ->options(Gutenberg::cachedWebsites()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->required()
                ->rules('required')
                ->help(__('Page that should be redirect after login.')),
        ];
    } 
}
