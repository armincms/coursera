<?php

namespace Armincms\Coursera\Models;

use Armincms\Categorizable\Models\Category as Model;

class Category extends Model  
{   
    /**
     * Query related CourseraEpisode.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function courses()
    {
        return $this->hasMany(CourseraCourse::class, 'category_id');
    }
}
