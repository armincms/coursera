<?php

namespace Armincms\Coursera;

use Illuminate\Contracts\Support\DeferrableProvider;  
use Illuminate\Foundation\Support\Providers\AuthServiceProvider; 
use Laravel\Nova\Nova as LaravelNova;

class ServiceProvider extends AuthServiceProvider implements DeferrableProvider
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
        // $this->fragments();
        // $this->widgets();
        // $this->templates();
        // $this->menus();
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
            Nova\Episode::class, 
            Nova\Lesson::class, 
            Nova\Link::class, 
            Nova\Server::class, 
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [
            \Illuminate\Console\Events\ArtisanStarting::class,
            \Laravel\Nova\Events\ServingNova::class,
        ];
    }
}
