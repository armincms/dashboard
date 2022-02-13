<?php

namespace Armincms\Dashboard\Cypress\Widgets;
  
use Laravel\Nova\Fields\Select;   
use Zareismail\Gutenberg\Gutenberg; 

class Logout extends Widget
{        
    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
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
            Select::make(__('Redirect To'), 'config->redirectTo')
                ->options(Gutenberg::cachedWebsites()->keyBy->getKey()->map->name)
                ->displayUsingLabels()
                ->required()
                ->rules('required')
                ->help(__('Page that should be redirect after login.')),
        ];
    } 

    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Dashboard\Gutenberg\Templates\LoginForm::class
        );
    }
}
