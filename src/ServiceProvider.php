<?php

namespace Armincms\Coursera;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\Gutenberg\Gutenberg;

class ServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Course::class => Policies\Course::class,
        Models\Episode::class => Policies\Episode::class,
        Models\Lesson::class => Policies\Lesson::class,
        Models\Link::class => Policies\Link::class,
        Models\Server::class => Policies\Server::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerPolicies();
        // $this->conversions();
        $this->resources();
        // $this->components();
        $this->fragments();
        $this->widgets();
        $this->templates();
        // $this->menus();
        \Event::subscribe(Listeners\Order::class);
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        LaravelNova::resources([
            Nova\Course::class,
            Nova\CourseCategory::class,
            Nova\Episode::class,
            Nova\Lesson::class,
            Nova\Link::class,
            Nova\Server::class,
            Nova\Subscription::class,
        ]);
    }

    /**
     * Register the application's Gutenberg fragments.
     *
     * @return void
     */
    protected function fragments()
    {
        Gutenberg::fragments([
            Cypress\Fragments\CourseDetail::class,
            Cypress\Fragments\LessonDetail::class,
        ]);
    }

    /**
     * Register the application's Gutenberg widgets.
     *
     * @return void
     */
    protected function widgets()
    {
        Gutenberg::widgets([
            Cypress\Widgets\CourseCategory::class,
            Cypress\Widgets\CourseDetail::class,
            Cypress\Widgets\CoursesCard::class,
            Cypress\Widgets\IndexCategory::class,
            Cypress\Widgets\LessonDetail::class,
        ]);
    }

    /**
     * Register the application's Gutenberg templates.
     *
     * @return void
     */
    protected function templates()
    {
        Gutenberg::templates([
            \Armincms\Coursera\Gutenberg\Templates\CourseDetail::class,
            \Armincms\Coursera\Gutenberg\Templates\CoursesCard::class,
            \Armincms\Coursera\Gutenberg\Templates\LessonDetail::class,
        ]);
    }
}
