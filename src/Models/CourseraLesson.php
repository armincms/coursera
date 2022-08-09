<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Authorizable;
use Armincms\Contract\Concerns\Configurable;
use Armincms\Contract\Concerns\HasHits;
use Armincms\Contract\Concerns\InteractsWithFragments;
use Armincms\Contract\Concerns\InteractsWithMedia;
use Armincms\Contract\Concerns\InteractsWithUri;
use Armincms\Contract\Concerns\InteractsWithWidgets;
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
    use InteractsWithWidgets;
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
        return \Armincms\Coursera\Cypress\Fragments\LessonDetail::class;
    }

    /**
     * Determin that the lesson is free to access.
     *
     * @param   $request
     * @return boolean
     */
    public function isFree()
    {
        return boolval($this->config('free', false));
    }

    /**
     * Serialize the model to pass into the client view for single item.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForDetailWidget($request)
    {
        $course = data_get($this->episode, 'course');

        return array_merge($this->serializeForIndexWidget($request), [
            'subscribed'=> $this->isFree() || $subscribed = optional($course)->subscribed($request->user()),
            'isFree'    => $this->isFree(),
            'episode'   => optional($this->episode)->serializeForDetailWidget($request),
            'course'    => optional($course)->serializeForDetailWidget($request),
            'links'     => $this->isFree() || $subscribed ?
                $this->links->map->serializeForWidget($request)
                : [],
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
            'order'     => $this->order,
            'summary'   => $this->summary,
            'url'       => $this->getUrl($request),
            'images'    => $this->getFirstMediasWithConversions()->get('image'),
        ];
    }
}
