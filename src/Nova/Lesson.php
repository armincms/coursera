<?php

namespace Armincms\Coursera\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;

class Lesson extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Coursera\Models\CourseraLesson::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'episode'
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

            BelongsTo::make(__('Coursera Episode'), 'episode', Episode::class)
                ->required()
                ->rules('required')
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Text::make(__('Lesson Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required'),

            Slug::make(__('Lesson Slug'), 'slug')
                ->sortable()
                ->nullable()
                ->from('name')
                ->hideFromIndex()
                ->rules('unique:coursera_lessons,slug,{{resourceId}}'),

            $this->resourceUrls(),

            Number::make(__('Lesson Order'), 'order')
                ->required()
                ->rules('required')
                ->min(0)
                ->max(99),

            Boolean::make(__('Lesson IS Free'), 'config->free')
                ->default(false)
                ->sortable()
                ->help(__('Determine that everyone can view the lesson.')),

            Boolean::make(__('Lesson Is Downloadable'), 'config->download')
                ->default(false)
                ->sortable()
                ->help(__('Determine that user can download the lesson media.')),

            $this->medialibrary(__('Lesson Image')),

            Textarea::make(__('Lesson Summary'), 'summary')->hideFromIndex()->nullable(),

            Flexible::make(__('Coursera Media Links'), 'content')
                ->resolver(\Armincms\Coursera\Nova\Flexible\Resolvers\Links::class)
                ->onlyOnForms()
                ->button(__('Coursera Add Link'))
                ->addLayout('Coursera Media Link', 'items', [

                    Select::make(__('Coursera Server'), 'server_id')
                        ->options(Server::newModel()->get()->pluck('name', 'id'))
                        ->required()
                        ->rules('required')
                        ->displayUsingLabels(),

                    Select::make(__('Coursera Resolution'), 'resolution')
                        ->options($resolutions = forward_static_call([
                            Link::newModel(), 'resolutions'
                        ]))
                        ->default(array_keys($resolutions)[0] ?? null)
                        ->required()
                        ->rules('required')
                        ->displayUsingLabels(),

                    Select::make(__('Coursera Language'), 'locale')
                        ->options(collect(app('application.locales'))->pluck('name', 'locale')->all())
                        ->default('fa')
                        ->required()
                        ->rules('required')
                        ->displayUsingLabels(),

                    Text::make(__('Link Path'), 'path')
                        ->sortable()
                        ->required()
                        ->rules('required')
                        ->hideFromIndex(),
                ]),

            HasMany::make(__('Coursera Links'), 'links', Link::class),
        ];
    }
}
