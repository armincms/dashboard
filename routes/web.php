<?php

use Armincms\Dashboard\Http\Controllers\ProfileUpdateController; 
use Illuminate\Support\Facades\Route;
    
Route::post('/profile', [ProfileUpdateController::class, 'handle']) 
    ->name('profile.update'); 