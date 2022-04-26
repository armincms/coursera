<?php

namespace Armincms\Coursera\Gutenberg\Templates; 
 
use Armincms\Coursera\Nova\Lesson;
use Zareismail\Gutenberg\Variable;

class LessonDetail extends Template 
{       
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    { 
        $conversions = Lesson::newModel()->conversions()->implode(',');

        return [  
            Variable::make('items', __('HTML generated of blog items')), 

            Variable::make('id', __('Lesson Id')),

            Variable::make('name', __('Lesson Name')), 

            Variable::make('url', __('Lesson URL')),

            Variable::make('image', __(
                "Lesson image with available conversions:[{$conversions}]"
            )),

            Variable::make('hits', __('Lesson Hits')), 

            Variable::make('creation_date', __('Lesson Creation Date')),

            Variable::make('last_update', __('Lesson Update Date')), 

            Variable::make('summary', __('Lesson Summary')), 

            Variable::make('price', __('Lesson Price')), 
        ]; 
    } 
}
