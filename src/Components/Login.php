<?php

namespace Armincms\Dashboard\Components;
 
use Illuminate\Http\Request; 
use Core\HttpSite\Component; 
use Core\HttpSite\Concerns\IntractsWithLayout;
use Core\Document\Document; 

class Login extends Component 
{       
	use IntractsWithLayout;
 	
	protected $route = '/login';

	public function toHtml(Request $request, Document $docuemnt) : string
	{        
		return (string) $this->firstLayout($docuemnt, $this->config('layout', 'clean-login'))->display(); 
	}     
}
