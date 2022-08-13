<?php

namespace Armincms\Coursera\Nova;

use Armincms\Categorizable\Nova\Category;
use Armincms\Contract\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use PhoenixLib\NovaNestedTreeAttachMany\NestedTreeAttachManyField as CategorySelect;

class Course extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\CourseraCourse::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'category'
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

            Text::make(__('Course Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required'),

            Slug::make(__('Course Slug'), 'slug')
                ->sortable()
                ->nullable()
                ->from('name')
                ->hideFromIndex()
                ->rules('unique:coursera_courses,slug,{{resourceId}}'),

            $this->resourceUrls(),

            $this->currencyField(__('Course Price')),

            CategorySelect::make(__('Course Category'), 'category_id', Category::class)
                ->required()
                ->useAsField()
                ->useSingleSelect()
                ->rules('required')
                ->onlyOnForms(),

            BelongsTo::make(__('Course Category'), 'category', Category::class)
                ->exceptOnForms(),

            $this->medialibrary(__('Course Iamge'), 'image')
                ->sortable()
                ->required()
                ->rules('required'),

            Textarea::make(__('Course Summary'), 'summary')->hideFromIndex()->nullable(),

            Panel::make(__('Course Description'), [

                $this->resourceEditor(__('Course Content'), 'content')->nullable(),

                $this->resourceMeta(__('Course Meta'))->nullable(),
            ]),

            HasMany::make(__('Course Episodes'), 'episodes', Episode::class),

            BelongsToMany::make(__('Course Subscribers'), 'subscribers', User::class),
        ];
    }

    /**
     * Get the actions available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            Actions\RefreshSlugs::make(),
        ];
    }
}
