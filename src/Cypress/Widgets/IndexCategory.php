<?php

namespace Armincms\Coursera\Cypress\Widgets; 

use Armincms\Categorizable\Cypress\Widgets\IndexCategory as Widget;
use Zareismail\Gutenberg\Cacheable;

class IndexCategory extends Widget implements Cacheable
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
     * Apply custom query to the relationship query.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query        
     * @param  string  $relationship 
     * @return \Illuminate\Database\Eloquent\Builder                
     */
    protected function applyRelationshipQuery($query, $relationship)
    { 
        return $query->resources(\Armincms\Coursera\Nova\Course::class);
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
}
