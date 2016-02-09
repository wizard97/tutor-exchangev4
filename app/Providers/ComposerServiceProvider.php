<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      // Register view composers
      view()->composer(
        'templates.navbar', 'App\Http\ViewComposers\NavbarComposer'
      );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      // Give access to user model on every page
      view()->composer('*', function ($view) {
        $view->with('user', $this->app->make('auth')->user());
      });
    }
}
