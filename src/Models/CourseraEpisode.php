<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable;  
use Armincms\Contract\Concerns\InteractsWithMedia; 
use Armincms\Contract\Concerns\InteractsWithWidgets; 
use Armincms\Contract\Contracts\Authenticatable;
use Armincms\Contract\Contracts\HasMedia;  
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraEpisode extends Model implements Authenticatable, HasMedia
{    
    use Authorizable; 
    use InteractsWithMedia; 
    use InteractsWithWidgets; 
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
    /**
     * Serialize the model to pass into the client view for single item.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForDetailWidget($request)
    {
        return array_merge($this->serializeForIndexWidget($request), [
            'lessons' => $this->lessons->map->serializeForIndexWidget($request)->toArray(), 
        ]);
    }

    /**
     * Serialize the model to pass into the client view for collection of items.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForIndexWidget($request)
    {
        return [
            'id'        => $this->getKey(),
            'name'      => $this->name,  
            'order'   => $this->order, 
        ];
    }
}
