<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable;   
use Armincms\Contract\Concerns\Configurable; 
use Armincms\Contract\Concerns\HasHits; 
use Armincms\Contract\Concerns\InteractsWithFragments; 
use Armincms\Contract\Concerns\InteractsWithMedia;
use Armincms\Contract\Concerns\InteractsWithUri; 
use Armincms\Contract\Concerns\Sluggable;
use Armincms\Contract\Contracts\Authenticatable; 

use Armincms\Contract\Contracts\HasMedia;  
use Armincms\Contract\Contracts\Hitsable; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraLesson extends Model implements Authenticatable, HasMedia, Hitsable
{    
    use Authorizable;
    use Configurable;
    use HasHits; 
    use InteractsWithFragments;
    use InteractsWithMedia;
    use InteractsWithUri;
    use SoftDeletes;    
    use Sluggable;       
    
    /**
     * Query related CourseraEpisode.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function episode()
    {
        return $this->belongsTo(CourseraEpisode::class);
    }  
    
    /**
     * Query related CourseraServer.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function links()
    {
        return $this->hasMany(CourseraLink::class, 'lesson_id');
    } 

    /**
     * Get the corresponding cypress fragment.
     * 
     * @return 
     */
    public function cypressFragment(): string
    {
        return \Armincms\Coursera\Cypress\Fragments\Course::class;
    }
}
