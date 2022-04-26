<?php

namespace Armincms\Coursera\Cypress\Widgets;
 
use Laravel\Nova\Fields\Select; 
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\GutenbergWidget;

class LessonDetail extends GutenbergWidget
{      
    /**
     * Indicates if the widget should be shown on the component page.
     *
     * @var \Closure|bool
     */
    public $showOnComponent = false;

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

        $this->withMeta([
            'resource' => $request->resolveFragment()->metaValue('resource')
        ]);
    } 

    /**
     * Serialize the widget fro display.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    { 
        return (array) optional($this->metaValue('resource'))->serializeForWidget($this->getRequest());
    } 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {
        return [];
    } 

    /**
     * Query related display templates.
     * 
     * @return string
     */
    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\Coursera\Gutenberg\Templates\CourseDetail::class,
        );
    }
}
