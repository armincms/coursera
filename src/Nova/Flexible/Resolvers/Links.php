<?php

namespace Armincms\Coursera\Nova\Flexible\Resolvers;

use Armincms\Coursera\Nova\Link;
use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class Links implements ResolverInterface
{
    /**
     * get the field's value
     *
     * @param  mixed  $resource
     * @param  string $attribute
     * @param  Whitecube\NovaFlexibleContent\Layouts\Collection $layouts
     * @return Illuminate\Support\Collection
     */
    public function get($resource, $attribute, $layouts)
    {
        $links = $resource->links()->orderBy('order')->get();

        return $links->map(function($link) use ($layouts) {
            $layout = $layouts->find('items');

            if(!$layout) return;

            return $layout->duplicateAndHydrate($link->id, $link->toArray());
        })->filter();

    }

    /**
     * Set the field's value
     *
     * @param  mixed  $model
     * @param  string $attribute
     * @param  Illuminate\Support\Collection $groups
     * @return string
     */
    public function set($model, $attribute, $groups)
    {
        $class = get_class($model); 

        $class::saved(function ($model) use ($groups) {
            $groups->each(function($group, $index) use ($model) { 
                $callback = function() use ($model, $group, $index) {
                    $model->links()->updateOrCreate(
                        [ 'id' => data_get($group->getAttributes(), 'id') ], 
                        [
                            'order' =>  $index,
                            'server_id' => data_get($group->getAttributes(), 'server_id'),
                            'path' => data_get($group->getAttributes(), 'path'),
                            'locale' => data_get($group->getAttributes(), 'locale'),
                            'resolution' => data_get($group->getAttributes(), 'resolution'), 
                        ] 
                    ); 
                };

                forward_static_call([Link::newModel(), 'unguarded'], $callback);
            }); 
        });
    }
}
