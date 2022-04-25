<?php

namespace Armincms\Coursera\Nova;
 
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\BelongsTo; 
use Laravel\Nova\Fields\HasMany; 
use Laravel\Nova\Fields\ID;   
use Laravel\Nova\Fields\Number;   
use Laravel\Nova\Fields\Text;  
use Laravel\Nova\Fields\Textarea;      

class Episode extends Resource
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\CourseraEpisode::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'course'
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

            BelongsTo::make(__('Coursera Course'), 'course', Course::class)
                ->required()
                ->rules('required')
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Text::make(__('Episode Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required'), 

            Number::make(__('Episode Order'), 'order')
                ->required()
                ->rules('required')
                ->min(0)
                ->max(99),

            $this->medialibrary(__('Episode Image')),

            Textarea::make(__('Episode Summary'), 'summary')->hideFromIndex()->nullable(),

            HasMany::make(__('Coursera Lessons'), 'lessons', Lesson::class),
        ];
    }  
}
