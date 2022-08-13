<?php

namespace Armincms\Coursera\Nova\Filters;

use Armincms\Contract\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Subscriber extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('user_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return User::newModel()->get()->map(function($user) {
            return [
                'name' => $user->fullname() ?: $user->name,
                'value' => $user->getKey(),
            ];
        });
    }
}
