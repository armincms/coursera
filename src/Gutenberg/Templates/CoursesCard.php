<?php

namespace Armincms\Coursera\Gutenberg\Templates; 
 
use Armincms\Coursera\Nova\Course;
use Zareismail\Gutenberg\Variable;

class CoursesCard extends Template 
{       
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    { 
        $conversions = Course::newModel()->conversions()->implode(',');

        return [  
            Variable::make('items', __('HTML generated of blog items')), 

            Variable::make('id', __('Course Id')),

            Variable::make('name', __('Course Name')), 

            Variable::make('url', __('Course URL')),

            Variable::make('image', __(
                "Course image with available conversions:[{$conversions}]"
            )),

            Variable::make('hits', __('Course Hits')), 

            Variable::make('creation_date', __('Course Creation Date')),

            Variable::make('last_update', __('Course Update Date')), 

            Variable::make('summary', __('Course Summary')), 

            Variable::make('price', __('Course Price')), 
        ]; 
    } 
}
