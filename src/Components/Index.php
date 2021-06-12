<?php

namespace Armincms\Dashboard\Components;
 
use Illuminate\Http\Request;   
use Core\Document\Document; 

class Index extends Dashboard 
{        
	/**
	 * Route of Component.
	 * 
	 * @var null
	 */
	protected $route = '/'; 

	public function toHtml(Request $request, Document $docuemnt) : string
	{       
		return (string) $this->firstLayout($docuemnt, $this->config('layout'), 'clean-dashbaord')->display(); 
	}    
}
