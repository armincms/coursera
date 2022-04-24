<?php

namespace Armincms\Coursera\Nova;
 
use Illuminate\Http\Request;   
use Laravel\Nova\Fields\HasMany; 
use Laravel\Nova\Fields\ID;     
use Laravel\Nova\Fields\Text;        
use Laravel\Nova\Http\Requests\NovaRequest;      

class Server extends Resource
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\CourseraServer::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),  

            Text::make(__('Server Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required'),

            Text::make(__('Server Domain'), 'domain')
                ->sortable()
                ->required()
                ->rules('required'), 

            HasMany::make(__('Coursera Links'), 'links', Link::class), 
        ];
    }  

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
}
