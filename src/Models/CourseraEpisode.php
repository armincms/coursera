<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable;  
use Armincms\Contract\Contracts\Authenticatable;  
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraEpisode extends Model implements Authenticatable
{    
    use Authorizable; 
    use SoftDeletes;       
    
    /**
     * Query related CourseraLesson.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(CourseraCourse::class);
    }
    
    /**
     * Query related CourseraLesson.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function lessons()
    {
        return $this->hasMany(CourseraLesson::class, 'episode_id');
    }
}
