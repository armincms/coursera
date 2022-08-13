<?php

namespace Armincms\Coursera\Nova\Filters;

use Armincms\Coursera\Nova\Course as CourseResource;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Course extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('coursera_course_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return CourseResource::newModel()->get()->map(function($course) {
            return [
                'name' => $course->name,
                'value' => $course->getKey(),
            ];
        });
    }
}
