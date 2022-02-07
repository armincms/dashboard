<?php 

namespace Armincms\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{  
    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    	'dashboard' => 'json',
    ];
}