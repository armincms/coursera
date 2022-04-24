<?php

namespace Armincms\Coursera\Nova;
 
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\BelongsTo; 
use Laravel\Nova\Fields\HasMany; 
use Laravel\Nova\Fields\ID;   
use Laravel\Nova\Fields\Number;   
use Laravel\Nova\Fields\Select;  
use Laravel\Nova\Fields\Text;   ;      

class Link extends Resource
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\CourseraLink::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'lesson', 'server'
    ];

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

            BelongsTo::make(__('Coursera Server'), 'server', Server::class)
                ->required()
                ->rules('required')
                ->withoutTrashed()
                ->showCreateRelationButton(),

            BelongsTo::make(__('Coursera Lesson'), 'lesson', Lesson::class)
                ->nullable()
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Select::make(__('Coursera Resolution'), 'resolution')
                ->options($resolutions = forward_static_call([static::$model, 'resolutions']))
                ->default(array_keys($resolutions)[0] ?? null)
                ->required()
                ->rules('required')
                ->displayUsingLabels(),

            Select::make(__('Coursera Language'), 'locale')
                ->options(collect(app('application.locales'))->pluck('name', 'locale')->all())
                ->default('fa')
                ->required()
                ->rules('required')
                ->displayUsingLabels(),

            Text::make(__('Link Path'), 'path')
                ->sortable()
                ->required()
                ->rules('required')
                ->hideFromIndex(), 

            Number::make(__('Link Order'), 'order')
                ->required()
                ->rules('required')
                ->min(0)
                ->max(99), 
        ];
    }  
}
