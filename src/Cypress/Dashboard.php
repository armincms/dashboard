<?php

namespace Armincms\Dashboard\Cypress;

use Armincms\Dashboard\Nova\Dashboard as Bios;
use Zareismail\Cypress\Component; 
use Zareismail\Cypress\Contracts\Resolvable;
use Zareismail\Cypress\Http\Requests\CypressRequest;

class Dashboard extends Component implements Resolvable
{     
    /**
     * Resolve the resoruce's value for the given request.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest  $request 
     * @return void
     */
    public function resolve($request): bool
    {   
        $this->canSee(function() use ($request) {
            if (is_null($user = $request->user())) return true; 

            $roleId = Bios::userRole($this->website()->getKey());

            return $user->roles()->whereKey($roleId)->exists();
        });

        return true;
    }

    /**
     * Get the component fragments.
     *
     * @return string
     */
    public function fragments(): array
    {
        return [
        ];
    }

    /**
     * Get the route middlewares.
     *
     * @return string
     */
    public static function middlewares(): array
    {  
        return [
            \Armincms\Dashboard\Http\Middleware\Authenticate::class,
            \Armincms\Dashboard\Http\Middleware\EnsureEmailIsVerified::class, 
        ];
    }
}
