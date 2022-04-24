<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable; 
use Armincms\Contract\Concerns\HasHits;
use Armincms\Contract\Concerns\InteractsWithFragments;
use Armincms\Contract\Concerns\InteractsWithMedia;
use Armincms\Contract\Concerns\InteractsWithMeta;
use Armincms\Contract\Concerns\InteractsWithUri; 
use Armincms\Contract\Concerns\Sluggable;
use Armincms\Contract\Contracts\Authenticatable;
use Armincms\Contract\Contracts\HasMedia;
use Armincms\Contract\Contracts\HasMeta;
use Armincms\Contract\Contracts\Hitsable;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraCourse extends Model implements HasMedia, Hitsable, Authenticatable, HasMeta
{    
    use Authorizable;
    use HasHits;
    use InteractsWithFragments;
    use InteractsWithMedia;
    use InteractsWithMeta;
    use InteractsWithUri;
    use SoftDeletes;    
    use Sluggable;    
    
    /**
     * Query related CourseraEpisode.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Query related CourseraEpisode.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function episodes()
    {
        return $this->hasMany(CourseraEpisode::class, 'course_id');
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
