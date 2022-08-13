<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Configurable;
use Illuminate\Database\Eloquent\Relations\Pivot as LaravelPivot;

class Subscription extends LaravelPivot
{
    use Configurable;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coursera_subscriptions';

    /**
     * Query related CourseraCourse.
     *
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function course()
    {
        return $this->belongsTo(CourseraCourse::class, 'coursera_course_id');
    }

    /**
     * Query related CourseraCourse.
     *
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
