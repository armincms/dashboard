<?php

namespace Armincms\Dashboard\Components;
 
use Illuminate\Http\Request; 
use Core\HttpSite\Component; 
use Core\HttpSite\Concerns\IntractsWithLayout;
use Core\Document\Document; 

abstract class Dashboard extends Component 
{       
	use IntractsWithLayout;

	protected $route = '/'; 
 
	public function toHtml(Request $request, Document $docuemnt) : string
	{        
		return (string) $this->firstLayout($docuemnt, $this->config('layout'), 'clean-cart')->display(); 
	}     
}
