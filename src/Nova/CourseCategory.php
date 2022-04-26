<?php

namespace Armincms\Coursera\Nova;
 
use Armincms\Categorizable\Nova\Category as Resource;    

class CourseCategory extends Resource
{     
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Coursera';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Categories');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Category');
    }
}
