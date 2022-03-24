<?php

namespace Armincms\Dashboard\Http\Controllers;

use Armincms\Dashboard\Http\Requests\ProfileUpdateRequest;

class ProfileUpdateController extends Controller
{  
    /**
     * Update the user profile
     * 
     * @return array
     */
    public function handle(ProfileUpdateRequest $request)
    {
        $request->updateUserProfile();

        return back()->withMessage(__('Your profile is up to date.'));
    }
}
