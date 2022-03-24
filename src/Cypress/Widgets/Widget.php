<?php

namespace Armincms\Dashboard\Cypress\Widgets;
 
use Zareismail\Cypress\Http\Requests\CypressRequest;   
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\GutenbergWidget;

class Widget extends GutenbergWidget
{       
    /**
     * The logical group associated with the widget.
     *
     * @var string
     */
    public static $group = 'Authentication';

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {      
        parent::boot($request, $layout);
        
        $this->withMeta([
            'errors' => $this->validationErrors($request),
        ]); 
    } 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {
        return [];
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
