<?php

namespace Armincms\Coursera\Cypress\Widgets; 

use Armincms\Categorizable\Cypress\Widgets\SingleCategory;

class CourseCategory extends SingleCategory
{       
    /**
     * The logical group associated with the widget.
     *
     * @var string
     */
    public static $group = 'Coursera';

    /**
     * Get the related model.
     * 
     * @param  string $relationship 
     * @return string
     */
    protected static function relationModel(string $relationship): string
    { 
        return \Armincms\Coursera\Models\CourseraCourse::class;
    }
  
    /**
     * Get the tag related content template name.
     * 
     * @return string
     */
    public static function resources(): array
    {
        return [
            \Armincms\Coursera\Nova\Course::class, 
        ];
    } 
  
    /**
     * Get the template handlers for given resourceName.
     * 
     * @return string
     */
    public static function handler(string $resourceName): array
    {
        return [
            \Armincms\Coursera\Gutenberg\Templates\CoursesCard::class,
        ];
    }  

    /**
     * Get resource for the given model.
     * 
     * @param  \Illuminate\Database\Eloqeunt\Model $model 
     * @return string      
     */
    public static function findResourceForModel($model)
    {
        return $model->resource;
    }

    /**
     * Get paginateg items.
     * 
     * @return \Illuminate\Pagination\AbstractPaginator
     */
    public function getPaginator()
    {
        return once(function() {
            return $this->belongsToMany('category');
        });
    }
}
