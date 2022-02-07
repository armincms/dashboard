<?php

namespace Armincms\Dashboard\Nova;

use Alvinhu\ChildSelect\ChildSelect; 
use Armincms\Contract\Nova\Bios;
use Armincms\Contract\Nova\Localization;
use Armincms\Contract\Nova\Role;
use Armincms\Dashboard\Cypress\Dashboard as Website;
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Select;
use Zareismail\Gutenberg\Gutenberg;

class Dashboard extends Bios
{ 
    use Localization;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Dashboard\Models\Option::class; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
        return Gutenberg::cachedWebsites()->where('component', Website::class)->flatMap(function($website) {
            return [
                Heading::make($website->name),

                Select::make(__('Website'), "dashboard_{$website->id}_website")->options(function() {
                    return Gutenberg::cachedWebsites()->keyBy->getKey()->map->name;
                })
                ->required()
                ->rules('required')
                ->displayUsingLabels(),

                Select::make(__('Page'), "dashboard_{$website->id}_fragment")->options(function() {
                    return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
                })
                ->required()
                ->rules('required')
                ->displayUsingLabels()
                ->exceptOnForms(), 

                ChildSelect::make(__('Login Page'), "dashboard_{$website->id}_fragment")->options(function ($website) {   
                    return Gutenberg::cachedFragments()->where('website_id', $website)->keyBy->getKey()->map->name;
                })
                ->parent("dashboard_{$website->id}_website")
                ->required()
                ->rules('required')
                ->hideFromDetail(),

                Select::make(__('Role'), "dashboard_{$website->id}_role")->options(function() {
                    return Role::newModel()->get()->keyBy->getKey()->map->name;
                })->nullable()->displayUsingLabels(), 

                Select::make(__('Verification website'), "dashboard_{$website->id}_verification_website")->options(function() {
                    return Gutenberg::cachedWebsites()->keyBy->getKey()->map->name;
                })
                ->required()
                ->rules('required')
                ->displayUsingLabels(),

                Select::make(__('Verification page'), "dashboard_{$website->id}_verification_fragment")->options(function() {
                    return Gutenberg::cachedFragments()->keyBy->getKey()->map->name;
                })
                ->required()
                ->rules('required')
                ->displayUsingLabels()
                ->exceptOnForms(), 

                ChildSelect::make(__('Verification Page'), "dashboard_{$website->id}_verification_fragment")->options(function ($website) {   
                    return Gutenberg::cachedFragments()->where('website_id', $website)->keyBy->getKey()->map->name;
                })
                ->parent("dashboard_{$website->id}_verification_website")
                ->required()
                ->rules('required')
                ->hideFromDetail(),

                Boolean::make(__('Must verify email'), "dashboard_{$website->id}_must_verify_email")
            ]; 
        })->values()->toArray();
    }  

    /**
     * Get login page for the given website id.
     * 
     * @param  integer $websiteId 
     * @return integer            
     */
    public static function loginPage($websiteId)
    {
        return static::option("dashboard_{$websiteId}_fragment");
    }

    /**
     * Get user role for the given website id.
     * 
     * @param  integer $websiteId 
     * @return integer            
     */
    public static function userRole($websiteId)
    {
        return static::option("dashboard_{$websiteId}_role");
    }

    /**
     * Get verification page for the given website id.
     * 
     * @param  integer $websiteId 
     * @return integer            
     */
    public static function verificationPage($websiteId)
    {
        return static::option("dashboard_{$websiteId}_verification_fragment");
    }

    /**
     * Get verification page for the given website id.
     * 
     * @param  integer $websiteId 
     * @return integer            
     */
    public static function mustVerifyEmail($websiteId)
    {
        return static::option("dashboard_{$websiteId}_must_verify_email", false);
    }
}
