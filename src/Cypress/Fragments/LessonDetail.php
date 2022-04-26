<?php

namespace Armincms\Coursera\Cypress\Fragments;
 
use Armincms\Contract\Concerns\InteractsWithModel; 
use Armincms\Contract\Contracts\Resource; 
use Zareismail\Cypress\Fragment; 
use Zareismail\Cypress\Contracts\Resolvable; 

class LessonDetail extends Fragment implements Resolvable, Resource
{   
    use InteractsWithModel; 

    /**
     * Get the resource Model class.
     * 
     * @return
     */
    public function model(): string
    {
        return \Armincms\Coursera\Nova\Lesson::$model;
    }

    /**
     * Apply custom query to the given query.
     *
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyQuery($request, $query)
    {
        return $query->unless(\Auth::guard('admin')->check(), function($query) {
            // return $query->published();
        });
    } 

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $request = app(\Zareismail\Cypress\Http\Requests\CypressRequest::class);

        return array_merge(parent::jsonSerialize(), [
            'resource' => $this->metaValue('resource')->serializeForDetailWidget($request)
        ]);
    } 
}
