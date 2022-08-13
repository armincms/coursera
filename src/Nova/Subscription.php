<?php

namespace Armincms\Coursera\Nova;

use Armincms\Contract\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;

class Subscription extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\Subscription::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'course', 'user'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('Coursera Course'), 'course', Course::class)
                ->withoutTrashed()
                ->sortable()
                ->required()
                ->readonly(),

            BelongsTo::make(__('User'), 'user', User::class)
                ->withoutTrashed()
                ->sortable()
                ->required()
                ->readonly()
                ->displayUsing(function($user) {
                    return $user->fullname() ?? $user->name;
                }),

            $this->dateField(__('Subscribed At'), 'created_at')->nullable(),

            KeyValue::make(__('Subscribtion Detail'), 'config')->nullable(),
        ];
    }

    /**
     * Get the filters available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\Subscriber(),

            new Filters\Course(),
        ];
    }
}
