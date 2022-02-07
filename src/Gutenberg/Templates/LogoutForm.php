<?php

namespace Armincms\Dashboard\Gutenberg\Templates; 

use Zareismail\Gutenberg\Template; 
use Zareismail\Gutenberg\Variable;

class LogoutForm extends Template 
{       
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        return [  
            Variable::make('method', __('Loout form method')), 
            Variable::make('action', __('Loout form action')), 
            Variable::make('token_field', __('Name of the csrf_token field')), 
            Variable::make('token_value', __('The csrf_token field value')), 
            Variable::make('widget_field', __('Name of the widget field')), 
            Variable::make('widget_value', __('The widget field value')),     
        ];
    } 
}
