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
use Armincms\Orderable\Contracts\Salable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseraCourse extends Model implements HasMedia, Hitsable, Authenticatable, HasMeta, Salable
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
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function($model) {
            if (! $model->isForceDeleting()) {
                $model->episodes()->get()->each->delete();
            } else {
                $model->episodes()->get()->each->forceDelete();
            }
        });
        static::restoring(function($model) {
            $model->episodes()->onlyTrashed()->get()->each->restore();
        });
    }

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
     * Query related CourseraServer.
     *
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function subscribers()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            'coursera_subscriptions'
        )->withPivot('config', 'created_at')->using(Subscription::class);
    }

    /**
     * Subscribe given user to the course.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @param array $config
     * @return mixed
     */
    public function subscribe($user, $config = [])
    {
        return $this->subscribers()->attach($user, compact('config'));
    }

    /**
     * Get subscription detail.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @return array
     */
    public function getSubscription($user = null): array
    {
        if (! $this->subscribed($user))  {
            return [
                'subscribed' => false,
                'imei' => null,
                'subscribed_at' => null,
            ];
        }

        $subscriber = $this->subscribers->find($user);

        return array_merge(
            [
                'subscribed_at' => data_get($subscriber, 'pivot.created_at'),
                'subscribed' => true,
                'imei' => null,
            ],
            (array) data_get($subscriber, 'pivot.config')
        );
    }

    /**
     * Determin that given user subscribed to the course.
     *
     * @param  \Illuminate\Database\Eloquent\Model $user
     * @return boolean
     */
    public function subscribed($user = null)
    {
        return ! is_null($user) && $this->subscribers->contains($user);
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
            'subscription' => $this->getSubscription($request->user()),
            'subscribed'=> $this->subscribed($request->user()),
            'content'   => $this->content,
            'episodes'  => $this->episodes->map->serializeForWidget($request)->toArray(),
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
            'images'    => $this->getFirstMediasWithConversions()->get('image'),
            'category'  => (array) optional($this->category)->serializeForIndexWidget(
                $request
            ),
        ];
    }

    /**
     * Get the sale price currency.
     *
     * @return decimal
     */
    public function saleCurrency(): string
    {
        return 'IRR';
    }

    /**
     * Get the sale price of the item.
     *
     * @return decimal
     */
    public function salePrice(): float
    {
        return floatval($this->price);
    }

    /**
     * Get the real price of the item.
     *
     * @return decimal
     */
    public function oldPrice(): float
    {
        return $this->salePrice();
    }

    /**
     * Get the item name.
     *
     * @return decimal
     */
    public function saleName(): string
    {
        return strval($this->name);
    }

    /**
     * Get the item description.
     *
     * @return decimal
     */
    public function saleDescription(): string
    {
        return strval($this->summary);
    }
}
