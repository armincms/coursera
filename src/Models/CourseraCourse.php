<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable; 
use Armincms\Contract\Concerns\HasHits;
use Armincms\Contract\Concerns\InteractsWithFragments;
use Armincms\Contract\Concerns\InteractsWithMedia;
use Armincms\Contract\Concerns\InteractsWithMeta;
use Armincms\Contract\Concerns\InteractsWithUri; 
use Armincms\Contract\Concerns\InteractsWithWidgets;
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
    use InteractsWithWidgets;
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
        return \Armincms\Coursera\Cypress\Fragments\CourseDetail::class;
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
            'content' => $this->content,
            'episodes' => $this->episodes->map->serializeForWidget($request)->toArray(),
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
            'price'     => $this->price,
            'summary'   => $this->summary,
            'url'       => $this->getUrl($request),
            'hits'      => $this->hits,
            'category'  => (array) optional($this->category)->serializeForIndexWidget($request),
            'images'    => $this->getFirstMediasWithConversions()->get('image'),
        ];
    }
}
