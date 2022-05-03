<?php

namespace Armincms\Coursera\Cypress\Widgets;
 
use Armincms\Coursera\Nova\Course; 
use Armincms\Coursera\Nova\CourseCategory; 
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;  
use PhoenixLib\NovaNestedTreeAttachMany\NestedTreeAttachManyField as CategorySelect;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Gutenberg\Cacheable;
use Zareismail\Gutenberg\Gutenberg; 
use Zareismail\Gutenberg\GutenbergWidget; 

class CoursesCard extends GutenbergWidget implements Cacheable
{         
    /**
     * The logical group associated with the widget.
     *
     * @var string
     */
    public static $group = 'Coursera';

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {  
        parent::boot($request, $layout);

        // $resource = static::resourceName();
        // $template = $this->bootstrapTemplate($request, $layout, $this->metaValue($resource::uriKey()));
 
        // $this->displayResourceUsing(function($attributes) use ($template) {   
        //     return $template->gutenbergTemplate($attributes)->render();
        // }, static::resourceName()); 
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {  
        return [ 
            Select::make(__('Sort Courses By'), 'config->ordering')
                ->options([
                    'created_at' => __('Creation Date'),
                    'updated_at' => __('Update Date'),
                    'hits' => __('Number of hits'),
                ])
                ->required()
                ->rules('required')
                ->default('created_at'),

            Select::make(__('Sort Courses As'), 'config->direction')
                ->options([
                    'asc' => __('Ascending'),
                    'desc' => __('Descending'), 
                ])
                ->required()
                ->rules('required')
                ->default('asc'), 

            Number::make(__('Number of resources'), 'config->count')
                ->default(1)
                ->min(1)
                ->required()
                ->rules('required', 'min:1')
                ->help(__('Number of items that should be display.')), 

            CategorySelect::make(__('Choose some categories'), 'config->categories', CourseCategory::class)
                ->useAsField()
                ->required()
                ->rules('required'),
        ];
    } 

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'courses' => $this->courses()->map->serializeForIndexWidget($this->getRequest()),
        ]);
    }

    /**
     * Query related tempaltes.
     * 
     * @param  [type] $request [description]
     * @param  [type] $query   [description]
     * @return [type]          [description]
     */
    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Coursera\Gutenberg\Templates\CoursesCard::class
        );
    }    

    protected function courses()
    {
        $callback = function($query) {
            $query->whereHas('category', function($query) {
                $categories = CourseCategory::newModel()->find($this->metaValue('categories'));
                $query->whereKey(
                    $categories->flatMap->descendants->merge($categories)->map->getKey()->toArray()
                );
            });
        };

        return Course::newModel()->when($this->metaValue('categories'), $callback)
            ->when($this->metaValue('direction') == 'desc', function($query) {
                $query->oldest($this->metaValue('ordering'));
            }, function($query) {
                $query->latest($this->metaValue('ordering'));
            })
            ->limit(intval($this->metaValue('count')) ?: 3)
            ->with('category')
            ->get();
    }
}
